<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRating extends Model
{
    use HasFactory;

    protected $primaryKey = 'ratingID'; // Using custom primary key to match project convention? Or stick to standard 'id'? Project uses userID, ticketID. Let's stick to 'id' unless specific reason. Actually, let's check other models.
    // TicketLog uses ticketLogID. Ticket uses ticketID. User uses userID.
    // So ServiceRating should likely use serviceRatingID.

    protected $fillable = [
        'rater_userID', // Renaming to follow UserID convention? Or keep rater_id?
        // Let's follow convention: userID. But we have two users.
        // rating_by_userID
        // rating_for_userID
        // Let's stick to standard readable names: rater_id, ratee_id but map them to userID if needed.
        // Actually, let's look at Ticket model for assignment.
        // assigneeID -> User
        // userID -> User (creator)

        // So:
        'rater_userID',
        'ratee_userID',
        'ticketID', // Optional
        'rating',
        'comment'
    ];

    public function rater()
    {
        return $this->belongsTo(User::class, 'rater_userID', 'userID');
    }

    public function ratee()
    {
        return $this->belongsTo(User::class, 'ratee_userID', 'userID');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticketID', 'ticketID');
    }
}
