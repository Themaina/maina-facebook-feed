<?php

namespace MainaSuperintelligence\FacebookFeed\Http\Controllers\Settings;

use Botble\Setting\Http\Controllers\SettingController;
use MainaSuperintelligence\FacebookFeed\Forms\Settings\FacebookFeedSettingForm;
use MainaSuperintelligence\FacebookFeed\Http\Requests\Settings\FacebookFeedSettingRequest;
use MainaSuperintelligence\FacebookFeed\Support\FacebookFeedHelper;
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
