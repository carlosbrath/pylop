<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;
    protected $fillable = [
        'cnic',
        'cnic_issue_date',
        'tier',
        'name',
        'fatherName',
        'dob',
        'gender',
        'phone',
        'businessName',
        'businessType',
        'district_id',
        'tehsil_id',
        'quota',
        'business_category_id',
        'business_sub_category_id',
        'PermanentAddress',
        'CurrentAddress',
        'amount',
        'branch_name',
        'branch_code',
        'challan_image',
        'fee_status',
        'status',
    ];
}
