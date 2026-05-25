<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'email', 'phone', 'alternate_phone', 'address', 'city', 'state', 'pincode',
        'lead_type_id', 'source', 'referred_by',
        'status', 'assigned_to', 'created_by', 'notes', 'follow_up_date', 'converted_at',
        'custom_data'
    ];

    protected $casts = [
        'converted_at' => 'datetime',
        'follow_up_date' => 'date',
        'custom_data' => 'array',
    ];

    public function assignedTo()
    {
        return $this->belongsTo(User::class , 'assigned_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class , 'created_by');
    }

    public function callLogs()
    {
        return $this->hasMany(LeadCallLog::class);
    }

    public function leadType()
    {
        return $this->belongsTo(LeadType::class);
    }
}
