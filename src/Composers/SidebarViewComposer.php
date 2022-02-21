<?php

namespace Tonghe\Modules\News\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        if (!Gate::denies('read newscategories')) {
            $view->sidebar->group(__('News Group'), function (SidebarGroup $group) {
                $group->id = 'newsgroup';
                $group->weight = 30;
                $group->addItem(__('News Categories'), function (SidebarItem $item) {
                    $item->id = 'newscategories';
                    $item->icon = config('typicms.newscategories.sidebar.icon');
                    $item->weight = config('typicms.newscategories.sidebar.weight');
                    $item->route('admin::index-newscategories');
                    $item->append('admin::create-newscategory');
                });
            });
        }

        if (!Gate::denies('read news')) {
            $view->sidebar->group(__('News Group'), function (SidebarGroup $group) {
                $group->id = 'newsgroup';
                $group->weight = 30;
                $group->addItem(__('News Items'), function (SidebarItem $item) {
                    $item->id = 'newsitems';
                    $item->icon = config('typicms.newsitems.sidebar.icon');
                    $item->weight = config('typicms.newsitems.sidebar.weight');
                    $item->route('admin::index-newsitems');
                    $item->append('admin::create-newsitem');
                });
            });
        }
        return ;
    }
}
