<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Http\Requests\Driver\CreateRideDestinationRequest;
use App\Http\Requests\Driver\UpdateDriverAirportPrice;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use App\Traits\Upload;
use App\Traits\Notify;
use Exception;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\Company;
use App\Models\Driver;
use App\Models\DriverRide;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

class RideController extends BaseDriverController
{
    use Upload, Notify;
    protected $model;


    public function __construct()
    {
        $this->model = new DriverRide();
        $this->base_route_path .= 'ride.';
        $this->base_view_path .= 'ride_management.';
    }

    public function index()
    {
        $data['basic'] = basicControl();
        $data['user'] = getAuthUser('driver');
        $data['base_route_path'] = $this->base_route_path;
        $data['page_title'] = __('My Ride Destinations');
        $ride_records = \Cache::get('rides');
        if (!$ride_records) {
            $ride_records = DriverRide::query()->whereBelongsTo(getAuthUser('driver'))->selectRaw('COUNT(id) AS totalUserWithTrashed')
                ->selectRaw('COUNT(*) AS totalUser')
                ->selectRaw('(COUNT(*) / COUNT(id)) * 100 AS totalUserPercentage')
                ->selectRaw('COUNT(CASE WHEN status = 1 THEN id END) AS activeUser')
                ->selectRaw('(COUNT(CASE WHEN status = 1 THEN id END) / COUNT(id)) * 100 AS activeUserPercentage')
                ->selectRaw('COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN id END) AS todayJoin')
                ->selectRaw('(COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN id END) / COUNT(id)) * 100 AS todayJoinPercentage')
                ->selectRaw('COUNT(CASE WHEN status = 0 THEN id END) AS deactivateUser')
                ->selectRaw('(COUNT(CASE WHEN status = 0 THEN id END) / COUNT(id)) * 100 AS deactivateUserPercentage')
                ->get()
                ->toArray();
            \Cache::put('ride_records', $ride_records);
        }
        $data['ride_records'] = $ride_records;
        $data['page_title'] = __('My Ride Destinations');
        $data['base_route_path'] = $this->base_route_path;
        return view($this->base_view_path . 'list', $data);
    }
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $search = $request->search['value'];
        $filterStatus = $request->filterStatus;
        $filterName = $request->filterName;
        $users = $this->model::query()->orderBy('id', 'DESC')
            ->when(!empty($search), function ($query) use ($search) {
                return $query->where('from', 'LIKE', "%{$search}%")
                    ->orWhere('to', 'LIKE', "%{$search}%")
                    ->orWhere('price', 'LIKE', "%{$search}%");
            })
            ->when(isset($filterName) && !empty($filterName), function ($query) use ($filterName) {
                return $query->where('from', 'LIKE', "%{$filterName}%")
                    ->orWhere('to', 'LIKE', "%{$filterName}%");
            })
            ->when(isset($filterStatus), function ($query) use ($filterStatus) {
                if ($filterStatus == 'all') {
                    return $query->where('status', '!=', null);
                }
                return $query->where('status', $filterStatus);
            });

        return DataTables::of($users)
            ->addColumn('checkbox', function ($item) {
                return ' <input type="checkbox" id="chk-' . $item->id . '"
                                       class="form-check-input row-tic tic-check" name="check" value="' . $item->id . '"
                                       data-id="' . $item->id . '">';
            })
            ->addColumn('from', function ($item) {
                return '<span class="d-block h5 mb-0">' . $item->from . '</span>';

            })
            ->addColumn('to', function ($item) {
                return '<span class="d-block h5 mb-0">' . $item->to . '</span>';
            })
            ->addColumn('price', function ($item) {
                return '<span class="d-block h5 mb-0">' . currencyPosition($item->price) . '</span>';
            })
            ->addColumn('status', function ($item) {
                if ($item->status == 1) {
                    return '<span class="badge bg-soft-success text-success">
                    <span class="legend-indicator bg-success"></span>' . trans('Active') . '
                  </span>';

                } else {
                    return '<span class="badge bg-soft-danger text-danger">
                    <span class="legend-indicator bg-danger"></span>' . trans('Inactive') . '
                  </span>';
                }
            })
            ->addColumn('action', function ($item) {
                $editUrl = route($this->base_route_path . 'edit', $item->id);
                $viewProfile = route('admin.agents.view.profile', $item->id);
                return '<div class="btn-group" role="group">
                      <a href="' . $editUrl . '" class="btn btn-white btn-sm edit_user_btn">
                        <i class="bi-pencil-fill me-1"></i> ' . trans("Edit") . '
                      </a>
                    <div class="btn-group">
                      <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="userEditDropdown" data-bs-toggle="dropdown" aria-expanded="false"></button>
                      <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="userEditDropdown">
                       <a class="dropdown-item" href="' . $viewProfile . '">
                          <i class="bi-eye-fill dropdown-item-icon"></i> ' . trans("View Profile") . '
                        </a>
                      </div>
                    </div>
                  </div>';
            })->rawColumns(['action', 'checkbox', 'from', 'to', 'price', 'status'])
            ->make(true);
    }


    public function addOrEdit($id = null)
    {
        $data['base_route_path'] = $this->base_route_path;
        $data['base_view_path'] = $this->base_view_path;
        $data['title'] = trans('Add Ride Destination');
        $data['ride'] = $this->model::query()->find($id);
        $data['route'] = isset($id) ? route($this->base_route_path . 'update', $id) : route($this->base_route_path . 'store');
        return view($this->base_view_path . 'add', $data);
    }

    public function storeOrUpdate(CreateRideDestinationRequest $request , $id = null)
    {
        try {
            $driver = getAuthUser('driver');
            $this->model::query()->updateOrCreate([
                'id' => $id
            ],[
                'from' => $request->validated('from'),
                'to' => $request->validated('to'),
                'price' => $request->validated('price'),
                'driver_id' => $driver->id,
            ]);
            Cache::forget('rides');
            return back()->with('success', __('Success'));
        } catch (Throwable $e) {
            dd($e->getMessage());
            Log::error($e->getMessage());
            return back()->with('error', __('Something went wrong. Please try again.'));
        }
    }

       /**
     * Delete multiple user accounts
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMultiple(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'No Record Selected');
            return response()->json(['error' => 1]);
        } else {
            $this->model::whereIn('id', $request->strIds)->get()->map(function ($recored) {
                // UserAllRecordDeleteJob::dispatch($recored);
                $recored->forceDelete();
            });
            session()->flash('success', 'Ride Destination has been deleted successfully');
            return response()->json(['success' => 1]);
        }
    }

}
