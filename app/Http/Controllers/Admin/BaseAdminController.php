<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationTemplate;
use Illuminate\Support\Facades\Hash;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class BaseAdminController extends Controller
{
    protected $auth_company;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->auth_company = getAuthUser('company');
            return $next($request);
        });
    }

}
