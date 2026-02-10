<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $primaryKey = 'attachmentID';

    protected $fillable = [
        'file_path',
        'status',
        'ticketID',
        'ticketLogID',
        'userID'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticketID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function ticketLog()
    {
        return $this->belongsTo(TicketLog::class, 'ticketLogID');
    }
}
