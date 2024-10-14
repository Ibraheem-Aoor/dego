<?php

namespace App\Http\Controllers\Company;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseCompanyController extends Controller
{
    protected $base_route_path = 'company.';
    protected $base_view_path = 'company.';
}
