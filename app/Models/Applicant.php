<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasStatusTracking;

class Applicant extends Model
{
    use HasFactory;
    use LogsActivity;
    use HasStatusTracking;
    protected $fillable = [
        'cnic',
        'cnic_issue_date',
        'tier',
        'name',
        'fatherName',
        'dob',
        'phone',
        'businessName',
        'businessType',
        'district_id',
        'tehsil_id',
        'quota',
        'cnic_front',
        'cnic_back',
        'business_category_id',
        'business_sub_category_id',
        'applicant_choosed_branch',
        'businessAddress',
        'permanentAddress',
        'amount',
        'challan_branch_id',
        'challan_image',
        'challan_fee',
        'fee_status',
        'status',
    ];
    public function feeBranch(){
         return $this->belongsTo(Branch::class, 'challan_branch_id');
    }
    public function educations(){
        return $this->hasMany(ApplicantEducation::class, 'applicant_id');
    }
    public function district(){
         return $this->belongsTo(Location::class, 'district_id')
                    ->where('type', 'district');
    }
    public function tehsil(){
         return $this->belongsTo(Location::class, 'tehsil_id')
                    ->where('type', 'tehsil');
    }
}
