<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseholdMember extends Model
{
    use HasFactory;

    // Define the inverse relationship with Household
    public function household()
    {
        return $this->belongsTo(Household::class);
    }
}
