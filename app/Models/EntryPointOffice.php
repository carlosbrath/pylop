<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntryPointOffice extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'district',
        'latlong',
        'descrption',
        'logo',
    ];


    public function users()
    {
        return $this->hasMany(User::class, 'epo_id');
    }
}
