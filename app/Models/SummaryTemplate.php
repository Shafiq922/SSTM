<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SummaryTemplate extends Model
{
    protected $primaryKey = 'summaryTemplateID';

    protected $fillable = [
        'system_code',        // e.g. MDM
        'operation_type',     // e.g. Master Data Operation
        'user_type',          // e.g. External Customer
        'is_active',
    ];

    /**
     * Relationship:
     * One summary template can be used by many tickets
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'summaryTemplateID');
    }

    /**
     * Optional helper method to generate standard summary text
     * (Very nice for FYP explanation)
     */
    public function generateSummary()
    {
        return "{$this->system_code} - {$this->operation_type} - {$this->user_type} - {$this->action}";
    }
}
