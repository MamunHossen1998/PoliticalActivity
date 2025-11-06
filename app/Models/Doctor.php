<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\OpeningHours\OpeningHours;
use Spatie\OpeningHours\Exceptions\InvalidTimeRange;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Concerns\LogsFillableActivity;

class Doctor extends Model
{
    use HasFactory, LogsActivity, LogsFillableActivity;

    protected $fillable = [
        'name',
        'doctor_no',
        'degree',
        'specialty',
        'designation',
        'gender',
        'registration_no',
        'first_visit_fee',
        'follow_up_fee',
        'follow_up_validity_days',
        'location',
        'chamber_address',
        'experience_years',
        'avg_duration',
        'avg_load',
        'reserved',
        'email',
        'phone',
        'branch_id',
        'specialization_id',
        'description',
        'opening_hours',
        'is_active',
    ];

    protected $casts = [
        'opening_hours' => 'array',
        'is_active' => 'boolean',
    ];

    //  Relationships
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    //  Convert JSON to Spatie OpeningHours instance
    public function getOpeningHoursAttribute($value)
    {
        if (!$value) {
            return null;
        }

        try {
            return OpeningHours::create(json_decode($value, true));
        } catch (InvalidTimeRange $e) {
            return null;
        }
    }

    //  Check if doctor is open now
    public function isOpenNow(): bool
    {
        $openingHours = $this->getRawOriginal('opening_hours')
            ? OpeningHours::create(json_decode($this->getRawOriginal('opening_hours'), true))
            : null;

        return $openingHours ? $openingHours->isOpen() : false;
    }

    //  Get today’s hours
    public function todayHours(): ?string
    {
        $openingHours = $this->getRawOriginal('opening_hours')
            ? OpeningHours::create(json_decode($this->getRawOriginal('opening_hours'), true))
            : null;

        if (!$openingHours) return null;

        $day = strtolower(now()->format('l'));
        return optional($openingHours->forDay($day))->toString();
    }
}
