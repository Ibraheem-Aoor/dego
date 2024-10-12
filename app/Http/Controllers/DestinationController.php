<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Destination;
use App\Models\Package;
use App\Models\Page;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function destinationList(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        try {
            $data['pageSeo'] = Page::where('name', 'destination')
                ->select('page_title', 'name', 'breadcrumb_image', 'breadcrumb_image_driver', 'breadcrumb_status','meta_title','meta_keywords','meta_description','og_description','meta_robots','meta_image','meta_image_driver')
                ->where('template_name', basicControl()->theme ?? 'relaxation')
                ->first();

            $data['content'] = Content::with('contentDetails')->where('name', 'destination')->first();

            $data['destinations'] = Destination::with( 'reaction')
                ->orderBy('id', 'DESC')
                ->withCount('package')
                ->when(request('search'), function ($query, $search) {
                    return $query->where('title', 'like', '%' . $search . '%');
                })
                ->when(request('category'), function ($query, $category) {
                    return $query->where('destination_category_id', $category);
                })
                ->where('status', 1)
                ->paginate(12);

            if (basicControl()->theme == 'relaxation'){
                $data['packages'] = Package::with(['category:id,name','reaction:id,package_id,reaction,user_id','countryTake:id,name','stateTake:id,name','cityTake:id,name'])->where('status', 1)
                    ->latest()->take(3)->get();
            }

            return view(template() . 'destination.list', $data);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
