<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\CountryStates;
use App\Models\State;
use App\Traits\Notify;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class StateController extends Controller
{
    use Upload,Notify;
    public function statelist($id){
        $allData =State::selectRaw(
            'COUNT(*) as totalState,
                         SUM(status = 1) as totalActiveState,
                         SUM(status = 0) as totalInactiveState')
            ->where('country_id', $id)
            ->first();

        $data['totalState'] = $allData->totalState;
        $data['totalActiveState'] = $allData->totalActiveState;
        $data['totalInactiveState'] = $allData->totalInactiveState;

        $data['activeStatePercentage'] = ($data['totalState'] > 0) ? ($data['totalActiveState'] / $data['totalState']) * 100 : 0;
        $data['inactiveStatePercentage'] = ($data['totalState'] > 0) ? ($data['totalInactiveState'] / $data['totalState']) * 100 : 0;

        return view('admin.countries.statelist',$data, compact('id'));
    }

    public function countryStateList(Request $request,$country)
    {

        $states = State::query()->where('country_id',$country);
        if (!empty($request->search['value'])) {
            $states->where('name', 'LIKE', '%' . $request->search['value'] . '%');
        }

        return DataTables::of($states)
            ->addColumn('no', function () {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('checkbox', function ($item) {
                return ' <input type="checkbox" id="chk-' . $item->id . '"
                                       class="form-check-input row-tic tic-check" name="check" value="' . $item->id . '"
                                       data-id="' . $item->id . '">';
            })
            ->addColumn('name', function ($item) {
                return '<a class="d-flex align-items-center me-2" href="#">
                            <div class="flex-grow-1 ms-3">
                              <span class="fs-6 text-body">' . optional($item)->name . '</span>
                            </div>
                        </a>';
            })
            ->addColumn('code', function ($item) {
                return '<a class="d-flex align-items-center me-2" href="#">
                            <div class="flex-grow-1 ms-3">
                              <span class="fs-6 text-body">' . optional($item)->country_code . '</span>
                            </div>
                        </a>';
            })
            ->addColumn('status', function ($item) {
                if ($item->status == 0) {
                    return ' <span class="badge bg-soft-warning text-warning">
                                <span class="legend-indicator bg-warning"></span> ' . trans('InActive') . '
                             </span>';
                } else {
                    return '<span class="badge bg-soft-success text-success">
                                <span class="legend-indicator bg-success"></span> ' . trans('Active') . '
                            </span>';
                }
            })
            ->addColumn('action', function ($item) {

                $editUrl = route('admin.country.state.edit', [$item->country_id, $item->id ]);
                $deleteurl = route('admin.country.state.delete', [$item->country_id, $item->id ]);
                $cityList = route('admin.country.state.all.city', [$item->country_id, $item->id ]);
                $status = route('admin.country.state.status', $item->id);

                return '<div class="btn-group" role="group">
                      <a href="' . $editUrl . '" class="btn btn-white btn-sm edit_user_btn">
                        <i class="bi-pencil-fill me-1"></i> ' . trans("Edit") . '
                      </a>
                    <div class="btn-group">
                      <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="userEditDropdown" data-bs-toggle="dropdown" aria-expanded="false"></button>
                      <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="userEditDropdown">
                          <a class="dropdown-item statusBtn" href="javascript:void(0)"
                               data-route="' . $status . '"
                               data-bs-toggle="modal"
                               data-bs-target="#statusModal">
                                <i class="bi bi-check-circle pe-2"></i>
                               ' . trans("Status") . '
                            </a>
                           <a class="dropdown-item" href="' . $cityList . '">
                              <i class="fas fa-city dropdown-item-icon"></i> ' . trans("Manage City") . '
                           </a>
                           <a class="dropdown-item deleteBtn " href="javascript:void(0)"
                               data-route="' . $deleteurl . '"
                               data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="bi bi-trash pe-2"></i>
                               ' . trans("  Delete") . '
                            </a>
                      </div>
                    </div>
                  </div>';
            })
            ->rawColumns(['checkbox','name','code', 'status', 'action'])
            ->make(true);
    }

    public function countryAddState($id){
        try {
            $data['country'] = Country::select('id','iso2')->where('id',$id)->where('status', 1)->firstOr(function () {
                throw new \Exception('This Country is not available now');
            });

            return view('admin.countries.stateAdd',$data);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }


    }
    public function countryStateStore(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s]+$/u'],
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $state = new State();

            $state->country_id = $request->country_id;
            $state->country_code = $request->country_code;
            $state->name = $request->name;
            $state->status = $request->status;

            $state->save();

            return back()->with('success','State Added Successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }


    }
    public function countryStateEdit($country,$state)
    {
        try {
            $data['state'] = State::with('country','cities')->where('id',$state)->where('country_id', $country)->firstOr(function () {
                throw new \Exception('This State is not available now');
            });

            return view('admin.countries.stateedit',$data);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    public function countryStateUpdate(Request $request,$country,$state){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s]+$/u'],
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $state = State::with('country','cities')->where('country_id',$country)->where('id',$state)->firstOr(function () {
                throw new \Exception('This State is not available now');
            });

            $state->update([
                'name'=>$request->name,
                'status'=>$request->status,
            ]);

            return back()->with('success','State Updated.');

        }catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function deleteMultipleState(Request $request)
    {
        if (empty($request->strIds)) {
            session()->flash('error', 'You did not select any country.');
            return response()->json(['error' => 1]);
        }

        $states = State::with('cities')->whereIn('id', $request->strIds)->get();

        foreach ($states as $state) {
            if ($state->cities->isNotEmpty()) {
                session()->flash('error', 'One or more states have associated cities and cannot be deleted.');
                return response()->json(['error' => 1]);
            }
        }

        State::whereIn('id', $request->strIds)->delete();

        session()->flash('success', 'Selected data deleted successfully.');
        return response()->json(['success' => 1]);
    }
    public function countryStateDelete($country, $state)
    {
        try {
            $State = State::with('cities')->where('country_id', $country)->where('id', $state)->firstOr(function () {
                throw new \Exception('This State is not available now');
            });

            if ($State->cities->isNotEmpty()) {
                return back()->with('error', 'Selected state has related cities and cannot be deleted.');
            }

            $State->delete();

            return back()->with('success', 'State deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function status($id){
        try {
            $state = State::select('id', 'status')
                ->where('id', $id)
                ->firstOr(function () {
                    throw new \Exception('State not found.');
                });

            $state->status = $state->status == 1 ? 0 : 1;
            $state->save();

            return back()->with('success','State Status Changed Successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }
}
