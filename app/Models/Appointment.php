<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Concerns\LogsFillableActivity;

class Appointment extends Model
{
    use HasFactory, LogsActivity, LogsFillableActivity;

    protected $fillable = [
        'doctor_id',
        'name',
        'phone',
        'gender',
        'age',
        'type',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}

