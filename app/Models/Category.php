<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'image_name',
        'isActive',
        'isDisplayable',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'created_at' => 'datetime:d M Y H:i:s',
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    protected $appends = ['imageUrl'];

    public static $CategoryValidation = [
        'name' => 'required|string|min:3',
    ];

    public function getImageUrlAttribute() {
        return ($this->image_name != null) ? url('uploads/categories') . '/' . $this->image_name : '';
    }
}
