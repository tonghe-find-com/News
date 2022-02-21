<?php

namespace Tonghe\Modules\News\Models;

use App\HasList;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\History\Traits\Historable;
use Tonghe\Modules\News\Presenters\ModulePresenter;
use Tonghe\Modules\News\Models\News;

class Newscategory extends Base
{
    use HasTranslations;
    use Historable;
    use PresentableTrait;
    use HasList;

    protected $presenter = ModulePresenter::class;

    protected $guarded = [];

    public $translatable = [
        'title',
        'slug',
        'status',
        //meta
        'meta_title',
        'meta_keywords',
        'meta_description',
        'show_homepage'
    ];

    public function allForSelect(): array
    {
        $categories = $this->order()
            ->get()
            ->pluck('title', 'id')
            ->all();

        return ['' => ''] + $categories;
    }

    public function getThumbAttribute(): string
    {
        return $this->present()->image(null, 54);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(File::class, 'image_id');
    }

    public function url()
    {
        return route(app()->getLocale()."::news-category",$this->slug);
    }

    public function getHomeList()
    {
        return self::published()
                    ->where('show_homepage->'.app()->getLocale(), 1)
                    ->orderBy('position', 'ASC')
                    ->take(3)
                    ->get();
    }

    public function child()
    {
        return $this->hasMany(News::class,'category_id')->published()->orderBy('show_date','DESC')->take(8);
    }

}
