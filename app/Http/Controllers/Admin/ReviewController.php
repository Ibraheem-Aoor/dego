<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReviewController extends Controller
{
    public function list()
    {
        $data['reviews'] = collect(Review::selectRaw('COUNT(id) AS totalReview')
            ->selectRaw('COUNT(CASE WHEN status = 1 THEN id END) AS activeReview')
            ->selectRaw('(COUNT(CASE WHEN status = 1 THEN id END) / COUNT(id)) * 100 AS activeReviewPercentage')
            ->selectRaw('COUNT(CASE WHEN status = 0 THEN id END) AS inActiveReview')
            ->selectRaw('(COUNT(CASE WHEN status = 0 THEN id END) / COUNT(id)) * 100 AS inActiveReviewPercentage')
            ->selectRaw('COUNT(CASE WHEN DATE(created_at) = CURRENT_DATE THEN id END) AS todayReview')
            ->selectRaw('(COUNT(CASE WHEN DATE(created_at) = CURRENT_DATE THEN id END) / COUNT(id)) * 100 AS todayReviewPercentage')
            ->selectRaw('COUNT(CASE WHEN MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) THEN id END) AS thisMonthReview')
            ->selectRaw('(COUNT(CASE WHEN MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) THEN id END) / COUNT(id)) * 100 AS thisMonthReviewPercentage')
            ->get()
            ->toArray())->collapse();

        return view('admin.review', $data);
    }

    public function search(Request $request)
    {
        $search = $request->search['value'] ?? null;
        $filterName = $request->name;
        $filterStatus = $request->filterStatus;
        $filterDate = explode('-', $request->filterDate);
        $startDate = $filterDate[0];
        $endDate = isset($filterDate[1]) ? trim($filterDate[1]) : null;

        $cards = Review::with(['user:id,firstname,lastname,username,image,image_driver', 'package'])->latest()
            ->when(isset($filterName), function ($query) use ($filterName) {
                return $query->whereHas('package', function ($reviewQuery) use ($filterName) {
                    $reviewQuery->where('title', 'LIKE', '%' . $filterName . '%');
                });
            })
            ->when(isset($filterStatus), function ($query) use ($filterStatus) {
                if ($filterStatus != "all") {
                    return $query->where('status', $filterStatus);
                }
            })
            ->when(!empty($request->filterDate) && $endDate == null, function ($query) use ($startDate) {
                $startDate = Carbon::createFromFormat('d/m/Y', trim($startDate));
                $query->whereDate('created_at', $startDate);
            })
            ->when(!empty($request->filterDate) && $endDate != null, function ($query) use ($startDate, $endDate) {
                $startDate = Carbon::createFromFormat('d/m/Y', trim($startDate));
                $endDate = Carbon::createFromFormat('d/m/Y', trim($endDate));
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->when(!empty($search), function ($query) use ($search) {
                return $query->where(function ($subquery) use ($search) {
                    $subquery->where('review', 'LIKE', "%{$search}%")
                        ->orWhereHas('package', function ($reviewQuery) use ($search) {
                            $reviewQuery->where('title', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('user', function ($reviewerQuery) use ($search) {
                            $reviewerQuery->where('firstname', 'LIKE', "%{$search}%")
                                ->orWhere('lastname', 'LIKE', "%{$search}%");
                        });
                });
            });
        return DataTables::of($cards)
            ->addColumn('checkbox', function ($item) {
                return '<input type="checkbox" id="chk-' . $item->id . '"
                                       class="form-check-input row-tic tic-check" name="check" value="' . $item->id . '"
                                       data-id="' . $item->id . '">';

            })
            ->addColumn('package', function ($item) {
                $url = route('admin.package.edit', $item->package_id);
                $img = getFile($item->package->thumb_driver ?? null, $item->package->thumb ?? null);
                return '<a class="d-flex align-items-center" href="' . $url . '">
                    <div class="avatar">
                      <img class="avatar-img" src="' . $img . '" alt="Image Description">
                    </div>
                    <div class="flex-grow-1 ms-3">
                      <span class="card-title h5 text-dark text-inherit">' . $item->package?->title . '</span>
                    </div>
                  </a>
                 ';

            })
            ->addColumn('reviewer', function ($item) {
                $url = route('admin.user.view.profile', $item->user_id);
                return '<a class="d-flex align-items-center me-2" href="' . $url . '">
                                <div class="flex-shrink-0">
                                  ' . $item->user?->profilePicture() . '
                                </div>
                                <div class="flex-grow-1 ms-3">
                                  <h5 class="text-hover-primary mb-0">' . $item->user?->firstname . ' ' . $item->user?->lastname . '</h5>
                                  <span class="fs-6 text-body">' . $item->user?->username . '</span>
                                </div>
                              </a>';

            })
            ->addColumn('review', function ($item) {
                $star = asset('assets/star.svg');
                $starRating = '';
                for ($i = 0; $i < $item->rating; $i++) {
                    $starRating .= '<img src="' . $star . '" alt="Review rating" width="14">';
                }
                return '<div class="text-wrap" style="width: 18rem;">
                          <div class="d-flex gap-1 mb-2">
                            ' . $starRating . '
                          </div>
                         <p>' . $item->review . '</p>
                        </div>';
            })
            ->addColumn('date', function ($item) {
                return dateTime($item->created_at, basicControl()->date_time_format);
            })
            ->addColumn('status', function ($item) {
                if ($item->status == 1) {
                    return '<span class="badge bg-soft-success text-success">
                    <span class="legend-indicator bg-success"></span>' . trans('Publish') . '
                  </span>';

                } else {
                    return '<span class="badge bg-soft-danger text-danger">
                    <span class="legend-indicator bg-danger"></span>' . trans('Hold') . '
                  </span>';
                }
            })
            ->rawColumns(['checkbox', 'package', 'reviewer', 'review', 'date', 'status'])
            ->make(true);
    }

    public function multipleDelete(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select row.');
            return response()->json(['error' => 1]);
        } else {
            Review::whereIn('id', $request->strIds)->get()->map(function ($query) {
                $query->delete();
                return $query;
            });
            session()->flash('success', 'Review has been deleted successfully');
            return response()->json(['success' => 1]);
        }
    }

    public function multipleStatusChange(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select row.');
            return response()->json(['error' => 1]);
        } else {
            Review::whereIn('id', $request->strIds)->get()->map(function ($query) {
                if ($query->status) {
                    $query->status = 0;
                } else {
                    $query->status = 1;
                }
                $query->save();
                return $query;
            });
            session()->flash('success', 'Review has been changed successfully');
            return response()->json(['success' => 1]);
        }
    }
}
