<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{
    use HasFactory;

    protected $fillable = ['article_id', 'total_revenue', 'creator_share', 'site_share','last_earning','date'];

    // علاقة الأرباح بالمقال
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}