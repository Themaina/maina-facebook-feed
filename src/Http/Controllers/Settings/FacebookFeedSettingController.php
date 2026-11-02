<?php

namespace Maina888\FacebookFeed\Http\Controllers\Settings;

use Botble\Setting\Http\Controllers\SettingController;
use Maina888\FacebookFeed\Forms\Settings\FacebookFeedSettingForm;
use Maina888\FacebookFeed\Http\Requests\Settings\FacebookFeedSettingRequest;
use Maina888\FacebookFeed\Support\FacebookFeedHelper;
use Illuminate\Support\Arr;

class FacebookFeedSettingController extends SettingController
{
    public function edit()
    {
        $this->pageTitle(trans('plugins/facebook-feed::facebook-feed.settings.name'));

        return FacebookFeedSettingForm::create()->renderForm();
    }

    public function update(FacebookFeedSettingRequest $request, FacebookFeedHelper $helper)
    {
        $helper->saveSettings(Arr::only($request->validated(), $helper->settingKeys()));

        return $this
            ->httpResponse()
            ->withUpdatedSuccessMessage();
    }
}
