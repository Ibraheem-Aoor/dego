<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class PackageCategoryController extends Controller
{
    public function list()
    {

        $query = DB::table('package_categories')
            ->selectRaw('COUNT(*) as totalPackageCategory,
                 SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as totalActivePackageCategory,
                 SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as totalInactivePackageCategory,
                 SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) as totalCreatedToday,
                 SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) as totalCreatedThisMonth',
                [now()->startOfDay(), now()->startOfMonth()]
            )
            ->first();

        $data['totalPackageCategory'] = $query->totalPackageCategory != 0 ?: 1;
        $data['totalActivePackageCategory'] = $query->totalActivePackageCategory;
        $data['totalInactivePackageCategory'] = $query->totalInactivePackageCategory;
        $data['totalCreatedToday'] = $query->totalCreatedToday;
        $data['totalCreatedThisMonth'] = $query->totalCreatedThisMonth;
        $data['totalActivePercentageCategory'] = ($data['totalActivePackageCategory'] / $data['totalPackageCategory']) * 100;
        $data['totalInactivePercentageCategory'] = ($data['totalInactivePackageCategory'] / $data['totalPackageCategory']) * 100;
        $data['totalTotalCreatedTodayPercentageCategory'] = ($data['totalCreatedToday'] / $data['totalPackageCategory']) * 100;
        $data['totalTotalCreatedThisMonthPercentageCategory'] = ($data['totalCreatedThisMonth'] / $data['totalPackageCategory']) * 100;

        return view('admin.package.category.list', $data);
    }

    public function search(Request $request)
    {

        $search = $request->input('search.value') ?? null;
        $filterName = $request->input('filterName');
        $filterStart = $request->input('filterStartDate');
        $filterEnd = $request->input('filterEndDate');
        $filterStatus = $request->input('filterStatus');

        $packageCategory = PackageCategory::query()->orderBy('id', 'desc')
            ->withCount('packages')
            ->when(!empty($search), function ($query) use ($search) {
                return $query->where('name', 'LIKE', "%{$search}%");
            })
            ->when(isset($filterName) && !empty($filterName), function ($query) use ($filterName) {
                return $query->where('name', 'LIKE', "%{$filterName}%");
            })
            ->when(isset($filterStart) && !empty($filterStart), function ($query) use ($filterStart) {
                return $query->whereDate('created_at', '>=', $filterStart);
            })
            ->when(isset($filterEnd) && !empty($filterEnd), function ($query) use ($filterEnd) {
                return $query->whereDate('created_at', '<=', $filterEnd);
            })
            ->when(isset($filterStatus), function ($query) use ($filterStatus) {
                if ($filterStatus == "all") {
                    return $query->where('status', '!=', null);
                }
                return $query->where('status', $filterStatus);
            });

        return DataTables::of($packageCategory)
            ->addColumn('checkbox', function ($item) {
                return ' <input type="checkbox" id="chk-' . $item->id . '"
                                       class="form-check-input row-tic tic-check" name="check" value="' . $item->id . '"
                                       data-id="' . $item->id . '">';
            })
            ->addColumn('name', function ($item) {
                $shortened_title = substr($item->name, 0, 20);
                if (strlen($item->name) > 20) {
                    $shortened_title .= '...';
                }
                return $shortened_title;
            })
            ->addColumn('packages', function ($item) {
                return ' <span class="badge bg-soft-secondary text-dark">' . $item->packages_count . '</span>';
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
                $editUrl = route('admin.package.category.edit', $item->id);
                return '<div class="btn-group" role="group">
                      <a href="' . $editUrl . '" class="btn btn-white btn-sm edit_user_btn">
                        <i class="bi-pencil-fill me-1"></i> ' . trans("Edit") . '
                      </a>
                    <div class="btn-group">
                      <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="userEditDropdown" data-bs-toggle="dropdown" aria-expanded="false"></button>
                      <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="userEditDropdown">
                      <a class="dropdown-item" href="' . route("admin.all.package", ['category' => $item->id]) . '">
                                <i class="bi-boxes"></i> ' . trans("Manage Packages") . '
                            </a>
                        <a class="dropdown-item statusBtn" href="javascript:void(0)"
                           data-route="' . route("admin.packageCategory.status", $item->id) . '"
                           data-bs-toggle="modal"
                           data-bs-target="#statusModal">
                            <i class="bi bi-check-circle"></i>
                           ' . trans("Status") . '
                        </a>
                          <a class="dropdown-item deleteBtn" href="javascript:void(0)"
                           data-route="' . route("admin.package.category.delete", $item->id) . '"
                           data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="bi bi-trash"></i>
                           ' . trans("Delete") . '
                        </a>
                      </div>
                    </div>
                  </div>';
            })->rawColumns(['action', 'checkbox', 'create-at', 'status', 'packages', 'name'])
            ->make(true);
    }

    public function add()
    {
        return view('admin.package.category.add');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255|unique:package_categories,name',
        ]);

        try {
            $response = new PackageCategory();
            $response->name = $request->name;
            $response->save();

            return back()->with('success', 'Category added successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $data['category'] = PackageCategory::findOrFail($id);
        return view('admin.package.category.edit', $data);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('package_categories', 'name')->ignore($id)]
        ]);

        try {
            $response = PackageCategory::where('id', $id)->firstOr(function () {
                throw new \Exception('The package category was not found.');
            });

            $response->name = $request->name;
            $response->save();

            return back()->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $category = PackageCategory::with('packages:id')->where('id', $id)->firstOr(function () {
                throw new \Exception('The package category was not found.');
            });

            if ($category->packages->isNotEmpty()) {
                return back()->with('error', 'Package Category is not empty.');
            }

            $category->delete();

            return back()->with('success', 'Category deleted successfully.');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    public function deleteMultiple(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select Data.');
            return response()->json(['error' => 1]);
        }

        PackageCategory::with(['packages'])
            ->whereIn('id', $request->strIds)->get()->map(function ($package) {
                if ($package->packages->isEmpty()) {
                    $package->forceDelete();
                }
            });
        session()->flash('success', 'Package Category has been deleted successfully');

        return response()->json(['success' => 1]);

    }

    public function status($id)
    {
        $packageCategory = PackageCategory::select('id', 'status')
            ->findOrFail($id);

        $packageCategory->status = ($packageCategory->status == 1) ? 0 : 1;
        $packageCategory->save();

        return back()->with('success', 'Package Category Status Changed Successfully.');

    }

    public function inactiveMultiple(Request $request)
    {
        if (!$request->has('strIds') || empty($request->strIds)) {
            session()->flash('error', 'You did not select any data.');
            return response()->json(['error' => 1]);
        }

        PackageCategory::select(['id', 'status'])->whereIn('id', $request->strIds)->get()->each(function ($package) {
            $package->status = ($package->status == 0) ? 1 : 0;
            $package->save();
        });

        session()->flash('success', 'Package Categories status changed successfully');

        return response()->json(['success' => 1]);
    }
}
