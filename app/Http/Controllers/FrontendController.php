<?php

namespace App\Http\Controllers;

use App\Helpers\UserSystemInfo;
use App\Mail\SendMail;
use App\Models\Admin;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogDetails;
use App\Models\City;
use App\Models\Content;
use App\Models\ContentDetails;
use App\Models\Country;
use App\Models\Destination;
use App\Models\Language;
use App\Models\Package;
use App\Models\DestinationVisitor;
use App\Models\Page;
use App\Models\PageDetail;
use App\Traits\Frontend;
use hisorange\BrowserDetect\Exceptions\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class FrontendController extends Controller
{
    use Frontend;

    public function __construct()
    {
        try {
            $connection = DB::connection()->getPdo();
        } catch (\Exception $exception) {
            \Cache::forget('ConfigureSetting');

            die("Unable to establish a connection to the database. Please check your connection settings and try again later");
        }
    }

    public function page(Request $request, $slug = '/')
    {

        $selectedTheme = ($request->has('theme')) ? $request->theme : (basicControl()->theme ?? 'relaxation');
        $homeVersion = basicControl()->home_style;
        if ($request->has('theme')) {
            $themeName = $request->theme;
            if (!in_array($themeName, array_keys(config('themes')))) {
                throw new \Exception("Invalid  Theme Request");
            }

            $selectedTheme = $request->theme;

            if($request->has('home_version')){
                $homeVersion = $request->home_version;
                if (!in_array($homeVersion, array_keys(config('themes')[$themeName]['home_version']))) {
                    throw new \Exception("Invalid  Home Request");
                }
            }

            $page = Page::where('home_name', $homeVersion)->first();
            if ($page) {
                $slug = $page->slug;
            }
        }

        $existingSlugs = collect([]);


        DB::table('pages')->select('slug')->get()
            ->map(function ($item) use ($existingSlugs) {
                $existingSlugs->push($item->slug);
            });
        if (!in_array($slug, $existingSlugs->toArray())) {
            abort(404);
        }
        try {
            $pageDetails = PageDetail::with('page')
                ->whereHas('page', function ($query) use ($slug, $selectedTheme, $homeVersion) {
                    $query->where(['slug' => $slug, 'template_name' => $selectedTheme]);
                })
                ->first();
            if ($request->has('theme') && $request->has('home_version')) {
                $status = 1;
            } else {
                $status = $pageDetails->page->status;
            }

            if (isset($status) && $status == 1) {

                $pageSeo = [
                    'page_title' => optional($pageDetails->page)->page_title,
                    'meta_title' => optional($pageDetails->page)->meta_title,
                    'meta_keywords' => optional($pageDetails->page)->meta_keywords,
                    'meta_description' => optional($pageDetails->page)->meta_description,
                    'og_description' => optional($pageDetails->page)->og_description,
                    'meta_robots' => optional($pageDetails->page)->MetaRobot,
                    'meta_image_driver' => optional($pageDetails->page)->meta_image_driver,
                    'meta_image' => optional($pageDetails->page)->meta_image,
                ];

                $sectionsData = $this->getSectionsData($pageDetails->sections, $pageDetails->content, $selectedTheme, $pageDetails);
                return view("themes.{$selectedTheme}.page", compact('sectionsData', 'pageSeo', 'pageDetails'));
            } else {
                return view(template() . 'errors.401');
            }
        } catch (\PDOException $exception) {
            $errorMessage = $exception->getMessage();
            die("Database connection failed: " . $errorMessage);
        } catch (\Exception $exception) {
            return redirect()->route('instructionPage')->with('error', $exception->getMessage());
        }
    }

    public function blogList(Request $request)
    {
        try {
            $data['pageSeo'] = Page::select([
                'page_title', 'name', 'breadcrumb_image', 'breadcrumb_image_driver', 'breadcrumb_status',
                'meta_title', 'meta_keywords', 'meta_description', 'og_description', 'meta_robots',
                'meta_image', 'meta_image_driver'
            ])->where('home_name', 'blogs')->where('template_name', basicControl()->theme ?? 'relaxation')->first();

            if (basicControl()->theme == 'adventure') {
                $data['blogContent'] = Content::with('contentDetails')
                    ->where('name', 'blog')
                    ->where('type', 'single')
                    ->first();
            }

            $search = $request->search;
            $category = $request->category;

            $data['blogs'] = Blog::with(['category:id,name,slug', 'details', 'author:id,username,image_driver,image'])
                ->where('blog_status', 1)
                ->when($search, function ($query) use ($search) {
                    $query->whereHas('details', function ($query) use ($search) {
                        $query->where('title', 'like', "%{$search}%");
                    });
                })
                ->when($category, function ($query) use ($category) {
                    $query->whereHas('category', function ($query) use ($category) {
                        $query->where('slug', 'like', "%{$category}%")
                            ->orWhere('id', $category);
                    });
                })
                ->orderByDesc('id')
                ->paginate(6);
            if (basicControl()->theme == 'relaxation') {
                $data['recentBlog'] = Blog::getRecentBlogs(null);
            }

            $data['categories'] = BlogCategory::where('status', 1)->get();

            return view(template() . 'blog.list', $data);

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function blogDetails($slug)
    {
        try {
            $blogDetails = BlogDetails::with('blog.author:id,username,image,image_driver')->where('slug', $slug)->firstOr(function () {
                throw new \Exception('The blog details was not found.');
            });
            $pageSeo = [
                'page_title' => optional($blogDetails->blog)->page_title,
                'meta_title' => optional($blogDetails->blog)->meta_title,
                'meta_keywords' => implode(',', optional($blogDetails->blog)->meta_keywords ?? []),
                'meta_description' => optional($blogDetails->blog)->meta_description,
                'og_description' => optional($blogDetails->blog)->og_description,
                'meta_robots' => optional($blogDetails->blog)->meta_robots,
                'meta_image' => getFile(optional($blogDetails->blog)->meta_image_driver, optional($blogDetails->blog)->meta_image),
                'breadcrumb_image' => optional($blogDetails->blog)->breadcrumb_image,
                'breadcrumb_image_driver' => optional($blogDetails->blog)->breadcrumb_image_driver,
                'breadcrumb_status' => optional($blogDetails->blog)->breadcrumb_status,
            ];

            $contents = Content::where('name', 'blog')
                ->with('contentDetails')
                ->where('type', 'single')
                ->firstOr(function () {
                    throw new \Exception('The content was not found for blog.');
                });

            $recents = Blog::getRecentBlogs($blogDetails->blog_id);

            $categoriesWithCounts = BlogCategory::with(['blog' => function ($query) {
                $query->latest();
            }])
                ->where('status', 1)
                ->withCount('blog')->orderBy('id', 'desc')->get()->map(function ($category) {
                    $category->category_name = $category->name;
                    return $category;
                });

            $data = [
                'pageSeo' => $pageSeo,
                'blogContent' => $contents,
                'blogDetails' => $blogDetails,
                'recents' => $recents,
                'categoriesWithCounts' => $categoriesWithCounts
            ];

            return view(template() . 'blog.details', $data);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function language($locale)
    {
        $language = Language::where('short_name', $locale)->first();
        if (!$language) {
            $locale = 'en';
        }

        session()->put('lang', $locale);
        session()->put('rtl', $language ? $language->rtl : 0);

        return redirect()->back();
    }

    public function contact(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|max:91',
            'subject' => 'required|max:100',
            'message' => 'required|max:1000',
        ]);

        try {
            $requestData = $request->except('_token', '_method');

            $name = $requestData['name'];
            $email_from = $requestData['email'];
            $subject = $requestData['subject'];
            $message = $requestData['message'] . "<br>Regards<br>" . $name;
            $from = $email_from;
            Mail::to(basicControl()->sender_email)->send(new SendMail($from, $subject, $message));

            return back()->with('success', 'Mail has been sent');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }


    }

    public function liveData(Request $request)
    {
        $value = $request->input('search');
        $packageData = Package::select('id', 'title', 'thumb', 'slug', 'thumb_driver', 'country')
            ->when($value, function ($query) use ($value) {
                $query->where('title', 'like', '%' . $value . '%');
            })
            ->where('status', 1)
            ->limit(10)
            ->get();

        $countries = Country::pluck('name', 'id')->toArray();

        foreach ($packageData as $package) {
            $package->url = getFile($package->thumb_driver, $package->thumb);
            $package->location = $countries[$package->country] ?? 'Unknown';
            $package->details = route('package.details', $package->slug);
            $package->title = htmlspecialchars_decode($package->title);
        }

        $cityData = City::query()
            ->select('id', 'name')
            ->when($value, function ($query) use ($value) {
                $query->where('name', 'like', '%' . $value . '%');
            })
            ->where('status', 1)
            ->limit(10)
            ->get();

        $cityData->transform(function ($city) {
            $city->icon = 'fa-light fa-location-arrow';
            $city->title = $city->name;
            return $city;
        });

        $destinationData = Destination::query()
            ->select('id', 'title')
            ->when($value, function ($query) use ($value) {
                $query->where('title', 'like', '%' . $value . '%');
            })
            ->where('status', 1)
            ->limit(10)
            ->get();

        $destinationData->transform(function ($destination) {
            $destination->logo = 'fa-light fa-plane-up';
            return $destination;
        });

        $initialData = $packageData->merge($cityData)->merge($destinationData);
        $searchData = $initialData->unique('title')->take(30)->values();

        return $searchData;
    }

    public function trackVisitor(Request $request)
    {
        $destinationId = $request->input('destination_id');
        $ipAddress = $request->ip();

        $key = "bouncing_time_{$destinationId}_{$ipAddress}";

        $bouncingTime = now();

        $visitor = new  DestinationVisitor();
        $visitor->destination_id = $destinationId;
        $visitor->ip_address = $ipAddress;
        $visitor->bouncing_time = $bouncingTime;
        $visitor->browser_info = UserSystemInfo::get_browsers();
        $visitor->os = UserSystemInfo::get_os();
        $visitor->device = UserSystemInfo::get_device();
        $visitor->save();

        Cache::put($key, $bouncingTime, now()->addMinutes(30));

        return response()->json(['message' => 'Destination visit traced']);
    }

}

