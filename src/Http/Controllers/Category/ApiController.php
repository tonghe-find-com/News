<?php

namespace Tonghe\Modules\News\Http\Controllers\Category;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use Tonghe\Modules\News\Models\Newscategory;

class ApiController extends BaseApiController
{
    public function index(Request $request): LengthAwarePaginator
    {
        $data = QueryBuilder::for(Newscategory::class)
            ->selectFields($request->input('fields.newscategories'))
            ->allowedSorts(['status_translated','position', 'title_translated','show_homepage_translated'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(Newscategory $newscategory, Request $request)
    {
        foreach ($request->only('status','position') as $key => $content) {
            if ($newscategory->isTranslatableAttribute($key)) {
                foreach ($content as $lang => $value) {
                    $newscategory->setTranslation($key, $lang, $value);
                }
            } else {
                $newscategory->{$key} = $content;
            }
        }

        $newscategory->save();
    }

    public function destroy(Newscategory $newscategory)
    {
        $newscategory->delete();
    }
}
