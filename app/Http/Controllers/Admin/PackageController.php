<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Destination;
use App\Models\GoogleMapApi;
use App\Models\Package;
use App\Models\PackageCategory;
use App\Models\State;
use App\Traits\Notify;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class PackageController extends Controller
{
    use Upload, Notify;

    public function list(Request $request)
    {

        $query = DB::table('packages')
            ->selectRaw('COUNT(*) as totalPackage,
                 SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as totalActivePackage,
                 SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as totalInactivePackage,
                 SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) as totalCreatedToday,
                 SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) as totalCreatedThisMonth',
                [now()->startOfDay(), now()->startOfMonth()])
            ->first();

        $data['totalPackage'] = $query->totalPackage;
        $data['totalActivePackage'] = $query->totalActivePackage;
        $data['totalInactivePackage'] = $query->totalInactivePackage;
        $data['totalCreatedToday'] = $query->totalCreatedToday;
        $data['totalCreatedThisMonth'] = $query->totalCreatedThisMonth;
        $data['totalActivePercentage'] = ($data['totalActivePackage'] / $data['totalPackage']) * 100;
        $data['totalInactivePercentage'] = ($data['totalInactivePackage'] / $data['totalPackage']) * 100;
        $data['totalTotalCreatedThisMonthPercentage'] = ($data['totalCreatedThisMonth'] / $data['totalPackage']) * 100;
        $data['totalTotalCreatedTodayPercentage'] = ($data['totalCreatedToday'] / $data['totalPackage']) * 100;
        $data['destination'] = $request->destination;
        $data['category'] = $request->category;

        return view('admin.package.list', $data);
    }

    public function search(Request $request)
    {
        $search = $request->search['value']??null;
        $filterName = $request->filterName;
        $filterStart = $request->startDate;
        $filterEnd = $request->endDate;
        $destination = $request->destination;
        $category = $request->category;
        $filterStatus = $request->input('filterStatus');


        $packages = Package::query()->with(['category', 'destination:id,title', 'countryTake', 'stateTake', 'cityTake'])
            ->orderBy('id', 'DESC')
            ->when(!empty($search), function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%");
            })
            ->when(!empty($filterName), function ($query) use ($filterName) {
                $query->where('title', 'LIKE', "%{$filterName}%");
            })
            ->when(isset($filterStart) && !empty($filterStart), function ($query) use ($filterStart) {
                return $query->whereDate('created_at', '>=', $filterStart);
            })
            ->when(isset($filterEnd) && !empty($filterEnd), function ($query) use ($filterEnd) {
                return $query->whereDate('created_at', '<=', $filterEnd);
            })
            ->when(isset($destination), function ($query) use ($destination) {
                return $query->where('destination_id', $destination);
            })
            ->when(isset($category), function ($query) use ($category) {
                return $query->where('package_category_id', $category);
            })
            ->when(isset($filterStatus), function ($query) use ($filterStatus) {
                if ($filterStatus == "all") {
                    return $query->where('status', '!=', null);
                }
                return $query->where('status', $filterStatus);
            });

        return DataTables::of($packages)
            ->addColumn('checkbox', function ($item) {
                return ' <input type="checkbox" id="chk-' . $item->id . '"
                                       class="form-check-input row-tic tic-check" name="check" value="' . $item->id . '"
                                       data-id="' . $item->id . '">';
            })
            ->addColumn('package', function ($item) {
                $image = $item->thumb;
                if (!$image) {
                    $firstLetter = substr($item->title, 0, 1);
                    return '<div class="avatar avatar-sm avatar-soft-primary avatar-circle d-flex justify-content-start gap-2 w-100">
                                <span class="avatar-initials">' . $firstLetter . '</span>
                                <p class="avatar-initials ms-3">' . $item->title . '</p>
                            </div>';

                } else {
                    $url = getFile($item->thumb_driver, $item->thumb);

                    return '<a class="d-flex align-items-center me-2" href="javascript:void(0)">
                                <div class="flex-shrink-0">
                                  <div class="avatar avatar-sm avatar-circle">
                                        <img class="avatar-img" src="' . $url . '" alt="Image Description">
                                  </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                  <h5 class="text-hover-primary mb-0">' .  $item->title . '</h5>
                                </div>
                              </a>';

                }
            })
            ->addColumn('category', function ($item) {
                return optional($item->category)->name;
            })
            ->addColumn('start_point', function ($item) {
                $shortened_start = substr($item->start_point, 0, 20);
                if (strlen($item->start_point) > 20) {
                    $shortened_start .= '...';
                }
                return $shortened_start;
            })
            ->addColumn('end_point', function ($item) {
                $shortened_end = substr($item->end_point, 0, 20);
                if (strlen($item->end_point) > 20) {
                    $shortened_end .= '...';
                }
                return $shortened_end;
            })
            ->addColumn('destination', function ($item) {
                return optional($item->destination)->title;
            })
            ->addColumn('status', function ($item) {
                if ($item->status == 0) {
                    return ' <span class="badge bg-soft-warning text-warning">
                                    <span class="legend-indicator bg-warning"></span> ' . trans('Inactive') . '
                                </span>';
                } else if ($item->status == 1) {
                    return '<span class="badge bg-soft-success text-success">
                                    <span class="legend-indicator bg-success"></span> ' . trans('Active') . '
                                </span>';

                }
            })
            ->addColumn('create-at', function ($item) {
                return dateTime($item->created_at);
            })
            ->addColumn('action', function ($item) {
                $editUrl = route('admin.package.edit', $item->id);
                $statusUrl = route('admin.package.status', $item->id);
                $bookingUrl = route('admin.all.booking', ['package' => $item->id]);
                $seoUrl = route('admin.package.seo', $item->id);
                return '<div class="btn-group" role="group">
                      <a href="' . $editUrl . '" class="btn btn-white btn-sm edit_user_btn">
                        <i class="bi-pencil-fill me-1"></i> ' . trans("Edit") . '
                      </a>
                    <div class="btn-group">
                      <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="userEditDropdown" data-bs-toggle="dropdown" aria-expanded="false"></button>
                      <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="userEditDropdown">
                          <a class="dropdown-item discountBtn" href="javascript:void(0)"
                           data-route="' . route("admin.package.discount", $item->id) . '"
                           data-discount_type = "' . $item->discount_type . '"
                           data-discount_amount = "' . $item->discount_amount . '"
                           data-bs-toggle="modal"
                           data-bs-target="#discountModal">
                            <i class="bi bi-currency-dollar"></i>
                           ' . trans("Discount") . '
                        </a>
                        <a class="dropdown-item statusBtn" href="javascript:void(0)"
                           data-route="' . $statusUrl . '"
                           data-bs-toggle="modal"
                           data-bs-target="#statusModal">
                            <i class="bi bi-check-circle"></i>
                           ' . trans("Status") . '
                        </a>
                        <a class="dropdown-item" href="' . $bookingUrl . '"

                        >
                            <i class="bi bi-check-square"></i>
                           ' . trans("Tour Lists") . '
                        </a>
                        <a class="dropdown-item" href="' . $seoUrl . '"

                        >
                            <i class="fa-light fa-magnifying-glass"></i>
                           ' . trans("Seo") . '
                        </a>
                        <a class="dropdown-item deleteBtn" href="javascript:void(0)"
                           data-route="' . route("admin.package.delete", $item->id) . '"
                           data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="bi bi-trash"></i>
                           ' . trans("Delete") . '
                        </a>
                      </div>
                    </div>
                  </div>';
            })->rawColumns(['action', 'checkbox', 'create-at', 'package', 'status', 'category', 'start_point', 'end_point', 'destination'])
            ->make(true);
    }

    public function add()
    {
        $data['categories'] = PackageCategory::select('id', 'name')->where('status', 1)->get();
        $data['destinations'] = Destination::select('id', 'title')->where('status', 1)->orderBy('title','ASC')->get();

        return view('admin.package.add', $data);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'adult_price' => 'required|numeric|min:1',
            'children_price' => 'required|numeric|min:1',
            'infant_price' => 'required|numeric|min:1',
            'destination_id' => 'required|integer|exists:destinations,id',
            'tourDuration' => 'required|string',
            'category_id' => 'required|integer|exists:package_categories,id',
            'startPoint' => 'required|string|max:255',
            'startMessage' => 'nullable|string|max:255',
            'endMessage' => 'nullable|string|max:255',
            'endPoint' => 'nullable|string|max:255',
            'minimumTravelers' => 'required|integer|min:1',
            'maximumTravelers' => 'required|integer|gte:minimumTravelers',
            'facility.*' => 'nullable',
            'excluded.*' => 'nullable',
            'expect.*' => 'nullable',
            'expect_details.*' => 'nullable',
            'slug' => 'required|string|unique:packages,slug|max:255',
            'details' => 'required|string',
            'thumb' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'video' => 'sometimes|nullable',
            'images' => 'required|array',
            'images.*' => 'required|mimes:jpeg,png,jpg|max:10240',
        ]);
        try {
            $thumbData = $this->handleFileUpload($request->file('thumb'), 'package_thumb');

            $apiKey = $this->getGoogleApiKey();
            $destination = Destination::where('id', $request->destination_id)->firstOr(function () {
                throw new \Exception('Destination not found.');
            });

            list($lat, $long, $map) = $this->getMapData($destination, $request->startPoint, $apiKey);

            $package = $this->createPackage($validatedData, $destination, $lat, $long, $map, $thumbData);

            $this->handleImagesUpload($request->images, $package);

            return back()->with('success', 'Package added successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    private function handleFileUpload($file, $type)
    {
        $photo = $this->fileUpload($file, config("filelocation.{$type}.path"), null, config("filelocation.{$type}.size"), 'webp', 80);
        return ['path' => $photo['path'], 'driver' => $photo['driver']];
    }

    private function getGoogleApiKey()
    {
        $api = GoogleMapApi::where('status', 1)->firstOr(function () {
            throw new \Exception('Api Key not found.');
        });

        return $api->api_key;
    }

    private function getMapData($destination, $startPoint, $apiKey)
    {
        $country = Country::where('id', $destination->country)->firstOr(function () {
            throw new \Exception('Country not found.');
        });
        $state = State::where('id', $destination->state)->firstOr(function () {
            throw new \Exception('State not found.');
        });
        $city = City::where('id', $destination->city)->firstOr(function () {
            throw new \Exception('City not found.');
        });

        $result = getMap($city->name, $state->name, $country->name, $apiKey, $startPoint);
        $lat = $result[0];
        $long = $result[1];
        $map = "https://www.google.com/maps/embed/v1/place?key=$apiKey&q=$lat,$long";

        return [$lat, $long, $map];
    }

    private function createPackage($data, $destination, $lat, $long, $map, $thumbData)
    {
        return Package::create([
            'package_category_id' => $data['category_id'],
            'destination_id' => $destination->id,
            'title' => $data['name'],
            'slug' => $data['slug'],
            'adult_price' => $data['adult_price'],
            'children_Price' => $data['children_price'],
            'infant_price' => $data['infant_price'],
            'duration' => $data['tourDuration'],
            'start_point' => $data['startPoint'],
            'startMessage' => $data['startMessage'],
            'endMessage' => $data['endMessage'],
            'end_point' => $data['endPoint'],
            'minimumTravelers' => $data['minimumTravelers'],
            'maximumTravelers' => $data['maximumTravelers'],
            'facility' => $data['facility'],
            'excluded' => $data['excluded'],
            'expected' => $this->formatExpectations($data['expect'], $data['expect_details']),
            'description' => $data['details'],
            'lat' => $lat,
            'long' => $long,
            'thumb' => $thumbData['path'],
            'thumb_driver' => $thumbData['driver'],
            'video' => $data['video'],
            'map' => $map,
            'city' => $destination->city,
            'state' => $destination->state,
            'country' => $destination->country,
        ]);
    }

    private function handleImagesUpload($images, $package)
    {
        foreach ($images as $img) {
            $image = $this->fileUpload($img, config('filelocation.package.path'), null, config('filelocation.package.size'), 'webp', 80);
            $package->media()->updateOrCreate([
                'image' => $image['path'],
                'driver' => $image['driver'],
            ]);
        }
    }

    private function formatExpectations($expects, $expectDetails)
    {
        return array_map(function ($expect, $expectDetail) {
            return [
                'expect' => $expect,
                'expect_detail' => $expectDetail
            ];
        }, $expects, $expectDetails);
    }

    public function edit($id)
    {
        try {
            $package = Package::with('media', 'countryTake:id,name', 'stateTake:id,name', 'cityTake:id,name')->where('id', $id)
                ->firstOr(function () {
                    throw new \Exception('Package not found.');
                });

            $data = [
                'package' => $package,
                'categories' => PackageCategory::select('id', 'name')->where('status', 1)->get(),
                'destinations' => Destination::select('id', 'title')->where('status', 1)->get(),
                'images' => $package->media->map(fn($item) => getFile($item->driver, $item->image))->toArray(),
                'oldimg' => $package->media->pluck('id')->toArray(),
            ];

            return view('admin.package.edit', $data);
        }catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => ['required', 'string', Rule::unique('packages')->ignore($id),],
            'adult_price' => ['required', 'numeric', 'min:1'],
            'children_price' => ['required', 'numeric', 'min:1'],
            'infant_price' => ['required', 'numeric', 'min:1'],
            'category_id' => 'required|integer|exists:package_categories,id',
            'destination_id' => 'required|integer|exists:destinations,id',
            'tourDuration' => 'required|string',
            'startPoint' => 'required|string|max:255',
            'startMessage' => 'nullable|string|max:255',
            'endMessage' => 'nullable|string|max:255',
            'endPoint' => 'nullable|string|max:255',
            'minimumTravelers' => 'required|integer|min:1',
            'maximumTravelers' => 'required|integer|gte:minimumTravelers',
            'facility.*' => 'nullable',
            'excluded.*' => 'nullable',
            'expect.*' => 'nullable',
            'expect_details.*' => 'nullable',
            'details' => 'required|string',
            'thumb' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048',
            'video' => 'sometimes|nullable',
            'preloaded' => 'sometimes|array',
            'images' => ['required_without:preloaded', 'array'],
            'images.*' => ['required_without:preloaded', 'image', 'mimes:jpeg,png,jpg', 'max:10240'],
        ]);
        try {
            $package = Package::where('id', $id)->firstOr(function () {
                throw new \Exception('Destination not found.');
            });

            if (!$package) {
                return back()->with('error', 'Package Is Missing');
            }

            $expectInfo = $this->formatExpectations(
                $request->input('expect', []),
                $request->input('expect_details', [])
            );

            if ($request->destination_id != $package->destination_id) {
                $api = GoogleMapApi::where('status', 1)->firstOr(function () {
                    throw new \Exception('Api Key not found.');
                });

                $newDestination = Destination::where('id', $request->destination_id)->firstOr(function () {
                    throw new \Exception('Destination not found.');
                });
                $country = Country::where('id', $newDestination->country)->firstOr(function () {
                    throw new \Exception('Country not found.');
                });
                $state = State::where('id', $newDestination->state)->firstOr(function () {
                    throw new \Exception('State not found.');
                });

                $city = City::where('id', $newDestination->city)->firstOr(function () {
                    throw new \Exception('City not found.');
                });

                $result = getMap($city->name, $state->name, $country->name, $api->api_key, $request->address);

                if (count($result) == 3) {
                    list($lat, $long) = $result;
                    $map = "https://www.google.com/maps/embed/v1/place?key=$api->api_key&q=$lat,$long";
                } else {
                    list($lat, $long) = $result;
                    $map = "https://www.google.com/maps/embed/v1/place?key=$api->api_key&q=$lat,$long";
                }

                $package->destination_id = $request->destination_id;
                $package->city = $city->id;
                $package->state = $state->id;
                $package->country = $country->id;
                $package->lat = $lat;
                $package->long = $long;
                $package->map = $map;
                $package->save();
            }

            $package->package_category_id = $request->category_id;
            $package->title = $request->name;
            $package->slug = $request->slug;
            $package->adult_price = $request->adult_price;
            $package->children_price = $request->children_price;
            $package->infant_price = $request->infant_price;
            $package->duration = $request->tourDuration;
            $package->address = $request->address ?? null;
            $package->start_point = $request->startPoint;
            $package->end_point = $request->endPoint;
            $package->startMessage = $request->startMessage;
            $package->endMessage = $request->endMessage;
            $package->minimumTravelers = $request->minimumTravelers;
            $package->maximumTravelers = $request->maximumTravelers;
            $package->facility = $request->facility;
            $package->excluded = $request->excluded;
            $package->expected = $expectInfo;
            $package->description = $request->details;
            $package->video = $request->video;
            $package->save();

            if ($request->hasFile('thumb')) {
                $thumb = $this->fileUpload($request->thumb, config('filelocation.package_thumb.path'), null, config('filelocation.package_thumb.size'), 'webp', 80);
                $package->update(['thumb' => $thumb['path'], 'thumb_driver' => $thumb['driver']]);
            }

            $old = $request->preloaded;
            $packageMedia = $package->media->where('package_id', $id)->whereNotIn('id', $old);

            foreach ($packageMedia as $item) {
                $this->fileDelete($item->image_driver, $item->image);
                $item->delete();
            }

            $path = [];
            if ($request->hasFile('images')) {
                foreach ($request->images as $img) {
                    $image = $this->fileUpload($img, config('filelocation.package.path'), null, config('filelocation.package.size'), 'webp', 80);
                    $path[] = $image['path'];
                    $driver = $image['driver'];
                }

                foreach ($path as $loc) {
                    $package->media()->updateOrCreate(['image' => $loc, 'driver' => $driver]);
                }
            }

            return back()->with('success', 'Package updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $package = Package::where('id', $id)->firstOr(function () {
                throw new \Exception('Package not found.');
            });

            if ($package->media) {
                foreach ($package->media as $item) {
                    $this->fileDelete($item->driver, $item->image);
                    $item->delete();
                }
            }

            $package->delete();

            return back()->with('success', 'Package deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function deleteMultiple(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select Data.');
            return response()->json(['error' => 1]);
        } else {
            Package::with(['media'])->whereIn('id', $request->strIds)->get()->map(function ($package) {
                if (!empty($package->media)){
                    foreach ($package->media as $media){
                        $media->fileDelete($media->driver, $media->image);
                        $media->delete();
                    }
                }
                $package->forceDelete();
            });
            session()->flash('success', 'Package has been deleted successfully');

            return response()->json(['success' => 1]);
        }
    }

    public function discount(Request $request, $id)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
            'discount_type' => ['required', 'in:0,1',],
        ]);
        try {
            $package = Package::where('id', $id)->firstOr(function () {
                throw new \Exception('Package not found.');
            });

            $package->discount = 1;
            $package->discount_type = $request->discount_type;
            $package->discount_amount = $request->amount;
            $package->save();

            return back()->with('success', 'Discount Added Successfully.');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function status($id)
    {
        try {
            $package = Package::select('id', 'status')
                ->where('id', $id)
                ->firstOr(function () {
                    throw new \Exception('Package not found.');
                });

            $package->status = ($package->status == 1) ? 0 : 1;
            $package->save();

            return back()->with('success', 'Package Status Changed Successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function inactiveMultiple(Request $request)
    {
        if (!$request->has('strIds') || empty($request->strIds)) {
            session()->flash('error', 'You did not select any data.');
            return response()->json(['error' => 1]);
        }

        Package::select(['id', 'status'])->whereIn('id', $request->strIds)->get()->each(function ($package) {
            $package->status = ($package->status == 0) ? 1 : 0;
            $package->save();
        });

        session()->flash('success', 'Package status changed successfully');

        return response()->json(['success' => 1]);
    }

    public function packageSEO($id)
    {
        $data['packageSEO'] = Package::findOrFail($id);
        return view("admin.package.seo", $data);
    }
    public function packageSeoUpdate(Request $request, $id)
    {
        $request->validate([
            'page_title' => 'required|string|min:3|max:100',
            'meta_title' => 'required|string|min:3|max:100',
            'meta_keywords' => 'required|array',
            'meta_keywords.*' => 'required|string|min:1|max:1000',
            'meta_description' => 'required|string|min:1|max:1000',
            'og_description' => 'required|string|min:1|max:1000',
            'meta_image' => 'sometimes|required|mimes:jpeg,png,jpeg|max:2048'
        ]);

        try {
            $pageSEO = Package::findOrFail($id);

            if ($request->hasFile('meta_image')) {

                try {
                    $image = $this->fileUpload($request->meta_image, config('filelocation.seo.path'), null, null, 'webp', 60, $pageSEO->seo_meta_image, $pageSEO->seo_meta_image_driver);
                    throw_if(empty($image['path']), 'Image path not found');
                } catch (\Exception $exp) {
                    return back()->with('error', 'Meta image could not be uploaded.');
                }
            }

            $pageSEO->update([
                'page_title' => $request->page_title,
                'meta_title' => $request->meta_title,
                'meta_keywords' => $request->meta_keywords,
                'meta_description' => $request->meta_description,
                'og_description' => $request->og_description,
                'meta_robots' => $request->meta_robots,
                'meta_image' => $image['path'] ?? $pageSEO->meta_image,
                'meta_image_driver' => $image['driver'] ?? $pageSEO->meta_image_driver,
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Seo has been updated.');

    }
}
