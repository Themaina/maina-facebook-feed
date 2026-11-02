<?php

namespace MainaSuperintelligence\FacebookFeed\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Ecommerce\Models\Product;
use Botble\Theme\Events\RenderingSingleEvent;
use Botble\Theme\Facades\Theme;
use MainaSuperintelligence\FacebookFeed\Support\FacebookFeedHelper;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Route;

class HookServiceProvider extends ServiceProvider
{
    protected const ASSET_VERSION = '1.1.0';

    protected bool $isProductDetailPage = false;

    public function boot(): void
    {
        $this->app['events']->listen(RenderingSingleEvent::class, function (RenderingSingleEvent $event): void {
            $this->isProductDetailPage = is_plugin_active('ecommerce')
                && $event->slug->reference_type === Product::class;
        });

        $this->app['events']->listen(RouteMatched::class, function (): void {
            if (! defined('THEME_FRONT_FOOTER')) {
                return;
            }

            /** @var FacebookFeedHelper $helper */
            $helper = app(FacebookFeedHelper::class);

            if (! $helper->getSetting('enabled', true)) {
                return;
            }

            Theme::asset()
                ->container('footer')
                ->usePath(false)
                ->add(
                    'facebook-feed-css',
                    asset('vendor/core/plugins/facebook-feed/css/facebook-feed.css'),
                    [],
                    [],
                    self::ASSET_VERSION
                );

            Theme::asset()
                ->container('footer')
                ->usePath(false)
                ->add(
                    'facebook-feed-js',
                    asset('vendor/core/plugins/facebook-feed/js/facebook-feed.js'),
                    [],
                    [],
                    self::ASSET_VERSION
                );

            add_filter(THEME_FRONT_FOOTER, function (?string $html) use ($helper) {
                if (! $helper->getSetting('enabled', true)) {
                    return $html;
                }

                if (! $this->isAllowedOnCurrentPage($helper)) {
                    return $html;
                }

                $videos = $helper->getVideos();

                if ($videos->isEmpty()) {
                    return $html;
                }

                return $html . view('plugins/facebook-feed::widget', [
                    'helper' => $helper,
                    'videos' => $videos,
                ])->render();
            }, 1458);
        });
    }

    protected function isAllowedOnCurrentPage(FacebookFeedHelper $helper): bool
    {
        $displayPages = $helper->getDisplayPages();

        if (in_array('all', $displayPages)) {
            return true;
        }

        if (in_array('product_detail', $displayPages) && $this->isProductDetailPage) {
            return true;
        }

        $routeName = Route::currentRouteName();

        foreach (['public.index', 'public.products', 'public.cart', 'public.checkout.information'] as $page) {
            if (in_array($page, $displayPages) && $routeName === $page) {
                return true;
            }
        }

        return false;
    }
}
