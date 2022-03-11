<?php

namespace TypiCMS\Modules\News\Http\Controllers\Item;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\News\Models\News;

class ApiController extends BaseApiController
{
    public function index(Request $request): LengthAwarePaginator
    {
        $data = QueryBuilder::for(News::class)
            ->selectFields($request->input('fields.newsitems'))
            ->allowedSorts(['status_translated', 'title_translated','show_date'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->allowedIncludes(['image'])
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(News $newsitem, Request $request)
    {
        foreach ($request->only('status') as $key => $content) {
            if ($newsitem->isTranslatableAttribute($key)) {
                foreach ($content as $lang => $value) {
                    $newsitem->setTranslation($key, $lang, $value);
                }
            } else {
                $newsitem->{$key} = $content;
            }
        }

        $newsitem->save();
    }

    public function destroy(News $newsitem)
    {
        $newsitem->delete();
    }
}
