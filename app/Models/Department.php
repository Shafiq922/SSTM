<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $primaryKey = 'departmentID'; // Missing
    protected $fillable = ['name'];         // Missing

    // Missing Inverse Relationship
    public function users() {
        return $this->hasMany(User::class, 'departmentID');
    }
}