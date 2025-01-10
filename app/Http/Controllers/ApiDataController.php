<?php

namespace App\Http\Controllers;

use App\Jobs\ApiData;
use Illuminate\Http\Request;

class ApiDataController extends Controller
{
    public function apiData()
    {
        ApiData::dispatch();
        return response()->json(['status' => 'success']);
    }
}
