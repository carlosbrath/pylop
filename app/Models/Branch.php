<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = [
        'bank_name',
        'branch_name',
        'branch_code',
        'address',
        'tel',
        'email',
        'fax',
    ];
}
