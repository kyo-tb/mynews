<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Process;
use Carbon\Carbon;


class ProfileController extends Controller
{
    public function index(Request $request)
    {
        // Profile Modelからデータを取得する
        $profile = Profile::latest()->first();
        if (empty($profile)) {
            abort(404);
        }
        return view('profile.index', ['profile_form' => $profile]);
    }
}
