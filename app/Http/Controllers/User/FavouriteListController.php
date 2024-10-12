<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FavouriteDestination;
use App\Models\FavouriteList;
use App\Traits\Notify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouriteListController extends Controller
{
    use Notify;

    public function favouriteList(Request $request){
        try {
            $data['favouriteList'] = FavouriteList::with('package:id,thumb,thumb_driver,title,slug,adult_price')
                ->whereHas('package')
                ->where('user_id', auth()->id())
                ->when($request->filled('from_date'), function ($query) {
                    $query->whereDate('created_at', '>=', request()->from_date);
                })
                ->when($request->filled('to_date'), function ($query) {
                    $query->whereDate('created_at', '<=', request()->to_date);
                })
                ->when($request->filled('title'), function ($query) {
                    $query->whereHas('package', function ($q) {
                        $q->where('title', 'like', '%' . request()->title . '%');
                    });
                })
                ->where('reaction', 1)
                ->latest()
                ->paginate(basicControl()->user_paginate);

            return view(template() . 'user.favouriteList.list', $data);
        }catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }

    }

    public function packageReaction(Request $request)
    {
        $packageId = $request->input('package_id');
        $reaction = $request->input('reaction');

        FavouriteList::updateOrCreate(
            ['package_id' => $packageId, 'user_id' => Auth::id()],
            ['reaction' => $reaction]
        );

        $message = ($reaction == 0) ? 'Removed From favourite List' : 'Added to favourite List';

        return response()->json(['message' => $message], 200);
    }
    public function destinationReaction(Request $request)
    {
        $destinationId = $request->input('destination_id');
        $reaction = $request->input('reaction');


        FavouriteDestination::updateOrCreate(
            ['destination_id' => $destinationId, 'user_id' => Auth::id()],
            ['reaction' => $reaction]
        );

        $message = ($reaction == 0) ? 'Removed From favourite List' : 'Added to favourite List';

        return response()->json(['message' => $message], 200);
    }

}
