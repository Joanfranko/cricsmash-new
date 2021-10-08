<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;

    protected $table = 'reference';

    protected $fillable = [
        'reference',
        'short_name',
        'isActive',
        'isDeleted',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'created_at' => 'datetime:d M Y H:i:s',
        'updated_at' => 'datetime:d M Y H:i:s',
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];
    
    public static $ReferenceValidation = [
        'reference' => 'required|string|min:3',
        'short_name' => 'required|string|min:3'
    ];
}
