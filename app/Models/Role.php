<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public $table = 'roles';

    protected $fillable = [
        'name'
        , 'guard_name'
        , 'display_name'
    ];

    protected $dates = [
        'created_at', 'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime:d M Y H:i:s A',
        'updated_at' => 'datetime:d M Y H:i:s A'
    ];

    public static $RoleCreateValidation = [
        'name' => 'required|string|min:3|unique:roles,display_name'
    ];

    public static $RoleUpdateValidation = [
        'name' => 'required|string|min:3|unique:roles'
    ];
}
