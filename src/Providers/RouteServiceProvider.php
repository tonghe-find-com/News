<?php

namespace Tonghe\Modules\News\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use Tonghe\Modules\News\Http\Controllers\Category\AdminController as CategoryAdminController;
use Tonghe\Modules\News\Http\Controllers\Item\AdminController;
use Tonghe\Modules\News\Http\Controllers\Category\ApiController as CategoryApiController;
use Tonghe\Modules\News\Http\Controllers\Item\ApiController;
use Tonghe\Modules\News\Http\Controllers\PublicController;

class RouteServiceProvider extends ServiceProvider
{
    public function map()
    {
         /*
         * Front office routes
         */
        if ($page = TypiCMS::getPageLinkedToModule('news')) {
            $middleware = $page->private ? ['public', 'auth'] : ['public'];
            foreach (locales() as $lang) {
                if ($page->isPublished($lang) && $uri = $page->uri($lang)) {
                    Route::middleware($middleware)->prefix($uri)->name($lang.'::')->group(function (Router $router) {
                        $router->get('/', [PublicController::class, 'index'])->name('index-news');
                        $router->get('{slug}', [PublicController::class, 'category'])->name('news-category');
                        $router->get('{categorySlug}/{slug}', [PublicController::class, 'show'])->name('news-item');
                    });
                }
            }
        }

        /**
         * 最新消息分類
         */

        /*
         * Admin routes
         */
        Route::middleware('admin')->prefix('admin')->name('admin::')->group(function (Router $router) {
            $router->get('newscategories', [CategoryAdminController::class, 'index'])->name('index-newscategories')->middleware('can:read newscategories');
            $router->get('newscategories/export', [CategoryAdminController::class, 'export'])->name('admin::export-newscategories')->middleware('can:read newscategories');
            $router->get('newscategories/create', [CategoryAdminController::class, 'create'])->name('create-newscategory')->middleware('can:create newscategories');
            $router->get('newscategories/{newscategory}/edit', [CategoryAdminController::class, 'edit'])->name('edit-newscategory')->middleware('can:read newscategories');
            $router->post('newscategories', [CategoryAdminController::class, 'store'])->name('store-newscategory')->middleware('can:create newscategories');
            $router->put('newscategories/{newscategory}', [CategoryAdminController::class, 'update'])->name('update-newscategory')->middleware('can:update newscategories');
        });

        /*
         * API routes
         */
        Route::middleware(['api', 'auth:api'])->prefix('api')->group(function (Router $router) {
            $router->get('newscategories', [CategoryApiController::class, 'index'])->middleware('can:read newscategories');
            $router->patch('newscategories/{newscategory}', [CategoryApiController::class, 'updatePartial'])->middleware('can:update newscategories');
            $router->delete('newscategories/{newscategory}', [CategoryApiController::class, 'destroy'])->middleware('can:delete newscategories');
        });
        /**
         * 最新消息
         */

        /*
         * Admin routes
         */
        Route::middleware('admin')->prefix('admin')->name('admin::')->group(function (Router $router) {
            $router->get('newsitems', [AdminController::class, 'index'])->name('index-newsitems')->middleware('can:read newsitems');
            $router->get('newsitems/export', [AdminController::class, 'export'])->name('admin::export-newsitems')->middleware('can:read newsitems');
            $router->get('newsitems/create', [AdminController::class, 'create'])->name('create-newsitem')->middleware('can:create newsitems');
            $router->get('newsitems/{newsitem}/edit', [AdminController::class, 'edit'])->name('edit-newsitem')->middleware('can:read newsitems');
            $router->post('newsitems', [AdminController::class, 'store'])->name('store-newsitem')->middleware('can:create newsitems');
            $router->put('newsitems/{newsitem}', [AdminController::class, 'update'])->name('update-newsitem')->middleware('can:update newsitems');
        });

        /*
         * API routes
         */
        Route::middleware(['api', 'auth:api'])->prefix('api')->group(function (Router $router) {
            $router->get('newsitems', [ApiController::class, 'index'])->middleware('can:read newsitems');
            $router->patch('newsitems/{newsitem}', [ApiController::class, 'updatePartial'])->middleware('can:update newsitems');
            $router->delete('newsitems/{newsitem}', [ApiController::class, 'destroy'])->middleware('can:delete newsitems');
        });
    }
}
