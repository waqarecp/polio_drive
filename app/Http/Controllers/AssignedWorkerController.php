<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\UnionCouncil;
use App\Models\User;
use App\Models\AssignedWorker;
use App\Models\Household;
use Illuminate\Support\Facades\Auth;


class AssignedWorkerController extends Controller
{
    public function index()
    {
        // Fetch provinces with their related divisions, districts, tehsils, and union councils
        $provinces = Province::with(['divisions.districts.tehsils.unionCouncils'])->get();

        // Fetch polio workers
        $workers = User::polioWorkers()->pluck('name', 'id');

        // Fetch all union councils and their assigned workers
        $unionCouncils = UnionCouncil::with('assignedWorkers')->get();

        return view('admin.workers.index', compact('provinces', 'workers', 'unionCouncils'));
    }

    public function assign(Request $request)
    {
        // Validate request data
        $request->validate([
            'province_id' => 'required|exists:provinces,id',
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
            'tehsil_id' => 'required|exists:tehsils,id',
            'union_council_id' => 'required|exists:union_councils,id',
            'workers' => 'required|array',
            'workers.*' => 'exists:users,id',
        ]);

        $unionCouncil = UnionCouncil::findOrFail($request->union_council_id);

        foreach ($request->workers as $workerId) {
            // Check if the worker is already assigned to the same union council
            $existingAssignment = AssignedWorker::where('user_id', $workerId)
            ->where('union_council_id', $unionCouncil->id)
            ->first();

            if ($existingAssignment) {
                // If the worker is already assigned to the same union council, skip this iteration
                continue;
            }

            // Assign worker to the union council
            AssignedWorker::updateOrCreate(
                [
                    'user_id' => $workerId, // This should be the unique identifier for the assignment
                    'union_council_id' => $unionCouncil->id // This is the unique identifier for the assignment
                ],
                [
                    'assigned_by' => Auth::id() // Update the assigned_by field
                ]
            );
        }

        return redirect()->back()->with('success', 'Polio workers assigned successfully.');
    }

    public function pickHousehold($id)
    {
        $user = Auth::user();

        // Find the household
        $household = Household::findOrFail($id);

        // Check if the household is already picked
        if ($household->assigned_worker_id) {
            return redirect()->back()->with('error', 'Household already picked.');
        }

        // Assign the household to the current user
        $household->assigned_worker_id = $user->id;
        $household->save();

        return redirect()->back()->with('success', 'Household picked successfully.');
    }

}
