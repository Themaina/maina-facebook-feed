<?php

use Botble\Base\Facades\AdminHelper;
use Maina888\FacebookFeed\Http\Controllers\Settings\FacebookFeedSettingController;
use Maina888\FacebookFeed\Http\Controllers\FacebookVideoController;
use Illuminate\Support\Facades\Route;

AdminHelper::registerRoutes(function (): void {
    Route::group(['prefix' => 'facebook-feed', 'as' => 'facebook-feed.'], function (): void {
        Route::resource('', FacebookVideoController::class)->parameters(['' => 'video']);
    });

    Route::group(['prefix' => 'settings/facebook-feed', 'as' => 'facebook-feed.settings', 'permission' => 'facebook-feed.settings'], function (): void {
        Route::get('/', [FacebookFeedSettingController::class, 'edit']);
        Route::put('/', [FacebookFeedSettingController::class, 'update'])->name('.edit');
    });
});
