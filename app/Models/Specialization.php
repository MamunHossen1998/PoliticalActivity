<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Concerns\LogsFillableActivity;

class Specialization extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, LogsFillableActivity;

    protected $fillable = [
        'name',
        'is_active',
    ];
}

