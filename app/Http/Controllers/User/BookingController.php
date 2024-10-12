<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function bookingList(Request $request)
    {
        try {
            $data['bookings'] = Booking::with('package:id,thumb,thumb_driver,slug')
                ->where('user_id', Auth::user()->id)
                ->whereIn('status', [1,2,4])
                ->when(isset($request->status), function ($query) use ($request) {
                    $query->whereIn('status', $request->status == 'all' ? [1, 2,4] : [$request->status]);
                })
                ->when(isset($request->trx_id) && $request->trx_id, function ($query) use ($request) {
                    $query->where('trx_id', 'like', '%' . $request->trx_id . '%');
                })
                ->when(isset($request->title) && $request->title, function ($query) use ($request) {
                    $query->where('package_title', 'like', '%' . $request->title . '%');
                })
                ->when($request->filled('from_date'), function ($query) {
                    $query->whereDate('date', '>=', request()->from_date);
                })
                ->when($request->filled('to_date'), function ($query) {
                    $query->whereDate('date', '<=', request()->to_date);
                })
                ->latest()
                ->paginate(basicControl()->user_paginate);

            return view(template() . 'user.tourBooking.list', $data);
        }catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }

    }
}
