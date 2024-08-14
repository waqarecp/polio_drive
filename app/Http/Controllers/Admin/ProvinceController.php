<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index()
    {
        $provinces = Province::latest()->paginate(15);

        return view('admin.provinces.index', compact('provinces'));
    }

    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255|unique:provinces',
        ]);

        // Create the province
        try {
            Province::create([
                'name' => $request->name,
            ]);

            return redirect()->back()->with('success', 'Province added successfully!');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['error' => 'Failed to add province.']);
        }
    }

    public function update(Request $request, Province $province)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            // Update the province
            $province->update([
                'name' => $request->name,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Province has been updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'message' => 'Failed to update this Province! Try again']);
        }
    }

    public function destroy(Province $province)
    {
        try {
            $province->delete();

            return redirect()->back()->with('success', 'Province has been deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete the Province! Try again']);
        }
    }

}
