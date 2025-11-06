<?php

namespace App\Models\Concerns;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
trait LogsFillableActivity
{
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->getFillable())
            ->useLogName(class_basename(static::class))
            ->logOnlyDirty();
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $user = Auth::user();
        $activity->causer_id = $user?->id;
        $activity->causer_type = $user ? get_class($user) : null;

        $activity->properties = array_merge(
            $activity->properties->toArray(),
            [
                'user' => [
                    'id'       => $user?->id,
                    'name'     => $user?->name,
                    'email'    => $user?->email,
                    'role'     => $user?->getRoleNames()->first() ?? 'undefined',
                ],
                'request' => [
                    'ip'         => Request::ip(),
                    'url'        => Request::fullUrl(),
                    'method'     => Request::method(),
                    'user_agent' => Request::header('User-Agent'),
                ],
                'model' => [
                    'table' => $this->getTable(),
                    'id'    => $this->id ?? null,
                    'event' => $eventName,
                ],
                'context' => [
                    'logged_at' => now()->toDateTimeString(),
                    'timezone'  => config('app.timezone'),
                    'env'       => config('app.env'),
                ],
                'timing' => [
                    'executed_at' => now()->toDateTimeString(),
                    'executionTime' =>  microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'],
                ],
            ]
        );
    }
}
