<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PoliticalParty extends Model
{
    use HasUuids;

    protected $primaryKey = 'uuid';
    public $incrementing = false; // important for UUIDs
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'abbreviation',
        'founded_year',
    ];
}
