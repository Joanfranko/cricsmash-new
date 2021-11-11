<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    public $table = 'notifications';

    protected $fillable = [
        'title'
        , 'message'
        , 'isActive'
        , 'created_by'
        , 'updated_by'
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    public static $NotificationValidation = [
        'title' => 'required|string|min:3',
        'message' => 'required|string|min:3'
    ];
}
