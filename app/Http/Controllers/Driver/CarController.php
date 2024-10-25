<?php

namespace App\Http\Controllers\Driver;

use App\Enum\CarTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Driver\UpdateDriverAirportPrice;
use App\Http\Requests\Driver\UpdateDriverCar;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use App\Traits\Upload;
use App\Traits\Notify;
use Exception;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\Car;
use App\Models\Company;
use App\Models\Driver;
use App\Models\DriverCar;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

class CarController extends BaseDriverController
{
    use Upload, Notify;

    public function __construct()
    {
        $this->base_route_path .= 'car.';
        $this->base_view_path .= 'car.';

    }

    public function index()
    {
        $driver = getAuthUser('driver');
        $data['basic'] = basicControl();
        $data['page_title'] = __('Edit My Car');
        $data['base_route_path'] = $this->base_route_path;
        $data['types'] = CarTypeEnum::cases();
        $data['car'] = $driver->car;
        return view($this->base_view_path . 'index', $data);

    }


    public function update(UpdateDriverCar $request)
    {
        try {
            $driver = getAuthUser('driver');
            $data = $request->validated();
            $thumb_data = $this->handleFileUpload($request->file('thumb'), 'car_thumb');
            $data['thumb'] = $thumb_data['path'];
            $data['thumb_driver'] = $thumb_data['driver'];
            DriverCar::query()->updateOrCreate([
                'driver_id' => $driver->id,
            ], $data);
            return back()->with('success', __('Car updated successfully.'));
        } catch (Throwable $e) {
            dd($e);
            Log::error($e->getMessage());
            return back()->with('error', __('Something went wrong. Please try again.'));
        }
    }


     /**
     * Handles the upload of a file and returns its path and driver information.
     *
     * @param mixed $file The file to be uploaded.
     * @param string $type The type of file, used to determine the upload path and size configuration.
     *
     * @return array<string, string> An associative array containing the 'path' and 'driver' of the uploaded file.
     */
    private function handleFileUpload($file, $type)
    {
        $photo = $this->fileUpload($file, config("filelocation.{$type}.path"), null, config("filelocation.{$type}.size"), 'webp', 80);
        return ['path' => $photo['path'], 'driver' => $photo['driver']];
    }

}
