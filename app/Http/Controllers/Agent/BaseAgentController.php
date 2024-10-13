<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseAgentController extends Controller
{
    protected $base_route_path = 'agent.';
    protected $base_view_path = 'agent.';
}
