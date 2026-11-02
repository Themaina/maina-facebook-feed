<?php

namespace MainaSuperintelligence\FacebookFeed\Forms\Settings;

use Botble\Base\Forms\FieldOptions\CheckboxFieldOption;
use Botble\Base\Forms\FieldOptions\NumberFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\HtmlField;
use Botble\Base\Forms\Fields\MultiCheckListField;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\OnOffCheckboxField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Setting\Forms\SettingForm;
use MainaSuperintelligence\FacebookFeed\Http\Requests\Settings\FacebookFeedSettingRequest;
use MainaSuperintelligence\FacebookFeed\Support\FacebookFeedHelper;

class FacebookFeedSettingForm extends SettingForm
{
    public function setup(): void
    {
        parent::setup();

        $helper = app(FacebookFeedHelper::class);

        $this
            ->setSectionTitle(trans('plugins/facebook-feed::facebook-feed.settings.name'))
            ->setSectionDescription(trans('plugins/facebook-feed::facebook-feed.settings.description'))
            ->setValidatorClass(FacebookFeedSettingRequest::class)
            ->add(
                'enabled',
                OnOffCheckboxField::class,
                CheckboxFieldOption::make()
                    ->label(trans('plugins/facebook-feed::facebook-feed.enable'))
                    ->value($helper->getSetting('enabled', true))
                    ->helperText(trans('plugins/facebook-feed::facebook-feed.enable_helper'))
            )
            ->add(
                'facebook_page_url',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/facebook-feed::facebook-feed.facebook_page_url'))
                    ->placeholder('https://www.facebook.com/yourshop')
                    ->value($helper->getSetting('facebook_page_url'))
                    ->helperText(trans('plugins/facebook-feed::facebook-feed.facebook_page_url_helper'))
            )
            ->add(
                'position',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(trans('plugins/facebook-feed::facebook-feed.position'))
                    ->choices($helper->positions())
                    ->selected($helper->getSetting('position', 'top-left'))
                    ->helperText(trans('plugins/facebook-feed::facebook-feed.position_helper'))
            )
            ->add(
                'draggable',
                OnOffCheckboxField::class,
                CheckboxFieldOption::make()
                    ->label(trans('plugins/facebook-feed::facebook-feed.draggable'))
                    ->value($helper->getSetting('draggable', true))
                    ->helperText(trans('plugins/facebook-feed::facebook-feed.draggable_helper'))
            )
            ->add(
                'widget_size',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(trans('plugins/facebook-feed::facebook-feed.widget_size'))
                    ->choices($helper->sizes())
                    ->selected($helper->getSetting('widget_size', 'compact'))
                    ->helperText(trans('plugins/facebook-feed::facebook-feed.widget_size_helper'))
            )
            ->add(
                'follow_button_text',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/facebook-feed::facebook-feed.follow_button_text_label'))
                    ->value($helper->getSetting('follow_button_text'))
                    ->helperText(trans('plugins/facebook-feed::facebook-feed.follow_button_text_helper'))
            )
            ->add(
                'shop_button_text',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/facebook-feed::facebook-feed.shop_button_text'))
                    ->value($helper->getSetting('shop_button_text', trans('plugins/facebook-feed::facebook-feed.shop_button_text_default')))
            )
            ->add(
                'shop_button_url',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/facebook-feed::facebook-feed.shop_button_url'))
                    ->value($helper->getSetting('shop_button_url', $helper->defaultShopButtonUrl()))
                    ->helperText(trans('plugins/facebook-feed::facebook-feed.shop_button_url_helper'))
            )
            ->add(
                'display_pages[]',
                MultiCheckListField::class,
                [
                    'label' => trans('plugins/facebook-feed::facebook-feed.display_pages_label'),
                    'choices' => $helper->displayPages(),
                    'value' => old('display_pages', $helper->getDisplayPages()),
                    'inline' => true,
                    'help_block' => [
                        'text' => trans('plugins/facebook-feed::facebook-feed.display_pages_helper'),
                    ],
                ]
            )
            ->add(
                'limit_videos',
                NumberField::class,
                NumberFieldOption::make()
                    ->label(trans('plugins/facebook-feed::facebook-feed.limit_videos'))
                    ->value($helper->getSetting('limit_videos', 6))
                    ->helperText(trans('plugins/facebook-feed::facebook-feed.limit_videos_helper'))
            )
            ->add(
                'show_on_mobile',
                OnOffCheckboxField::class,
                CheckboxFieldOption::make()
                    ->label(trans('plugins/facebook-feed::facebook-feed.show_on_mobile'))
                    ->value($helper->getSetting('show_on_mobile', true))
                    ->helperText(trans('plugins/facebook-feed::facebook-feed.show_on_mobile_helper'))
            )
            ->add(
                'mobile_bottom_offset',
                NumberField::class,
                NumberFieldOption::make()
                    ->label(trans('plugins/facebook-feed::facebook-feed.mobile_bottom_offset'))
                    ->value($helper->getSetting('mobile_bottom_offset', 20))
                    ->helperText(trans('plugins/facebook-feed::facebook-feed.mobile_bottom_offset_helper'))
            )
            ->add(
                'click_to_load',
                OnOffCheckboxField::class,
                CheckboxFieldOption::make()
                    ->label(trans('plugins/facebook-feed::facebook-feed.click_to_load'))
                    ->value($helper->getSetting('click_to_load', false))
                    ->helperText(trans('plugins/facebook-feed::facebook-feed.click_to_load_helper'))
            )
            ->add(
                'auto_open',
                OnOffCheckboxField::class,
                CheckboxFieldOption::make()
                    ->label(trans('plugins/facebook-feed::facebook-feed.auto_open'))
                    ->value($helper->getSetting('auto_open', false))
                    ->helperText(trans('plugins/facebook-feed::facebook-feed.auto_open_helper'))
                    ->attributes([
                        'data-bb-toggle' => 'collapse',
                        'data-bb-target' => '#facebook-feed-auto-open-delay',
                    ])
            )
            ->add(
                'openAutoOpenWrapper',
                HtmlField::class,
                [
                    'html' => sprintf(
                        '<div id="facebook-feed-auto-open-delay" style="display: %s">',
                        $helper->getSetting('auto_open', false) ? 'block' : 'none'
                    ),
                ]
            )
            ->add(
                'auto_open_delay',
                NumberField::class,
                NumberFieldOption::make()
                    ->label(trans('plugins/facebook-feed::facebook-feed.auto_open_delay'))
                    ->value($helper->getSetting('auto_open_delay', 5))
                    ->helperText(trans('plugins/facebook-feed::facebook-feed.auto_open_delay_helper'))
            )
            ->add(
                'closeAutoOpenWrapper',
                HtmlField::class,
                [
                    'html' => '</div>',
                ]
            );
    }
}
