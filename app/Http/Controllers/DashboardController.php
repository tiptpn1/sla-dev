<?php

namespace App\Http\Controllers;

use App\Models\Eviden;
use App\Models\Proyek;
use App\Traits\RoleTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $projects = Proyek::with(['scopes', 'scopes.activities', 'scopes.activities.pics', 'scopes.activities.pics.bagian'])->where('isActive', true)->get();

        // return response()->json($projects);

        return view('dashboard.index', compact('projects'));
    }
}
