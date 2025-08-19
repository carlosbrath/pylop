<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantStatusLog extends Model
{
    use HasFactory;
     protected $fillable = [
        'applicant_id',
        'old_status',
        'new_status',
        'changed_by_type',
        'changed_by_id',
        'remarks',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function actor()
    {
        return $this->morphTo(null, 'changed_by_type', 'changed_by_id');
    }
}
