<?php

namespace Maina888\FacebookFeed\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Maina888\FacebookFeed\Support\FacebookUrl;

class FacebookVideoRequest extends Request
{
    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:250'],
            'video_url' => [
                'required',
                'string',
                'max:400',
                'url:http,https',
            ],
            'product_url' => ['nullable', 'string', 'max:400', 'url:http,https'],
            'cover_image' => ['nullable', 'string', 'max:255'],
            'order' => ['nullable', 'integer'],
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }

    /**
     * Checks that need PHP, kept out of rules() so the admin's client-side validation does not try to run them.
     */
    public function withValidator(Validator $validator): void
    {
        // Skip the admin's per-field remote checks; these rules run on the real submit.
        if ($this->has('_js_validation')) {
            return;
        }

        $validator->after(function (Validator $validator): void {
            $url = (string) $this->input('video_url');

            if ($url !== '' && ! $validator->errors()->has('video_url') && ! FacebookUrl::isVideoUrl($url)) {
                $validator->errors()->add('video_url', trans('plugins/facebook-feed::facebook-feed.video_url_invalid'));
            }
        });
    }
}
