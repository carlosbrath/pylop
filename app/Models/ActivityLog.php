<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'model',
        'model_id',
        'action',
        'changes',
        'actor_type',
        'user_id',
        'meta_info',
    ];

    // Relation to User (optional)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
