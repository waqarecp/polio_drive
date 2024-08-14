<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Household extends Model
{
    use HasFactory;

    public function pickHousehold($id)
    {
        $household = Household::findOrFail($id);

        // Check if the household is already picked
        if ($household->assigned_worker_id) {
            return redirect()->back()->withErrors('This household has already been picked.');
        }

        // Assign the current user as the worker for this household
        $household->assigned_worker_id = Auth::id();
        $household->save();

        return redirect()->back()->with('success', 'Household picked successfully.');
    }

    public function unionCouncil()
    {
        return $this->belongsTo(UnionCouncil::class);
    }

    // Define the relationship with HouseholdMember
    public function members()
    {
        return $this->hasMany(HouseholdMember::class);
    }

}
