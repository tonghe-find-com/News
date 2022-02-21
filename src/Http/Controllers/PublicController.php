<?php

namespace TypiCMS\Modules\News\Http\Controllers;

use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\News\Models\Newscategory;
use TypiCMS\Modules\News\Models\News;
use Illuminate\Http\Request;

class PublicController extends BasePublicController
{
    public static $ONE_PAGE_SHOW_ITEM_AMOUNT = 9;

    public function index(Request $request)
    {
        $model = null;
        $categories = Newscategory::published()
                                    ->orderBy('position', 'ASC')
                                    ->get();


        $list = News::published()
                            ->releaseDate()
                            ->orderBy('show_date', 'DESC')
                            ->paginate(self::$ONE_PAGE_SHOW_ITEM_AMOUNT);

        return view('newscategories::public.index')
            ->with(compact('categories', 'model', 'list'));
    }

    public function category($slug, Request $request): View
    {
        $model = Newscategory::published()
                                ->whereSlugIs($slug)
                                ->firstOrFail();
        $categories = Newscategory::published()
                                    ->orderBy('position', 'ASC')
                                    ->get();
        $list = News::published()
                                ->releaseDate()
                                ->where('category_id', $model->id)
                                ->orderBy('show_date', 'DESC')
                                ->paginate(self::$ONE_PAGE_SHOW_ITEM_AMOUNT);


        return view('newscategories::public.index')
            ->with(compact('categories', 'model', 'list' ));
    }

    public function show($categorySlug,$slug): View
    {
        $categories = Newscategory::published()
                                    ->orderBy('position', 'ASC')
                                    ->get();
        $category = Newscategory::published()
                                ->whereSlugIs($categorySlug)
                                ->firstOrFail();
        $model = News::published()
                        ->releaseDate()
                        ->whereSlugIs($slug)
                        ->firstOrFail();
        $next = News::published()
                        ->releaseDate()
                        ->where('show_date','>',$model->show_date)
                        ->orderBy('show_date','ASC')
                        ->first();
        $prev = News::published()
                        ->releaseDate()
                        ->where('show_date','<',$model->show_date)
                        ->orderBy('show_date','DESC')
                        ->first();

        return view('newscategories::public.show')
            ->with(compact('categories', 'model', 'next', 'prev'));
    }

}
