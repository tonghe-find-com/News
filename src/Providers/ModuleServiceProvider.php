<?php

namespace TypiCMS\Modules\News\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\News\Composers\SidebarViewComposer;
/*
use TypiCMS\Modules\News\Facades\News;
use TypiCMS\Modules\News\Models\News;
*/
use TypiCMS\Modules\News\Facades\News as FacadesNews;
use TypiCMS\Modules\News\Models\News;
use TypiCMS\Modules\News\Facades\Newscategories;
use TypiCMS\Modules\News\Models\Newscategory;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /**
         * 最新消息分類
         */
        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['newscategories' => ['linkable_to_page']], $modules));

        $this->loadViewsFrom(null, 'newscategories');



        AliasLoader::getInstance()->alias('Newscategories', Newscategories::class);

        // Observers
        Newscategory::observe(new SlugObserver());

        /*
         * Add the page in the view.
         */
        $this->app->view->composer('newscategories::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('newscategories');
        });
        /**
         * 最新消息
         */
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'typicms.news');
        $this->mergeConfigFrom(__DIR__.'/../config/permissions.php', 'typicms.permissions');

        $this->app['config']->set('typicms.modules', array_merge(['news' => ['linkable_to_page']], $modules));

        $this->loadViewsFrom(null, 'news');

        $this->publishes([
            __DIR__.'/../database/migrations/create_news_table.php.stub' => getMigrationFileName('create_news_table'),
        ], 'migrations');

        AliasLoader::getInstance()->alias('News', FacadesNews::class);

        // Observers
        News::observe(new SlugObserver());

        /*
         * Sidebar view composer
         */
        $this->app->view->composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        $this->app->view->composer('news::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('news');
        });
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register(RouteServiceProvider::class);

        $app->bind('Newscategories', Newscategory::class);

        $app->bind('News', Newsitem::class);
    }
}
