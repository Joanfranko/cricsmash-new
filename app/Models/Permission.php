<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public $table = 'permissions';

    protected $fillable = [
        'name'
        , 'guard_name'
        , 'display_name'
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    public static $PermissionValidation = [
        'name' => 'required|string|min:3',
    ];
}
