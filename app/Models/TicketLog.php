<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketLog extends Model
{
    protected $primaryKey = 'ticketLogID';

    protected $fillable = [
        'ticketID',
        'userID',
        'action',
        'description',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticketID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }
}

