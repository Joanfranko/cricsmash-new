<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    protected $fillable = [
        'category_id'
        , 'reference_id'
        , 'tag'
        , 'media'
        , 'media_link'
        , 'thumbnail'
        , 'short_description'
        , 'long_description'
        , 'state'
        , 'city'
        , 'view_count'
        , 'display'
        , 'isActive'
        , 'isDeleted'
        , 'reporter_id'
        , 'news_date'
        , 'created_by'
        , 'updated_by'
    ];

    protected $casts = [
        'created_at' => 'datetime:d M Y H:i:s',
        'updated_at' => 'datetime:d M Y H:i:s',
    ];

    protected $dates = [
        'created_at', 'updated_at', 'news_date'
    ];

    public static $NewsValidation = [
        'title' => 'required|string|min:3',
        'category' => 'required',
        'tag' => 'required|min:3',
        'media_link' => 'required|in:Video/Image,Youtube Link',
        'image_video' => 'required_if:media_link,==,Video/Image',
        'youtube_link' => 'required_if:media_link,==,Youtube Link',
        'description' => 'required|min:3',
        'reference' => 'required'
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function reporter() {
        return $this->belongsTo(User::class, 'reporter_id');
    }
    public function reference() {
        return $this->belongsTo(Reference::class, 'reference_id');
    }
}
