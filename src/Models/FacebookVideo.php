<?php

namespace MainaSuperintelligence\FacebookFeed\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use MainaSuperintelligence\FacebookFeed\Support\FacebookUrl;

class FacebookVideo extends BaseModel
{
    protected $table = 'facebook_feed_videos';

    protected $fillable = [
        'title',
        'video_url',
        'product_url',
        'cover_image',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'title' => SafeContent::class,
    ];

    protected static function booted(): void
    {
        static::saving(function (self $video): void {
            $video->order = (int) $video->order;
        });
    }

    public function embedUrl(): ?string
    {
        return $this->video_url ? FacebookUrl::embedUrl($this->video_url) : null;
    }
}
