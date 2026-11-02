<?php

namespace Maina888\FacebookFeed;

use Botble\PluginManagement\Abstracts\PluginOperationAbstract;
use Botble\Setting\Facades\Setting;
use Illuminate\Support\Facades\Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('facebook_feed_videos');

        Setting::newQuery()
            ->where('key', 'LIKE', 'facebook_feed_%')
            ->delete();
    }
}
