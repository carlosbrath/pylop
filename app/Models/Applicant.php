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
        'district',
        'quota',
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
