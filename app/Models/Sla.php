<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sla extends Model
{
    protected $primaryKey = 'slaID';
    // Add this inside the class
    protected $fillable = [
        'priority',
        'response_time_minutes',
        'resolution_time_minutes'
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'slaID');
    }
}
