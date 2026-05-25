<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadType extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'slug', 'form_schema'];

    protected $casts = [
        'form_schema' => 'array'
    ];

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}
