<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseDriverController extends Controller
{
    protected $base_route_path = 'driver.';
    protected $base_view_path = 'driver.';
}
