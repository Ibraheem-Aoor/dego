<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Destination;
use App\Models\GoogleMapApi;
use App\Models\Package;
use App\Models\State;
use App\Traits\Notify;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DestinationController extends Controller
{
    use Upload, Notify;

    public function list(Request $request)
    {

        $query = DB::table('destinations')
            ->selectRaw('COUNT(*) as totalDestination,
                 SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as totalActiveDestination,
                 SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as totalInactiveDestination,
                 SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) as totalCreatedToday,
                 SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) as totalCreatedThisMonth',
                [now()->startOfDay(), now()->startOfMonth()])
            ->first();

        $data['totalDestination'] = $query->totalDestination != 0  ?: 1;
        $data['totalActiveDestination'] = $query->totalActiveDestination != 0  ?: 1;
        $data['totalInactiveDestination'] = $query->totalInactiveDestination != 0  ?: 1;
        $data['totalCreatedToday'] = $query->totalCreatedToday != 0  ?: 1;
        $data['totalCreatedThisMonth'] = $query->totalCreatedThisMonth != 0  ?: 1;
        $data['totalActivePercentage'] = ($data['totalActiveDestination'] / $data['totalDestination']) * 100;
        $data['totalInactivePercentage'] = ($data['totalInactiveDestination'] / $data['totalDestination']) * 100;
        $data['totalTotalCreatedTodayPercentage'] = ($data['totalCreatedToday'] / $data['totalDestination']) * 100;
        $data['totalTotalCreatedThisMonthPercentage'] = ($data['totalCreatedThisMonth'] / $data['totalDestination']) * 100;

        return view('admin.destination.list', $data);
    }

    public function search(Request $request)
    {
        $search = $request->input('search.value') ?? null;
        $filterName = $request->filterName;
        $filterStart = $request->filterStartDate;
        $filterEnd = $request->filterEndDate;
        $category = $request->category;
        $filterStatus = $request->input('filterStatus');
        $packages = Destination::query()
            ->with(['countryTake:id,name', 'stateTake:id,name', 'cityTake:id,name'])
            ->withCount('package')
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
            ->when(isset($category), function ($query) use ($category) {
                return $query->where('destination_category_id', $category);
            })
            ->when(isset($filterEnd) && !empty($filterEnd), function ($query) use ($filterEnd) {
                return $query->whereDate('created_at', '<=', $filterEnd);
            })->when(isset($filterStatus), function ($query) use ($filterStatus) {
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
            ->addColumn('destination', function ($item) {
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
                                  <h5 class="text-hover-primary mb-0">' . $item->title . '</h5>
                                </div>
                              </a>';

                }
            })
            ->addColumn('packages', function ($item) {
                return ' <span class="badge bg-soft-secondary text-dark">' . $item->package_count . '</span>';
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
                $editUrl = route('admin.destination.edit', $item->id);
                return '<div class="btn-group" role="group">
                      <a href="' . $editUrl . '" class="btn btn-white btn-sm edit_user_btn">
                        <i class="bi-pencil-fill me-1"></i> ' . trans("Edit") . '
                      </a>
                    <div class="btn-group">
                      <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="userEditDropdown" data-bs-toggle="dropdown" aria-expanded="false"></button>
                      <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="userEditDropdown">
                      <a class="dropdown-item" href="' . route("admin.all.package", ['destination' => $item->id]) . '">
                                <i class="bi-boxes"></i> ' . trans("Manage Packages") . '
                            </a>
                        <a class="dropdown-item statusBtn" href="javascript:void(0)"
                           data-route="' . route("admin.destination.status", $item->id) . '"
                           data-bs-toggle="modal"
                           data-bs-target="#statusModal">
                            <i class="bi bi-check-circle"></i>
                           ' . trans("Status") . '
                        </a>
                          <a class="dropdown-item deleteBtn" href="javascript:void(0)"
                           data-route="' . route("admin.destination.delete", $item->id) . '"
                           data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="bi bi-trash"></i>
                           ' . trans("Delete") . '
                        </a>
                      </div>
                    </div>
                  </div>';
            })
            ->rawColumns(['action', 'checkbox', 'create-at', 'status', 'packages', 'destination'])
            ->make(true);
    }

    public function deleteMultiple(Request $request)
    {
        if (!$request->strIds) {
            session()->flash('error', 'You did not select any data.');
            return response()->json(['error' => 1]);
        }

        $ids = is_array($request->strIds) ? $request->strIds : explode(',', $request->strIds);

        $relatedPackages = Package::whereIn('destination_id', $ids)->exists();

        if ($relatedPackages) {
            session()->flash('error', 'One or more selected destinations have related packages and cannot be deleted.');
            return response()->json(['error' => 1]);
        }

        Destination::whereIn('id', $ids)->each(function ($destination) {
            $destination->fileDelete($destination->thumb_driver, $destination->thumb);
            $destination->forceDelete();
        });

        session()->flash('success', 'Destinations have been deleted successfully.');
        return response()->json(['success' => 1]);
    }

    public function add()
    {
        $data['location'] = Country::where('status', 1)->orderBy('name', 'asc')->get();

        return view('admin.destination.add', $data);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'thumb' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'slug' => 'required|string|max:255|unique:destinations,slug',
            'details' => 'required',
        ]);

        try {
            $thumb = $thumbDriver = null;

            if ($request->hasFile('thumb')) {
                $photo = $this->fileUpload($request->thumb, config('filelocation.destination.path'), null, config('filelocation.destination.size'), 'webp', 60);
                $thumb = $photo['path'];
                $thumbDriver = $photo['driver'];
            }

            $api = GoogleMapApi::where('status', 1)->firstOr(function () {
                throw new \Exception('Map not found.');
            });

            $country = Country::where('id', $request->country)->firstOr(function () {
                throw new \Exception('Country not found.');
            });
            $state = State::where('id', $request->state)->firstOr(function () {
                throw new \Exception('State not found.');
            });
            $city = City::where('id', $request->city)->firstOr(function () {
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

            $destination = new Destination();
            $destination->title = $request->name;
            $destination->slug = $request->slug;
            $destination->details = $request->details;
            $destination->city = $request->city;
            $destination->state = $request->state;
            $destination->country = $request->country;
            $destination->lat = $lat;
            $destination->long = $long;
            $destination->thumb = $thumb;
            $destination->place = $request->place ?? null;
            $destination->thumb_driver = $thumbDriver;
            $destination->map = $map;
            $destination->save();

            return back()->with('success', 'Destination added successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $data['destination'] = Destination::with('countryTake:id,name', 'stateTake:id,name', 'cityTake:id,name')->where('id', $id)->firstOr(function () {
                throw new \Exception('Destination not found.');
            });

            $data['location'] = Country::where('status', 1)->get();


            return view('admin.destination.edit', $data);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $description = $request->input('details');
        $cleanedDescription = preg_replace('/<p><br><\/p>/', '', $description);
        $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'thumb' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'slug' => 'required|string|max:255|unique:destinations,slug,' . $id,
            'details' => 'required',
        ]);

        try {
            $destination = Destination::where('id', $id)->firstOr(function () {
                throw new \Exception('Destination not found.');
            });

            if ($request->address != $destination->address || $request->city != $destination->city || $request->state != $destination->state || $request->country != $destination->country) {
                $api = GoogleMapApi::where('status', 1)->firstOr(function () {
                    throw new \Exception('Map not found.');
                });

                $country = Country::where('id', $request->country)->firstOr(function () {
                    throw new \Exception('Country not found.');
                });
                $state = State::where('id', $request->state)->firstOr(function () {
                    throw new \Exception('State not found.');
                });
                $city = City::where('id', $request->city)->firstOr(function () {
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
                $destination->lat = $lat;
                $destination->long = $long;
                $destination->map = $map;
                $destination->save();
            }

            $destination->title = $request->name;
            $destination->slug = $request->slug;
            $destination->details = $cleanedDescription;
            $destination->city = $request->city;
            $destination->state = $request->state;
            $destination->country = $request->country;
            $destination->place = $request->place;
            $destination->save();

            if ($request->hasFile('thumb')) {
                $thumb = $this->fileUpload($request->thumb, config('filelocation.destination.path'), null, config('filelocation.destination.size'), 'webp', 60);
                $destination->update(['thumb' => $thumb['path'], 'thumb_driver' => $thumb['driver']]);
            }

            return back()->with('success', 'Destination updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    public function delete($id)
    {
        $destination = Destination::findOrFail($id);
        $destination->delete();
        return back()->with('success', 'Destination deleted successfully.');
    }

    public function fetchState(Request $request)
    {
        $data['states'] = State::where('country_id', $request->country_id)->where('status', 1)
            ->get(["name", "id"]);
        return response()->json($data);
    }

    public function fetchCity(Request $request)
    {
        $data['cities'] = City::where('state_id', $request->state_id)->where('status', 1)
            ->get(["name", "id"]);
        return response()->json($data);
    }

    public function status($id)
    {

        $destination = Destination::select('id', 'status')
            ->findOrFail($id);
        $destination->status = ($destination->status == 1) ? 0 : 1;
        $destination->save();

        return back()->with('success', 'Destination Status Changed Successfully.');
    }

    public function inactiveMultiple(Request $request)
    {
        if (!$request->has('strIds') || empty($request->strIds)) {
            session()->flash('error', 'You did not select any data.');
            return response()->json(['error' => 1]);
        }

        Destination::whereIn('id', $request->strIds)->get()->each(function ($destination) {
            $destination->status = ($destination->status == 0) ? 1 : 0;
            $destination->save();
        });

        session()->flash('success', 'Destination status changed successfully');

        return response()->json(['success' => 1]);
    }
}
