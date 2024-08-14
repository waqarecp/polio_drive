<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Household;

class HouseholdController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch the union councils assigned to the current user with their households
        $assignedUnionCouncils = $user->unionCouncils()->with('households')->get();

        return view('admin.assigned_union_councils.index', compact('assignedUnionCouncils'));
    }

    public function showHouseholdMembers($id)
    {
        // Fetch the household along with its members
        $household = Household::with('members')->findOrFail($id);

        return view('admin.household_members.show', compact('household'));
    }

    public function pickHousehold(Request $request, $id)
    {
        $user = Auth::user();

        // Validate and update the household assignment
        $household = Household::findOrFail($id);
        $household->assigned_worker_id = $user->id;
        $household->save();

        return redirect()->route('admin.polio_worker.assigned_union_councils')
            ->with('success', 'Household picked successfully.');
    }
}