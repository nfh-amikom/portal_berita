<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsViewLog extends Model
{
    protected $table = 'news_views_log';

    protected $fillable = [
        'news_id',
        'viewed_at',
    ];

    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
