<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Traits\Notify;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CountryController extends Controller
{
    use Upload,Notify;

    public function list()
    {
        $allData = Country::selectRaw(
            'COUNT(*) as totalCountry,
                     SUM(status = 1) as totalActiveCountry,
                     SUM(status = 0) as totalInactiveCountry')
            ->first();

        $data['totalCountry'] = $allData->totalCountry;
        $data['totalActiveCountry'] = $allData->totalActiveCountry;
        $data['totalInactiveCountry'] = $allData->totalInactiveCountry;

        $data['activeCountryPercentage'] = ($data['totalCountry'] > 0) ? ($data['totalActiveCountry'] / $data['totalCountry']) * 100 : 0;
        $data['inactiveCountryPercentage'] = ($data['totalCountry'] > 0) ? ($data['totalInactiveCountry'] / $data['totalCountry']) * 100 : 0;

        return view('admin.countries.list' , $data);
    }


    public function countryList(Request $request)
    {
        $searchValue = trim($request->search['value']);
        $countries = Country::where(function ($query) use ($searchValue) {
            $query->where('name', 'LIKE', '%' . $searchValue . '%')
                ->orWhere('iso3', 'LIKE', '%' . $searchValue . '%');
        });

        return DataTables::of($countries)
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
            ->addColumn('image', function ($item) {

                $image = $item->image;
                if (!$image) {
                    $firstLetter = substr($item->name, 0, 1);
                    return '<div class="avatar avatar-sm avatar-soft-primary avatar-circle">
                                <span class="avatar-initials">' . $firstLetter . '</span>
                                <span class="fs-6 text-body">' . optional($item)->name . '</span>
                            </div>';

                } else {
                    $url = getFile($item->image_driver, $item->image);
                    return '<div class="avatar avatar-sm avatar-circle">
                                <img class="avatar-img" src="' . $url . '" alt="Image Description" />
                                <span class="fs-6 text-body">' . optional($item)->name . '</span>
                            </div>
                            ';

                }
            })
            ->addColumn('short_name', function ($item) {
                return '<a class="d-flex align-items-center me-2" href="#">
                            <div class="flex-grow-1 ms-3">
                              <span class="fs-6 text-body">' . optional($item)->iso3 . '</span>
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

                $editUrl = route('admin.country.edit', $item->id);
                $deleteurl = route('admin.country.delete', $item->id);
                $stateList = route('admin.country.all.state', $item->id);

                return '<div class="btn-group" role="group">
                      <a href="' . $editUrl . '" class="btn btn-white btn-sm edit_user_btn">
                        <i class="bi-pencil-fill me-1"></i> ' . trans("Edit") . '
                      </a>
                    <div class="btn-group">
                      <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="userEditDropdown" data-bs-toggle="dropdown" aria-expanded="false"></button>
                      <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="userEditDropdown">
                        <a class="dropdown-item statusBtn" href="javascript:void(0)"
                           data-route="' . route("admin.country.status", $item->id) . '"
                           data-bs-toggle="modal"
                           data-bs-target="#statusModal">
                            <i class="bi bi-check-circle pe-2"></i>
                           ' . trans("Status") . '
                        </a>
                        <a class="dropdown-item" href="' . $stateList . '">
                          <i class="fas fa-city dropdown-item-icon"></i> ' . trans("Manage State") . '
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
            ->rawColumns(['checkbox','short_name', 'status', 'action','image'])
            ->make(true);
    }

    public function countryAdd(){
        return view('admin.countries.add');
    }

    public function countryStore(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:countries',
            'status' => 'required',
            'iso2' => 'required',
            'iso3' => 'required',
            'phone_code' => 'required',
            'region' => 'required',
            'subregion' => 'required',
            'image' => 'nullable',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }else{
            try {
                if ($request->hasFile('image')) {
                    $photo = $this->fileUpload($request->image, config('filelocation.country.path'), null, null, 'webp', 60,);
                    $image = $photo['path'];
                    $image_driver = $photo['driver'];
                }
                $country = new Country();

                $country->iso2 = $request->iso2;
                $country->name = $request->name;
                $country->status = $request->status;
                $country->image = $image ?? null;
                $country->image_driver = $image_driver ?? null;
                $country->phone_code = $request->phone_code;
                $country->iso3 = $request->iso3;
                $country->region = $request->region;
                $country->subregion = $request->subregion;
                $country->save();

                return back()->with('success','Country Added Successfully.');
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }

        }

    }

    public function countryEdit($id){
        try {
            $data['country'] = Country::with('state:id,name','city:id,name')->where('id',$id)->firstOr(function () {
                throw new \Exception('Country not found.');
            });

            return view('admin.countries.edit',$data);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    public function countryUpdate (Request $request, $id){

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:countries,name,' . $id,
            'status' => 'required',
            'iso2' => 'required',
            'iso3' => 'required',
            'phone_code' => 'required',
            'region' => 'required',
            'subregion' => 'required',
            'image' => 'nullable',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }



        try {
            $country = Country::where('id',$id)->firstOr(function () {
                throw new \Exception('This Country is not available now');
            });

            if ($request->hasFile('image')) {
                $photo = $this->fileUpload($request->image, config('filelocation.country.path'), null, null, 'webp', 60,);
                $image = $photo['path'];
                $image_driver = $photo['driver'];

                $country->image =$image;
                $country->image_driver = $image_driver;
                $country->save();

            }

            $country->update([
                'name'=>$request->name,
                'iso2'=>$request->iso2,
                'iso3'=>$request->iso3,
                'status'=>$request->status,
                'phone_code'=>$request->phone_code,
                'region'=>$request->region,
                'subregion'=>$request->subregion,
            ]);

            return back()->with('success','Country Updated Successfully.');
        }catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }

    }
    public function deleteMultiple(Request $request)
    {
        if (!$request->has('strIds') || empty($request->strIds)) {
            session()->flash('error', 'You did not select any data.');
            return response()->json(['error' => 1]);
        }

        $ids = is_array($request->strIds) ? $request->strIds : explode(',', $request->strIds);

        $relatedStateExist = State::whereIn('country_id', $ids)->exists();
        $relatedCityExist = City::whereIn('country_id', $ids)->exists();

        if ($relatedStateExist || $relatedCityExist) {
            session()->flash('error', 'One or more selected countries have related states or cities and cannot be deleted.');
            return response()->json(['error' => 1]);
        }

        DB::transaction(function () use ($ids) {
            $countries = Country::whereIn('id', $ids)->get();

            foreach ($countries as $country) {
                $this->fileDelete($country->image_driver, $country->image);
                $this->fileDelete($country->thumb_driver, $country->thumb);
            }

            Country::whereIn('id', $ids)->delete();
        });

        session()->flash('success', 'Selected countries deleted successfully.');
        return response()->json(['success' => 1]);
    }
    public function countryDelete($id)
    {
        try {
            $country = Country::with(['city', 'city'])->where('id', $id)->firstOr(function () {
                throw new \Exception('This country is not available now');
            });

            if ($country->state->isNotEmpty() || $country->city->isNotEmpty()) {
                return back()->with('error', 'Selected country has related states or cities and cannot be deleted.');
            }

            $this->fileDelete($country->image_driver, $country->image);

            $country->delete();

            return back()->with('success', 'Country deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function status($id){
        try {
            $country = Country::select('id', 'status')
                ->where('id', $id)
                ->firstOr(function () {
                    throw new \Exception('Country not found.');
                });

            $country->status = $country->status == 1 ? 0 : 1;
            $country->save();

            return back()->with('success','Country Status Changed Successfully.');
        }catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }
}
