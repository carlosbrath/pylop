<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tour extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'organizer_name',
        'organizer_cnic',
        'destination',
        'vehicle_number',
        'vehical_type',
        'user_id',
        'city',
        'number_of_other_tourists',
        'added_by_organizer',
    ];
    public function tourists()
    {
        return $this->hasMany(Tourist::class);
    }
    public function locations()
    {
        return $this->hasMany(Location::class, 'tour_id');
    }
}
