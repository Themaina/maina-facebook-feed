<?php

namespace Maina888\FacebookFeed\Providers;

use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Facades\PanelSectionManager;
use Botble\Base\PanelSections\PanelSectionItem;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Setting\PanelSections\SettingOthersPanelSection;
use Illuminate\Foundation\Application;

class FacebookFeedServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/facebook-feed')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadMigrations()
            ->publishAssets()
            ->loadRoutes();

        $this->app->booted(fn (Application $app) => $app->register(HookServiceProvider::class));

        DashboardMenu::beforeRetrieving(function (): void {
            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-plugins-facebook-feed',
                    'priority' => 6,
                    'parent_id' => null,
                    'name' => 'plugins/facebook-feed::facebook-feed.name',
                    'icon' => 'ti ti-brand-facebook',
                    'url' => route('facebook-feed.index'),
                    'permissions' => ['facebook-feed.index'],
                ]);
        });

        PanelSectionManager::beforeRendering(function (): void {
            PanelSectionManager::default()
                ->registerItem(
                    SettingOthersPanelSection::class,
                    fn () => PanelSectionItem::make('facebook-feed-settings')
                        ->setTitle(trans('plugins/facebook-feed::facebook-feed.settings.name'))
                        ->withIcon('ti ti-brand-facebook')
                        ->withDescription(trans('plugins/facebook-feed::facebook-feed.settings.description'))
                        ->withPriority(200)
                        ->withRoute('facebook-feed.settings')
                );
        });
    }
}
