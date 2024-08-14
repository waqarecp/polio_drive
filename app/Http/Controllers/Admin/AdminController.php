<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AssignedWorker;
use App\Models\Household;
use App\Models\HouseholdMember;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $count['users'] = User::count();
        $count['households'] = Household::where('assigned_worker_id', $user->id)->count();
        $count['members'] = HouseholdMember::count();
        $count['union_councils'] = AssignedWorker::distinct('union_council_id')->count('union_council_id');

        return view('admin.index', compact('count'));
    }
}
