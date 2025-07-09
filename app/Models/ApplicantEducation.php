<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantEducation extends Model
{
    protected $table = 'applicant_educations';
    use HasFactory;
    protected $fillable = [
       'applicant_id',
       'education_level',
        'degree_title',
        'institute',
        'passing_year',
        'grade_or_percentage',
    ];
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
