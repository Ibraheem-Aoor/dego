<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Language;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Rules\AlphaDashWithoutSlashes;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    use Upload;

    public function index()
    {
        $data['defaultLanguage'] = Language::where('default_status', true)->first();
        $data['allLanguage'] = Language::select('id', 'name', 'short_name', 'flag', 'flag_driver')->where('status', 1)->get();
        $data['blogs'] = Blog::with('category', 'details')->orderBy('id', 'desc')->paginate(10);
        return view('admin.blogs.list', $data);
    }

    public function create()
    {
        $data['blogCategory'] = BlogCategory::where('status', 1)->orderBy('id', 'desc')->get();
        $data['defaultLanguage'] = Language::where('default_status', true)->first();
        $data['allLanguage'] = Language::select('id', 'name', 'short_name', 'flag', 'flag_driver')->where('status', 1)->get();
        return view('admin.blogs.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'title' => 'required|unique:blog_details,title',
            'slug' => 'required|unique:blog_details,slug',
            'description' => 'required',
            'description_image' => 'required|mimes:png,jpg,jpeg|max:50000',
            'blogThumb' => 'required|mimes:png,jpg,jpeg|max:50000',
        ]);

        try {
            if ($request->hasFile('description_image')) {
                $descriptionImage = $this->fileUpload($request->description_image, config('filelocation.blog.path'), null, null, 'webp', 60 );
                throw_if(empty($descriptionImage['path']), 'Description image could not be uploaded.');
            }
            if ($request->hasFile('blogThumb')) {
                $thumbnail = $this->fileUpload($request->blogThumb, config('filelocation.blog.path'), null, config('filelocation.blog.thumbSize'), 'webp', 60 );
                throw_if(empty($thumbnail['path']), 'Thumbnail image could not be uploaded.');
            }

            if ($request->hasFile('breadcrumb_image')) {
                $breadcrumbImage = $this->fileUpload($request->breadcrumb_image, config('filelocation.blog.path'), null, null,  'webp', 60);
                throw_if(empty($breadcrumbImage['path']), 'Breadcrumb image could not be uploaded.');
            }

            $response = Blog::create([
                'blog_category_id' => $request->category_id,
                "author_id" => Auth::user()->id,
                'blog_image' => $descriptionImage['path'] ?? null,
                'blog_image_driver' => $descriptionImage['driver'] ?? null,
                'blog_status' => $request->blog_status,
                'breadcrumb_status' => $request->breadcrumb_status ?? null,
                'breadcrumb_image' => $breadcrumbImage['path'] ?? null,
                'breadcrumb_image_driver' => $breadcrumbImage['driver'] ?? null,
                'blogThumb' => $thumbnail['path'] ?? null,
                'blogThumb_driver' => $thumbnail['driver'] ?? null,
            ]);

            throw_if(!$response, 'Something went wrong while storing blog data. Please try again later.');


            $response->details()->create([
                "title" => $request->title,
                "slug" => $request->slug,
                'language_id' => $request->language_id,
                'description' => $request->description,
            ]);
            return back()->with('success', 'Blog saved successfully.');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function blogEdit($id, $language = null)
    {
        try {
            $blog = Blog::with(['details' => function ($query) use ($language) {
                $query->where('language_id', $language);
            }])->where('id', $id)->firstOr(function () {
                throw new \Exception('The blog was not found.');
            });

            $data['pageEditableLanguage'] = Language::where('id', $language)->select('id', 'name', 'short_name')->first();
            $data['defaultLanguage'] = Language::where('default_status', true)->first();
            $data['blogCategory'] = BlogCategory::where('status', 1)->orderBy('id', 'desc')->get();
            $data['allLanguage'] = Language::select('id', 'name', 'short_name', 'flag', 'flag_driver')->where('status', 1)->get();
            return view('admin.blogs.edit', $data, compact('blog', 'language'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function blogUpdate(Request $request, $id, $language)
    {
        $request->validate([
            'category_id' => 'required|numeric|not_in:0|exists:blog_categories,id',
            'title' => 'required|string|min:3|max:200',
            'slug' => ['required', 'string', 'min:1', 'max:150',
                Rule::unique('blog_details', 'blog_id')->ignore($id)],
            'description' => 'nullable|string|min:3',
            'description_image' => 'nullable|mimes:png,jpg,jpeg|max:50000',
            'blogThumb' => 'nullable|mimes:png,jpg,jpeg|max:50000',
        ]);
        try {
            if ($request->hasFile('description_image')) {
                $descriptionImage = $this->fileUpload($request->description_image, config('filelocation.blog.path'), null, null,  'webp', 60);
                throw_if(empty($descriptionImage['path']), 'Description image could not be uploaded.');
            }
            if ($request->hasFile('blogThumb')) {
                $thumbnail = $this->fileUpload($request->blogThumb, config('filelocation.blog.path'), null, config('filelocation.blog.thumbSize'), 'webp', 60 );
                throw_if(empty($thumbnail['path']), 'Thumbnail image could not be uploaded.');
            }
            if ($request->hasFile('breadcrumb_image')) {
                $breadcrumbImage = $this->fileUpload($request->breadcrumb_image, config('filelocation.blog.path'), null, null,  'webp', 60);
                throw_if(empty($breadcrumbImage['path']), 'Breadcrumb image could not be uploaded.');
            }

            $blog = Blog::with("details")->where('id', $id)->firstOr(function () {
                throw new \Exception('Blog not found');
            });

            $response = $blog->update([
                'category_id' => $request->category_id,
                'blog_image' => $descriptionImage['path'] ?? $blog->blog_image,
                'blog_image_driver' => $descriptionImage['driver'] ?? $blog->blog_image_driver,
                'breadcrumb_status' => $request->breadcrumb_status ?? $blog->breadcrumb_status,
                'breadcrumb_image' => $breadcrumbImage['path'] ?? $blog->breadcrumb_image,
                'breadcrumb_image_driver' => $breadcrumbImage['driver'] ?? $blog->breadcrumb_image_driver,
                'blogThumb' => $thumbnail['path'] ?? $blog->blogThumb,
                'blogThumb_driver' => $thumbnail['driver'] ?? $blog->blogThumb_driver,
                'blog_status' => $request->blog_status,
            ]);

            throw_if(!$response, 'Something went wrong while storing blog data. Please try again later.');


            $blog->details()->updateOrCreate([
                'language_id' => $request->language_id,
            ],
                [
                    "title" => $request->title,
                    "slug" => $request->slug,
                    'description' => $request->description,
                ]
            );

            return back()->with('success', 'Blog saved successfully.');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    public function destroy(string $id)
    {
        try {
            $blog = Blog::where('id', $id)->firstOr(function () {
                throw new \Exception('No blog data found.');
            });
            $blog->delete();
            return redirect()->back()->with('success', 'Blog deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }


    }

    public function slugUpdate(Request $request)
    {
        $rules = [
            "blogId" => "required|exists:blogs,id",
            "newSlug" => ["required", "min:1", "max:100",
                new AlphaDashWithoutSlashes(),
                Rule::unique('blog_details', 'slug')->ignore($request->blogId),
                Rule::notIn(['login', 'register', 'signin', 'signup', 'sign-in', 'sign-up'])
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $blogId = $request->blogId;
        $newSlug = $request->newSlug;
        $blog = Blog::where('id', $blogId)->first();

        if (!$blog){
            return response([
                'success' => false,
                'message' => 'Blog Not Found.'
            ]);
        }

        $blog->details()->update([
            'slug' => $newSlug
        ]);

        return response([
            'success' => true,
            'slug' => $blog->slug
        ]);
    }

    public function blogSeo(Request $request, $id)
    {
        try {
            $blog = Blog::with("details")->where('id', $id)->firstOr(function () {
                throw new \Exception('Blog not found');
            });
            return view('admin.blogs.seo', compact('blog'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function blogSeoUpdate(Request $request, $id)
    {
        $request->validate([
            'page_title' => 'required|string|min:3|max:100',
            'meta_title' => 'required|string|min:3|max:100',
            'meta_keywords' => 'required|array',
            'meta_keywords.*' => 'required|string|min:1|max:300',
            'meta_description' => 'required|string|min:1|max:300',
            'meta_robots' => 'required',
            'og_description' => 'required',
            'seo_meta_image' => 'sometimes|required|mimes:jpeg,png,jpeg|max:2048'
        ]);


        try {
            $blog = Blog::with("details")->where('id', $id)->firstOr(function () {
                throw new \Exception('Blog not found');
            });

            if ($request->hasFile('seo_meta_image')) {
                try {
                    $image = $this->fileUpload($request->seo_meta_image, config('filelocation.pageSeo.path'), config('filesystems.default'),null, 'webp', 80, $blog->meta_image_driver, $blog->meta_image,);
                    if ($image) {
                        $pageSEOImage = $image['path'];
                        $pageSEODriver = $image['driver'] ?? 'local';
                    }
                } catch (\Exception $exp) {
                    return back()->with('error', 'Meta image could not be uploaded.');
                }
            }

            $blog->page_title = $request->page_title;
            $blog->meta_title = $request->meta_title;
            $blog->meta_keywords = $request->meta_keywords;
            $blog->meta_description = $request->meta_description;
            $blog->meta_robots = $request->meta_robots;
            $blog->og_description = $request->og_description;
            $blog->meta_image = $pageSEOImage ?? $blog->meta_image;
            $blog->meta_image_driver = $pageSEODriver ?? $blog->meta_image_driver;
            $blog->save();

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Seo has been updated.');
    }

    public function status($id){
        try {
            $blog = Blog::select('id', 'blog_status')
                ->where('id', $id)
                ->firstOr(function () {
                    throw new \Exception('Blog not found.');
                });

            $blog->blog_status = $blog->blog_status == 1 ? 0 : 1;
            $blog->save();

            return back()->with('success','Blog Status Changed Successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

}
