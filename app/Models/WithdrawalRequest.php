<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Image\Manipulations;
use Spatie\Image\Enum;
use Spatie\Image\Enums\Fit;


class WithdrawalRequest extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['user_id', 'amount', 'payment_method', 'payment_details', 'status','requested_at',
        'approved_at',
        'rejected_at','image_confirm'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('tiny')
            ->fit(Fit::Max, 120, 120)
            ->width(120)
            ->format('webp')
            ->nonQueued();

        $this
            ->addMediaConversion('thumb')
            ->fit(Fit::Max, 350, 1000)
            ->width(350)
            ->format('webp')
            ->nonQueued();

        $this
            ->addMediaConversion('original')
            ->fit(Fit::Max, 1200, 10000)
            ->width(1200)
            ->format('webp')
            ->nonQueued();

    }
    public function getImageConfirm($type="thumb"){
        if($this->image_confirm==null)
            return env('DEFAULT_IMAGE_AVATAR');
        else
            return env("STORAGE_URL").'/'.\MainHelper::get_conversion($this->image_confirm,$type);
    }
}