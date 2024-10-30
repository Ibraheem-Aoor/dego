<?php

namespace App\Http\Controllers;

use App\Enum\DriverDestinationEnum;
use App\Enum\EngineTypeEnum;
use App\Enum\TransmissionTypeEnum;
use App\Models\Booking;
use App\Models\Car;
use App\Models\Content;
use App\Models\Driver;
use App\Models\FavouriteList;
use App\Models\GoogleMapApi;
use App\Models\Language;
use App\Models\Package;
use App\Models\PackageCategory;
use App\Models\PackageVisitor;
use App\Models\Page;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpseclib3\File\ASN1\Maps\EncryptedData;

class DriverController extends Controller
{

    protected $base_route_path = 'driver.';
    protected $base_view_path;
    public function __construct()
    {
        $this->base_view_path = template() . 'driver.';
    }
    public function carList(Request $request)
    {
        try {


            $baseQuery = Driver::query()
                ->whereHas('car')
                ->orderBy('id', 'DESC')
                ->where('status', 1);


            list($min, $max) = array_pad(explode(';', $request->my_range, 2), 2, 0);
            // $data['max'] = $request->has('my_range') ? $max : ($baseQuery->min('rent_price') ?? 10);
            // $data['min'] = $request->has('my_range') ? $min : ($baseQuery->max('rent_price') ?? 1000);
            // $data['rangeMin'] = $baseQuery->min('rent_price') ?? 10;
            // $data['rangeMax'] = $baseQuery->max('rent_price') ?? 1000;
            $data['min'] = 200;
            $data['max'] = 4000;
            $data['rangeMin'] =      10;
            $data['rangeMax'] =      1000;

            $data['drivers'] = $baseQuery
                ->when($request->search, function ($q) use ($request) {
                    $q->where('name', 'like', "%{$request->search}%");
                })
                // ->when($request->transmission_types, function ($q) use ($request) {
                //     $q->whereIn('transmission_type', $request->transmission_types);
                // })
                // ->when($request->engine_types, function ($q) use ($request) {
                //     $q->whereIn('engine_type', $request->engine_types);
                // })
                // ->when($request->my_range, function ($q) use ($min, $max) {
                //     $q->whereBetween('adult_price', [$min, $max]);
                // })
                ->paginate(10);
            $data['base_view_path'] = $this->base_view_path;
            $data['base_route_path'] = $this->base_route_path;
            $data['transmission_types'] = TransmissionTypeEnum::cases();
            $data['engine_types'] = EngineTypeEnum::cases();
            if ($request->ajax()) {
                return response()->json([
                    'html' => view(template() . 'car.partials.list', $data)->render(),
                ]);
            }

            return view($this->base_view_path . 'list', $data);
        } catch (\Exception $e) {
            dd($e);
            return back()->with('error', 'Something went wrong, Please try again.');
        }
    }
    public function carDetails(Request $request, $id)
    {
        try {
            $data['driver'] = Driver::query()
                ->with(['car' , 'rides'])
                ->where('id', decrypt($id))
                ->firstOr(function () {
                    throw new \Exception('The Drive rwas not found.');
                });

            $data['bookingDate'] = [];

            $data['base_view_path'] = $this->base_view_path;
            $data['base_route_path'] = $this->base_route_path;
            $data['services'] = DriverDestinationEnum::cases();
            $api = GoogleMapApi::where('status', 1)->firstOr(function () {
                throw new \Exception('Map not found.');
            });
            $data['map_key'] = $api->api_key;
            $data['driver_rides']  = $data['driver']->rides->where('status' , 1);
            return view($this->base_view_path . '.details', $data, compact('data'));

        } catch (\Exception $e) {
            dd($e);
            return back()->with('error', 'Something went wrong, Please try again.');
        }
    }
}
