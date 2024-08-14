<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnionCouncil extends Model
{
    use HasFactory;

    public function assignedWorkers()
    {
        return $this->belongsToMany(User::class, 'assigned_workers', 'union_council_id', 'user_id');
    }

    // Define the relationship with households
    public function households()
    {
        return $this->hasMany(Household::class);
    }

}
