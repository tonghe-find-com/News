<?php

namespace Tonghe\Modules\News\Facades;

use Illuminate\Support\Facades\Facade;

class Newscategories extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Newscategories';
    }
}
