<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $primaryKey = 'subCategoryID';

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryID');
    }
}

