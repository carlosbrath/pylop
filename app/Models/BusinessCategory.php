<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessCategory extends Model
{
    use HasFactory;
    public function parent()
    {
        return $this->belongsTo(BusinessCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(BusinessCategory::class, 'parent_id');
    }
}
