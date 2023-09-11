<?php

namespace App\Http\Controllers\Backend;
use App\Domains\Auth\Models\User;
use Illuminate\Support\Facades\DB;



/**
 * Class DashboardController.
 */
class DashboardController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Get count of all users
        $userCount = User::count();

        // Get user distribution by type
        $userDistribution = DB::table('users')
            ->select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->get();

        $userRegistrations = DB::table('users')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy(DB::raw('DATE(created_at)'))
            ->get();

        return view('backend.dashboard', compact('userCount', 'userDistribution','userRegistrations'));
    }
}
