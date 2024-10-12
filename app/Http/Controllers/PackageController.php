<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Content;
use App\Models\FavouriteList;
use App\Models\Language;
use App\Models\Package;
use App\Models\PackageCategory;
use App\Models\PackageVisitor;
use App\Models\Page;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpseclib3\File\ASN1\Maps\EncryptedData;

class PackageController extends Controller
{
    public function packageList(Request $request)
    {
        try {



            $ratings = $request->input('rating', []);

            $data['categories'] = PackageCategory::with('packages')->where('status', 1)->withCount('packages')->get();

            $data['pageSeo'] = Page::where('name', 'packages')
                ->select('page_title', 'name', 'breadcrumb_image', 'breadcrumb_image_driver', 'breadcrumb_status', 'meta_title', 'meta_keywords', 'meta_description', 'og_description', 'meta_robots', 'meta_image', 'meta_image_driver')
                ->where('template_name', basicControl()->theme??'relaxation')
                ->first();

            $baseQuery = Package::with(['category:id,name', 'reaction:id,user_id,package_id,reaction','review:id,rating,review,package_id',
                'countryTake:id,name', 'stateTake:id,name', 'cityTake:id,name'])
                ->orderBy('id', 'DESC')
                ->where('status', 1);

            $data['durations'] = $baseQuery->distinct()->orderBy('duration')->pluck('duration');

            list($min, $max) = array_pad(explode(';', $request->my_range, 2), 2, 0);
            $data['max'] = $request->has('my_range') ? $max : ($baseQuery->min('adult_price') ?? 10);
            $data['min'] = $request->has('my_range') ? $min : ($baseQuery->max('adult_price') ?? 1000);
            $data['rangeMin'] = $baseQuery->min('adult_price') ?? 10;
            $data['rangeMax'] = $baseQuery->max('adult_price') ?? 1000;

            $data['packages'] = $baseQuery
                ->when($request->destination, function ($q) use ($request) {
                    $q->whereHas('destination', fn($q) => $q->where('slug', 'like', "%{$request->destination}%"));
                })
                ->when($request->citySearch, function ($q) use ($request) {
                    $q->whereHas('destination', fn($q) => $q->where('title', 'like', "%{$request->citySearch}%"));
                })
                ->when($request->type, function ($q) use ($request) {
                    $q->whereHas('category', fn($q) => $q->where('name', 'like', '%' . kebab2Title($request->type) . '%'));
                })
                ->when($request->search, function ($q) use ($request) {
                    $q->where('title', 'like', "%{$request->search}%");
                })
                ->when($request->my_range, function ($q) use ($min, $max) {
                    $q->whereBetween('adult_price', [$min, $max]);
                })
                ->when(is_array($request->duration), function ($q) use ($request) {
                    $q->whereIn('duration', $request->duration);
                })
                ->when(is_array($request->category), function ($q) use ($request) {
                    $q->whereIn('package_category_id', $request->category);
                })
                ->when(!empty($ratings), function ($q) use ($ratings) {
                    if (is_string($ratings)) {
                        $ratings = explode(',', $ratings);
                    }

                    if (is_array($ratings)) {
                        $minRating = min(array_map('floatval', $ratings));
                        $maxRating = max(array_map('floatval', $ratings));

                        $q->whereHas('review', function ($q) use ($minRating, $maxRating) {
                            $q->selectRaw('AVG(reviews.rating) as average_rating')
                                ->havingRaw('AVG(reviews.rating) BETWEEN ? AND ?', [$minRating, $maxRating]);
                        });
                    }
                })
                ->with(['reviewSummary'])
                ->paginate(10);

            $data['packages']->getCollection()->transform(function ($package) {
                $package->average_rating = $package->reviewSummary->average_rating ?? 0;
                $package->review_count = $package->reviewSummary->review_count ?? 0;
                return $package;
            });

            if ($request->ajax()) {
                return response()->json([
                    'html' => view(template().'package.partials.list', $data)->render(),
                ]);
            }

            return view(template() . 'package.list', $data);
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong, Please try again.');
        }
    }
    public function packageDetails(Request $request, $slug = null)
    {



        try {
            $data['package'] = Package::withAllRelations()
                ->where('slug', $slug)
                ->withCount('reviews')
                ->firstOr(function () {
                    throw new \Exception('The package was not found.');
                });

            $pageSeoData = Page::where('home_name', 'packages')
                ->select('breadcrumb_image', 'breadcrumb_image_driver', 'breadcrumb_status')
                ->where('template_name', basicControl()->theme ?? 'relaxation')
                ->first()
                ->toArray();

            $otherSeo = [
                'page_title' => $data['package']->page_title,
                'meta_title' => $data['package']->meta_title,
                'meta_keywords' => $data['package']->meta_keywords,
                'meta_description' => $data['package']->meta_description,
                'og_description' => $data['package']->og_description,
                'meta_robots' => $data['package']->MetaRobot,
                'meta_image_driver' => $data['package']->meta_image_driver,
                'meta_image' => $data['package']->meta_image,
            ];
            $data['pageSeo'] = array_merge($otherSeo, $pageSeoData);

            $data['bookingDate'] = $data['package']->getBookingDates();
            for ($rating = 1; $rating <= 5; $rating++) {
                $data['percentage' . $rating] = $data['package']->getReviewPercentage($rating);
            }
            $data['booking'] = Auth::check()
                ? Auth::user()->getBookingForPackage($data['package']->id)
                : null;

            $data['content'] = Content::where('name','package')
                ->with('contentDetails')
                ->where('type', 'single')
                ->firstOr(function () {
                    throw new \Exception('The content was not found for package.');
                });

            $data['categories'] = PackageCategory::orderBy('id', 'DESC')->where('status', 1)->get();

            return view(template() . 'package.details', $data, compact('data'));

        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong, Please try again.');
        }
    }
}
