<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tourist extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'tour_id',
        'name',
        'cnic',
        'relationship',
    ];

    /**
     * Get the tour that owns the tourist.
     */
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
