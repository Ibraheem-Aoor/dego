<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use App\Models\ReviewReaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'review' => 'required',
            'rate' => 'required',
        ]);

        try {
            Booking::where('user_id', Auth::user()->id)
                ->where('package_id', $request->package_id)
                ->whereIn('status', [1,2])
                ->firstOr(function () {
                    throw new \Exception('You are not eligible to send a review.');
                });


            Review::updateOrCreate(
                [
                    'package_id' => $request->package_id,
                    'user_id' => auth()->id(),
                ],
                [
                    'rating' => $request->rate,
                    'review' => $request->review,
                ]
            );

            return back()->with('success', 'Review Sent Successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
