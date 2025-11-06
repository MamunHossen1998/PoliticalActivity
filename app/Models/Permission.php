<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

/*
 * @author Mehedi Hasan Shamim <sh158399@gmail.com>
 */

class Permission extends SpatiePermission
{
    use HasFactory, LogsActivity;
        protected $fillable = [
        'name',
        'module_id',
        'checked',
        'guard_name',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

        public function getActivitylogOptions(): LogOptions
        {
            return LogOptions::defaults()
                ->logOnly(['module_id', 'name', 'checked', 'guard_name'])
                ->useLogName('Module')->logOnlyDirty();
        }

    }
