<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    protected $fillable = [
        'category_id',
        'tag',
        'media',
        'media_link',
        'thumbnail',
        'short_description',
        'long_description',
        'state',
        'city',
        'view_count',
        'display',
        'isActive',
        'isDeleted',
        'reporter_id',
        'news_date',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'created_at' => 'datetime:d M Y H:i:s',
        'updated_at' => 'datetime:d M Y H:i:s',
    ];

    protected $dates = [
        'created_at', 'updated_at', 'news_date'
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
