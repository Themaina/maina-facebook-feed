@php
    $position = $helper->getSetting('position', 'top-left');
    $draggable = (bool) $helper->getSetting('draggable', true);
    $showOnMobile = (bool) $helper->getSetting('show_on_mobile', true);
    $autoOpen = (bool) $helper->getSetting('auto_open', false);
    $autoOpenDelay = (int) $helper->getSetting('auto_open_delay', 5);
    $shopButtonText = $helper->getSetting('shop_button_text', trans('plugins/facebook-feed::facebook-feed.shop_button_text_default'));
    $shopButtonUrl = $helper->getSetting('shop_button_url') ?: $helper->defaultShopButtonUrl();
    $profileUrl = $helper->profileUrl();
    $followButtonText = $helper->getSetting('follow_button_text');
    $widgetSize = $helper->getSetting('widget_size', 'compact');
    $clickToLoad = (bool) $helper->getSetting('click_to_load', false);
    $mobileBottomOffset = max(0, min(300, (int) $helper->getSetting('mobile_bottom_offset', 20)));
@endphp

<div
    id="facebook-feed-widget"
    class="fb-widget fb-position-{{ $position }} fb-size-{{ $widgetSize }} @if(! $showOnMobile) fb-hide-mobile @endif"
    data-draggable="{{ $draggable ? '1' : '0' }}"
    data-auto-open="{{ $autoOpen ? '1' : '0' }}"
    data-auto-open-delay="{{ $autoOpenDelay }}"
    data-stack-position="{{ $position }}"
    style="--fb-mobile-bottom: {{ $mobileBottomOffset }}px"
>
    <button type="button" class="fb-toggle" aria-expanded="false" aria-controls="fb-panel">
        <span class="fb-toggle-icon">
            <x-core::icon name="ti ti-brand-facebook" :wrapper="false" />
        </span>
    </button>

    <div class="fb-panel" id="fb-panel">
        <button type="button" class="fb-close" aria-label="{{ trans('plugins/facebook-feed::facebook-feed.close') }}">
            <x-core::icon name="ti ti-x" :wrapper="false" />
        </button>

        <div class="fb-track" style="--fb-slides: {{ $videos->count() }}">
            @foreach ($videos as $video)
                <div class="fb-slide">
                    @if ($clickToLoad)
                        <button
                            type="button"
                            class="fb-facade"
                            @if ($video->cover_image) style="background-image: url('{{ RvMedia::getImageUrl($video->cover_image) }}')" @endif
                            aria-label="{{ trans('plugins/facebook-feed::facebook-feed.tap_to_play') }}"
                        >
                            <span class="fb-facade-play">
                                <x-core::icon name="ti ti-player-play-filled" :wrapper="false" />
                            </span>
                            <span class="fb-facade-label">{{ trans('plugins/facebook-feed::facebook-feed.tap_to_play') }}</span>
                        </button>
                    @endif
                    <iframe
                        class="fb-embed"
                        data-src="{{ $video->embedUrl() }}"
                        title="{{ $video->title ?: 'Facebook video or reel' }}"
                        allow="encrypted-media; picture-in-picture"
                        allowfullscreen
                        scrolling="no"
                    ></iframe>
                </div>
            @endforeach
        </div>

        @if ($videos->count() > 1)
            <button type="button" class="fb-nav fb-nav-prev" aria-label="Previous">
                <x-core::icon name="ti ti-chevron-left" :wrapper="false" />
            </button>
            <button type="button" class="fb-nav fb-nav-next" aria-label="Next">
                <x-core::icon name="ti ti-chevron-right" :wrapper="false" />
            </button>

            <div class="fb-dots">
                @foreach ($videos as $index => $video)
                    <button
                        type="button"
                        class="fb-dot @if ($index === 0) is-active @endif"
                        data-index="{{ $index }}"
                        data-shop-url="{{ $video->product_url ?: $shopButtonUrl }}"
                    ></button>
                @endforeach
            </div>
        @endif

        <div class="fb-overlay-bottom">
            @if ($profileUrl)
                <a
                    href="{{ $profileUrl }}"
                    target="_blank"
                    rel="noopener nofollow"
                    class="fb-follow-btn @if(! $followButtonText) fb-follow-btn-icon @endif"
                    title="{{ $followButtonText ?: trans('plugins/facebook-feed::facebook-feed.follow_button_text') }}"
                >
                    <x-core::icon name="ti ti-brand-facebook" :wrapper="false" />
                    @if ($followButtonText)
                        <span>{{ $followButtonText }}</span>
                    @endif
                </a>
            @endif
            <a
                href="{{ $videos->first()->product_url ?: $shopButtonUrl }}"
                class="fb-shop-btn"
                data-default-url="{{ $shopButtonUrl }}"
            >
                <x-core::icon name="ti ti-shopping-bag" :wrapper="false" />
                {{ $shopButtonText }}
            </a>
        </div>
    </div>
</div>
