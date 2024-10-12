<?php

namespace App\Traits;

use App\Models\Blog;

;

use App\Models\ContentDetails;
use App\Models\Country;
use App\Models\Destination;
use App\Models\Package;

trait Frontend
{
    protected function getSectionsData($sections, $content, $selectedTheme, $pageDetails = null)
    {
        $basicControl = basicControl();

        $homeVersion = $basicControl->home_style;

        if (request()->has('theme') && request()->has('home_version')) {
            $selectedTheme = request()->theme;
            $homeVersion = request()->home_version;
        }

        if ($sections == null) {
            $data = ['support' => $content];
            return view("themes.$selectedTheme.support", $data)->toHtml();
        }

        $contentData = ContentDetails::with('content')
            ->whereHas('content', function ($query) use ($sections) {
                $query->whereIn('name', $sections);
            })
            ->get();

        foreach ($sections as $section) {
            $singleContent = $contentData->where('content.name', $section)->where('content.type', 'single')->first() ?? [];
            if ($section == 'blog' || $section == 'blog_two' || $section == 'relaxation_blog') {
                $data[$section] = [
                    'single' => $singleContent ? collect($singleContent->description ?? [])->merge($singleContent->content->only('media')) : [],
                    'multiple' => Blog::with('details', 'author:id,image,image_driver,username,name')
                        ->where('blog_status', 1)
                        ->latest()
                        ->when($selectedTheme === 'relaxation', function ($query) {
                            $query->limit(4);
                        })
                        ->when($selectedTheme === 'adventure' && $homeVersion === 'home_103', function ($query) {
                            $query->limit(3);
                        })
                        ->when($selectedTheme === 'adventure' && isset($pageDetails->page->home_name) && $pageDetails->page->home_name == 'home_103', function ($query) {
                            $query->limit(3);
                        })
                        ->when($selectedTheme === 'adventure' && in_array($homeVersion, ['home_101', 'home_102']) && $pageDetails->page->home_name != 'home_103', function ($query) {
                            $query->limit(4);
                        })
                        ->get()
                ];
            } elseif (in_array($section, ['relaxation_adventure', 'relaxation_destination', 'destination', 'destination_two', 'destination_three'])) {
                $destinations = Destination::with( 'countryTake:id,name', 'stateTake:id,name', 'cityTake:id,name', 'reaction')
                    ->where('status', 1)
                    ->withCount('package')
                    ->when($section == 'relaxation_adventure', function ($query) {
                        $query->with('countryTake')->withCount('reaction');
                    })
                    ->when($section == 'relaxation_destination', function ($query) {
                        $query->take(6);
                    })
                    ->when(in_array($section, ['destination', 'destination_three']), function ($query) {
                        $query->take(4);
                    })
                    ->orderBy('package_count', 'DESC')
                    ->get();


                $data[$section] = [
                    'single' => $singleContent ? collect($singleContent->description ?? [])->merge($singleContent->content->only('media')) : [],
                    'destinations' => $destinations
                ];
            } elseif (in_array($section, [
                'relaxation_popular_tour',
                'popular_tour',
                'popular_two',
                'popular_tour_three',
                'holiday',
                'holiday_two',
                'holiday_three',
            ])) {
                $limit = in_array($section, ['relaxation_popular_tour', 'popular_tour']) ? 4 : ($section == 'holiday_two' ? 8 : null);

                $packages = Package::with([
                    'category',
                    'countryTake:id,name',
                    'stateTake:id,name',
                    'cityTake:id,name',
                    'review',
                    'reaction',
                ])
                    ->where('status', 1)
                    ->withCount(['review', 'booking as booking_count' => function ($query) {
                        $query->whereIn('status', [1,2]);
                    }])
                    ->withAvg('review', 'rating')
                    ->orderByDesc('booking_count')
                    ->orderByDesc('id')
                    ->when($limit, function ($query) use ($limit) {
                        $query->take($limit);
                    })
                    ->when($section == 'popular_two', function ($query) {
                        $query->take(8);
                    })
                    ->get()
                    ->map(function ($package) {
                        $package->review_avg_rating = $package->review_avg_rating ?? 0;
                        return $package;
                    });

                $data[$section] = [
                    'single' => $singleContent ? collect($singleContent->description ?? [])->merge($singleContent->content->only('media')) : [],

                    'packages' => $packages
                ];
            } elseif (in_array($section, ['hero', 'hero_two'])) {
                $multipleContents = $contentData->where('content.name', $section)->where('content.type', 'multiple')->values()->map(function ($multipleContentData) {
                    return collect($multipleContentData->description)->merge($multipleContentData->content->only('media'));
                });

                $data[$section] = [
                    'single' => $singleContent ? collect($singleContent->description ?? [])->merge($singleContent->content->only('media')) : [],
                    'multiple' => $multipleContents,
                    'place' => Country::where('status', 1)->get()
                ];
            } else {
                $multipleContents = $contentData->where('content.name', $section)->where('content.type', 'multiple')->values()->map(function ($multipleContentData) {
                    return collect($multipleContentData->description)->merge($multipleContentData->content->only('media'));
                });

                $data[$section] = [
                    'single' => $singleContent ? collect($singleContent->description ?? [])->merge($singleContent->content->only('media')) : [],
                    'multiple' => $multipleContents
                ];
            }

            $ActiveTheme = $selectedTheme;

            $replacement = view("themes.{$ActiveTheme}.sections.{$section}", $data)->toHtml();

            $content = str_replace('<div class="custom-block" contenteditable="false"><div class="custom-block-content">[[' . $section . ']]</div>', $replacement, $content);
            $content = str_replace('<span class="delete-block">×</span>', '', $content);
            $content = str_replace('<span class="up-block">↑</span>', '', $content);
            $content = str_replace('<span class="down-block">↓</span></div>', '', $content);
            $content = str_replace('<p><br></p>', '', $content);
        }

        return $content;
    }
}
