<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'categoryID';

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'categoryID');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'categoryID');
    }
}

