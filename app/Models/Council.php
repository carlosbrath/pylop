<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Council extends Model
{
    use HasFactory;

    protected $fillable = ['tehsil_id', 'council_name'];

    public function tehsil()
    {
        return $this->belongsTo(Tehsil::class);
    }

    public function villages()
    {
        return $this->hasMany(Village::class);
    }
}
