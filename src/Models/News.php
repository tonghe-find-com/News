<?php

namespace Tonghe\Modules\News\Models;

use App\HasImage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Files\Traits\HasFiles;
use TypiCMS\Modules\History\Traits\Historable;
use Tonghe\Modules\News\Presenters\ModulePresenter;
use Tonghe\Modules\News\Models\Newscategory;
use Illuminate\Database\Eloquent\Builder;

class News extends Base
{
    use HasFiles;
    use HasTranslations;
    use Historable;
    use PresentableTrait;
    use HasImage;

    public $table = "newsitems";
    protected $presenter = ModulePresenter::class;

    protected $dates = ['show_date','start_date','end_date'];

    protected $guarded = [];

    public $translatable = [
        'title',
        'slug',
        'status',
        'summary',
        'body',
        'in_home',
        //meta
        'meta_title',
        'meta_keywords',
        'meta_description',
        'section1_title',
        'section1_body',
        'section2_title',
        'section2_body',
        'section3_title',
        'section3_body',
        'section4_title',
        'section4_body',
        'link'
    ];

    /**
     * 是否為發佈日期
     */
    public function scopeReleaseDate(Builder $query): Builder
    {
        return $query->where(function($q){
            $q->where(function($query){
                $query->where('start_date','<=',now())
                ->where('end_date','>=',now());
            })->orWhere(function($query){
                $query->where('start_date','<=',now())
                ->where('no_end_date',1);
            });
        });
    }

    public function getThumbAttribute(): string
    {
        return $this->present()->image(null, 54);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(File::class, 'image_id');
    }

    public function category()
    {
        return $this->belongsTo(Newscategory::class,'category_id');
    }

    public function url()
    {
        return route(app()->getLocale()."::news-item",[$this->category->slug,$this->slug]);
    }

    public static function list()
    {
        return self::published()->get();
    }

    public function last()
    {
       return self::published()->orderBy('show_date','DESC')->first();
    }

    public function getParentAttribute()
    {
        return Newscategory::where('id',$this->category_id)->first();
    }

    /**
     * 給予依照年份排序的資料
     */
    public static function getList($news_list)
    {
        $list = array();
        foreach($news_list as $news_item){
            $y = $news_item->show_date->format('Y');
            $m = $news_item->show_date->format('m');
            $m_str = $news_item->show_date->format('M');
            if(array_key_exists($y,$list)){
                $year_news_list = $list[$y];

                if(array_key_exists($m,$year_news_list)){
                    $month_news_list = $year_news_list[$m];
                    array_push($month_news_list['list'], $news_item);

                    $year_news_list[$m] = $month_news_list;


                }else{
                    $item_list = array();
                    array_push($item_list, $news_item);


                    $month_news_list = array();
                    $month_news_list['list'] = $item_list;
                    $month_news_list['year'] = $y;
                    $month_news_list['month'] = $m;
                    $month_news_list['month_string'] = $m_str;

                    $year_news_list[$m] = $month_news_list;

                }
                $list[$y] = $year_news_list;
            }else{
                $year_news_list = array();


                $item_list = array();
                array_push($item_list, $news_item);


                $month_news_list = array();
                $month_news_list['list'] = $item_list;
                $month_news_list['year'] = $y;
                $month_news_list['month'] = $m;
                $month_news_list['month_string'] = $m_str;

                $year_news_list[$m] = $month_news_list;
                $list[$y] = $year_news_list;
            }
        }
        return $list;
    }
}
