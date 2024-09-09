<?php

namespace App\Http\Controllers;

use App\Models\Eviden;
use App\Traits\RoleTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use ZipArchive;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        


        return view('pages/dashboard');

    }    
}
