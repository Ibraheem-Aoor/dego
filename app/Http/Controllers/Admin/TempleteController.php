<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasicControl;
use App\Models\Page;
use App\Traits\Notify;
use Illuminate\Http\Request;

class TempleteController extends Controller
{
    use Notify;
    public function index(){

        return view('admin.templete.home');
    }

    public function selectTemplete(Request $request)
    {
        $theme = $request->input('theme');
        if(!in_array($theme,array_keys(config('themes')))){
            return response()->json(['error'=>"Invalid Request"],422);
        }

        $test = collect(config('themes')[$theme]['home_version'])->keys();

        $basic = BasicControl::firstOrCreate();
        $basic->theme = $theme;
        $basic->home_style = $test->first();
        $basic->save();

        $pagesByTheme = Page::select('id', 'slug', 'home_name', 'template_name', 'status')
            ->whereIn('home_name', $test)
            ->where('template_name', $theme)
            ->get();

        foreach ($pagesByTheme as $item) {
            if ($basic->home_style == $item->home_name) {
                $item->slug = '/';
            } else {
                $item->slug = $item->home_name;
            }
            $item->save();
        }

        $message = request()->theme_name .' theme selected.';
        return response()->json(['message' => $message], 200);
    }

}
