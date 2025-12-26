<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $primaryKey = 'roleID'; // Missing
    protected $fillable = ['name'];   // Missing
    
    // Missing Inverse Relationship
    public function users() {
        return $this->hasMany(User::class, 'roleID');
    }
}