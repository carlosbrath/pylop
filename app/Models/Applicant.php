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
        'challan_date',
        'fee_status',
        'status',
        'bank_status',
    ];
    protected $appends = [
        'challan_image_url',
        'cnic_front_url',
        'cnic_back_url',
        'applicant_choosed_branch_code',
        'challan_branch_code',
    ];
    public function getChallanImageUrlAttribute()
    {
        return $this->challan_image
            ? asset('uploads/challans/' . $this->challan_image) // if stored in public/uploads
            // ? Storage::url($this->challan_image)    // if stored in storage/app/public
            : null;
    }

    public function getCnicFrontUrlAttribute()
    {
        return $this->cnic_front
            ? asset('uploads/cnic/' . $this->cnic_front)
            : null;
    }

    public function getCnicBackUrlAttribute()
    {
        return $this->cnic_back
            ? asset('uploads/cnic/' . $this->cnic_back)
            : null;
    }
    public function getApplicantChoosedBranchCodeAttribute()
    {
        return $this->choosedBranch ? $this->choosedBranch->branch_code : null;
    }
    public function getChallanBranchCodeAttribute()
    {
        return $this->challanBranch ? $this->challanBranch->branch_code : null;
    }
    public function choosedBranch()
    {
        return $this->belongsTo(Branch::class, 'applicant_choosed_branch');
    }
    public function challanBranch()
    {
        return $this->belongsTo(Branch::class, 'challan_branch_id');
    }

    public function feeBranch()
    {
        return $this->belongsTo(Branch::class, 'challan_branch_id');
    }
    public function educations()
    {
        return $this->hasMany(ApplicantEducation::class, 'applicant_id');
    }
    function education()
    {
        return $this->hasOne(ApplicantEducation::class, 'applicant_id')->orderBy('id', 'asc');
    }
    public function district()
    {
        return $this->belongsTo(Location::class, 'district_id')
            ->where('type', 'district');
    }
    public function tehsil()
    {
        return $this->belongsTo(Location::class, 'tehsil_id')
            ->where('type', 'tehsil');
    }
    public function businessCategory()
    {
        return $this->belongsTo(BusinessCategory::class, 'business_category_id');
    }

    public function businessSubCategory()
    {
        return $this->belongsTo(BusinessCategory::class, 'business_sub_category_id');
    }
    public function statusLogs()
    {
        return $this->hasMany(ApplicantStatusLog::class, 'applicant_id');
    }
    public function latestStatusLog()
    {
        return $this->hasOne(ApplicantStatusLog::class, 'applicant_id')
            ->latestOfMany();
    }
}
