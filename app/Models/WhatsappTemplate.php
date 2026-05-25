<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappTemplate extends Model
{
    protected $fillable = [
        'lead_type_id',
        'name',
        'body',
        'is_active',
    ];

    public function leadType()
    {
        return $this->belongsTo(LeadType::class);
    }

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
