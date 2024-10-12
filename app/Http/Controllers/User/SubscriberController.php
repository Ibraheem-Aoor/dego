<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function  subscribe(Request $request){

        $request->validate([
            'email' => 'required | unique:subscribers,email',
        ]);

        try {
            Subscriber::insert([
                'email' => $request->email
            ]);

            return back()->with('success', 'Subscription Completed, Welcome!!');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }


    }
}
