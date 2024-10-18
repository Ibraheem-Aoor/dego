<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Traits\Notify;
use App\Traits\Upload;
use App\Enum\EngineTypeEnum;
use App\Enum\TransmissionTypeEnum;
use App\Http\Requests\Company\CarRequest;
use App\Traits\WithStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class CarController extends BaseCompanyController
{
    use Upload , WithStatus;

    protected $model;
    public function __construct()
    {
        $this->base_route_path .= 'car.';
        $this->base_view_path .= 'car.';
        $this->model = new Car();

    }

    public function list()
    {
        $query = Car::selectRaw('COUNT(*) as totalCars,
        SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as totalActiveCar,
        SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as totalInactiveCar,
        SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) as totalCreatedToday,
        SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) as totalCreatedThisMonth',
            [now()->startOfDay(), now()->startOfMonth()]
        )->first();

        $data['totalCars'] = $query->totalCars != 0 ?: 1;
        $data['totalActiveCar'] = $query->totalActiveCar;
        $data['totalInactiveCar'] = $query->totalInactiveCar;
        $data['totalCreatedToday'] = $query->totalCreatedToday;
        $data['totalCreatedThisMonth'] = $query->totalCreatedThisMonth;
        $data['totalActivePercentage'] = ($data['totalActiveCar'] / $data['totalCars']) * 100;
        $data['totalInactivePercentage'] = ($data['totalInactiveCar'] / $data['totalCars']) * 100;
        $data['totalTotalCreatedThisMonthPercentage'] = ($data['totalCreatedThisMonth'] / $data['totalCars']) * 100;
        $data['totalTotalCreatedTodayPercentage'] = ($data['totalCreatedToday'] / $data['totalCars']) * 100;
        $data['base_route_path'] = $this->base_route_path;
        return view($this->base_view_path . 'list', $data);
    }

    /**
     * Handles the search functionality for cars with filtering options.
     *
     * @param Request $request The HTTP request object containing search and filter parameters.
     *
     * @return \Yajra\DataTables\DataTableAbstract A DataTable object with the filtered car data.
     *
     * Filter options include:
     * - 'search': General search term for car names.
     * - 'filterName': Specific filter for car names.
     * - 'startDate': Filter by start date for creation.
     * - 'endDate': Filter by end date for creation.
     * - 'destination': Filter by rent price.
     * - 'category': Filter by package category ID.
     * - 'filterStatus': Filter by car status ('all' for all statuses).
     *
     * The resulting data includes columns such as checkbox, name, engine type, doors count,
     * passengers count, rent price, insurance price, transmission type, creation date, and action buttons.
     */
    public function search(Request $request)
    {
        $search = $request->search['value'] ?? null;
        $filterName = $request->filterName;
        $filterStart = $request->startDate;
        $filterEnd = $request->endDate;
        $destination = $request->destination;
        $category = $request->category;
        $filterStatus = $request->input('filterStatus');

        $packages = Car::query()
            ->orderBy('created_at', 'DESC')
            ->when(!empty($search), function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%");
            })
            ->when(!empty($filterName), function ($query) use ($filterName) {
                $query->where('name', 'LIKE', "%{$filterName}%");
            })
            ->when(isset($filterStart) && !empty($filterStart), function ($query) use ($filterStart) {
                return $query->whereDate('created_at', '>=', $filterStart);
            })
            ->when(isset($filterEnd) && !empty($filterEnd), function ($query) use ($filterEnd) {
                return $query->whereDate('created_at', '<=', $filterEnd);
            })
            ->when(isset($destination), function ($query) use ($destination) {
                return $query->where('rent_price', $destination);
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
            ->addColumn('name', function ($item) {
                $image = $item->thumb;
                if (!$image) {
                    $firstLetter = substr($item->name, 0, 1);
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
                                  <h5 class="text-hover-primary mb-0">' . $item->name . '</h5>
                                </div>
                              </a>';

                }
            })
            ->addColumn('engine_type', function ($item) {
                return $item->engine_type;
            })
            ->addColumn('doors_count', function ($item) {
                return $item->doors_count;
            })
            ->addColumn('passengers_count', function ($item) {
                return $item->passengers_count;
            })
            ->addColumn('rent_price', function ($item) {
                return $item->rent_price;
            })
            ->addColumn('insurance_price', function ($item) {
                return $item->insurance_price;
            })

            ->addColumn('transmission_type', function ($item) {
                return $item->transmission_type;
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
                $editUrl = route($this->base_route_path . 'edit', $item->id);
                $statusUrl = route($this->base_route_path . 'status', $item->id);
                return '<div class="btn-group" role="group">
                      <a href="' . $editUrl . '" class="btn btn-white btn-sm edit_user_btn">
                        <i class="bi-pencil-fill me-1"></i> ' . trans("Edit") . '
                      </a>
                    <div class="btn-group">
                      <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="userEditDropdown" data-bs-toggle="dropdown" aria-expanded="false"></button>
                      <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="userEditDropdown">
                        <a class="dropdown-item statusBtn" href="javascript:void(0)"
                           data-route="' . $statusUrl . '"
                           data-bs-toggle="modal"
                           data-bs-target="#statusModal">
                            <i class="bi bi-check-circle"></i>
                           ' . trans("Status") . '
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
            })->rawColumns(['checkbox', 'name', 'status', 'create-at', 'action', 'rent_price', 'insurance_price', 'engine_type', 'transmission_type', 'doors_count'])
            ->make(true);
    }

    public function add()
    {
        $data['engine_types'] = EngineTypeEnum::cases();
        $data['transmission_types'] = TransmissionTypeEnum::cases();
        $data['base_route_path'] = $this->base_route_path;
        return view($this->base_view_path . '.add', $data);
    }

    /**
     * Store a newly created car in storage.
     *
     * @param  \App\Http\Requests\Company\CarRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CarRequest $request)
    {
        try {
            $thumb_data = $this->handleFileUpload($request->file('thumb'), 'car_thumb');
            $data = $request->validated();
            $data['thumb'] = $thumb_data['path'];
            $data['thumb_driver'] = $thumb_data['driver'];
            $data['company_id'] = getAuthUser('company')->id;
            $car = $this->createCar($data);

            $this->handleImagesUpload($request->images, $car);

            return back()->with('success', 'Car added successfully.');
        } catch (\Exception $e) {
            Log::error('ERROR in CarController@store: ' . $e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }
    /**
     * Handles the upload of a file and returns its path and driver information.
     *
     * @param mixed $file The file to be uploaded.
     * @param string $type The type of file, used to determine the upload path and size configuration.
     *
     * @return array<string, string> An associative array containing the 'path' and 'driver' of the uploaded file.
     */
    private function handleFileUpload($file, $type)
    {
        $photo = $this->fileUpload($file, config("filelocation.{$type}.path"), null, config("filelocation.{$type}.size"), 'webp', 80);
        return ['path' => $photo['path'], 'driver' => $photo['driver']];
    }

    protected function createCar(array $data)
    {
        return Car::create($data);
    }

    /**
     * Handles the upload of multiple car images and associates them with the car model.
     *
     * @param array $images An array of image files to be uploaded.
     * @param \App\Models\Car $car The car model to associate the uploaded images with.
     *
     * Each image is uploaded using the fileUpload method, and the resulting image path
     * and driver are used to update or create a media record for the car.
     */
    private function handleImagesUpload($images, $car)
    {
        foreach ($images as $img) {
            $image = $this->fileUpload($img, config('filelocation.car.path'), null, config('filelocation.car.size'), 'webp', 80);
            $car->media()->updateOrCreate([
                'image' => $image['path'],
                'driver' => $image['driver'],
            ]);
        }
    }


    public function edit(Car $car)
    {
        $data['engine_types'] = EngineTypeEnum::cases();
        $data['transmission_types'] = TransmissionTypeEnum::cases();
        $data['base_route_path'] = $this->base_route_path;
        $data['car'] = $car;
        $data['images'] = $car->media->map(fn($item) => getFile($item->driver, $item->image))->toArray();
        $data['oldimg'] = $car->media->pluck('id')->toArray();
        return view($this->base_view_path . '.edit', $data);
    }


    public function update(CarRequest $car_request, Car $car)
    {
        try {
            // dd($car_request->validated());
            $data = $car_request->toArray();
            if ($car_request->hasFile('thumb')) {
                $thumb_data = $this->handleFileUpload($car_request->file('thumb'), 'car_thumb');
                $data['thumb'] = $thumb_data['path'];
                $data['thumb_driver'] = $thumb_data['driver'];
            }
            $car->update($data);

            $this->deleteOldImages($car_request->preloaded, $car);
            if ($car_request->hasFile('images')) {
                $this->handleImagesUpload($car_request->images, $car);
            }


            return back()->with('success', 'Car updated successfully.');
        } catch (Throwable $e) {
            Log::error('ERROR in CarController@store: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function deleteOldImages(array $preloaded, Car $car)
    {
        $old = $preloaded;
        $packageMedia = $car->media->whereNotIn('id', $old);

        foreach ($packageMedia as $item) {
            $this->fileDelete($item->image_driver, $item->image);
            $item->delete();
        }
    }

    public function status(Car $car)
    {
        $car->update(['status' => !$car->status]);
        return back()->with('success', 'Car Status Changed Successfully.');
    }

    public function deleteMultiple(Request $request)
    {
        if (!$request->strIds) {
            session()->flash('error', 'You did not select any data.');
            return response()->json(['error' => 1]);
        }

        $ids = is_array($request->strIds) ? $request->strIds : explode(',', $request->strIds);
        // Check CarBookings Here
        // $relatedPackages = Car::whereIn('id', $ids)->exists();

        // if ($relatedPackages) {
        //     session()->flash('error', 'One or more selected cars have related packages and cannot be deleted.');
        //     return response()->json(['error' => 1]);
        // }

        Car::whereIn('id', $ids)->each(function ($car) {
            $this->fileDelete($car->thumb_driver, $car->thumb);
            $car->forceDelete();
        });

        session()->flash('success', 'Destinations have been deleted successfully.');
        return response()->json(['success' => 1]);
    }
}
