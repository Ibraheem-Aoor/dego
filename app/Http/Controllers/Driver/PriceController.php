<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Http\Requests\Driver\UpdateDriverAirportPrice;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use App\Traits\Upload;
use App\Traits\Notify;
use Exception;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\Company;
use App\Models\Driver;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

class PriceController extends BaseDriverController
{
    use Upload, Notify;

    public function __construct()
    {
        $this->base_route_path .= 'price.';
        $this->base_view_path .= 'price.';

    }

    public function index()
    {
        $data['basic'] = basicControl();
        $data['user'] = getAuthUser('driver');
        $data['page_title'] = __('Edit My Prices');
        $data['base_route_path'] = $this->base_route_path;
        return view($this->base_view_path.'index', $data);

    }

    public function update(UpdateDriverAirportPrice $request)
    {
        try{
            $driver = getAuthUser('driver');
            $driver->from_airport_price = $request->validated('from_airport_price');
            $driver->to_airport_price = $request->validated('to_airport_price');
            $driver->save();
            return back()->with('success' , __('Prices updated successfully.'));
        }catch(Throwable $e)
        {
            dd($e);
            Log::error($e->getMessage());
            return back()->with('error' , __('Something went wrong. Please try again.'));
        }
    }


}
