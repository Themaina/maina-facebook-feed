<?php

namespace Maina888\FacebookFeed\Forms;

use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\NumberFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Maina888\FacebookFeed\Http\Requests\FacebookVideoRequest;
use Maina888\FacebookFeed\Models\FacebookVideo;

class FacebookVideoForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(FacebookVideo::class)
            ->setValidatorClass(FacebookVideoRequest::class)
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/facebook-feed::facebook-feed.title'))
                    ->helperText(trans('plugins/facebook-feed::facebook-feed.title_helper'))
            )
            ->add(
                'video_url',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/facebook-feed::facebook-feed.video_url'))
                    ->required()
                    ->placeholder('https://www.facebook.com/yourshop/videos/1234567890123456')
                    ->helperText(trans('plugins/facebook-feed::facebook-feed.video_url_helper'))
            )
            ->add(
                'product_url',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/facebook-feed::facebook-feed.product_url'))
                    ->helperText(trans('plugins/facebook-feed::facebook-feed.product_url_helper'))
            )
            ->add(
                'cover_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(trans('plugins/facebook-feed::facebook-feed.cover_image'))
                    ->helperText(trans('plugins/facebook-feed::facebook-feed.cover_image_helper'))
            )
            ->add(
                'order',
                NumberField::class,
                NumberFieldOption::make()
                    ->label(trans('plugins/facebook-feed::facebook-feed.order'))
                    ->defaultValue(0)
                    ->helperText(trans('plugins/facebook-feed::facebook-feed.order_helper'))
            )
            ->add('status', SelectField::class, StatusFieldOption::make())
            ->setBreakFieldPoint('status');
    }
}
