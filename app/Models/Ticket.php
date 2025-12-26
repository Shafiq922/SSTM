<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $primaryKey = 'ticketID';

    protected $fillable = [
        'ticket_number',
        'summary',
        'description',
        'priority',
        'status',
        'type',
        'started_at',
        'resolved_at',
        'assigneeID',
        'userID',
        'slaID',
        'categoryID',
        'subCategoryID',

        'impact_level',
        'urgency',

        'request_type',
        'erp_module',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];
    
    // Relationship 1: The Requester
    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }
  
    // Relationship 2: The Assignee
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigneeID');
    }

    public function sla()
    {
        return $this->belongsTo(Sla::class, 'slaID');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryID');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'subCategoryID');
    }

    public function logs()
    {
        return $this->hasMany(TicketLog::class, 'ticketID');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'ticketID');
    }
}

