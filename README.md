# News

## step1
composer require tonghe/news

## step2
Add TypiCMS\Modules\News\Providers\ModuleServiceProvider::class, to config/app.php, before TypiCMS\Modules\Core\Providers\ModuleServiceProvider::class,

## step3
php artisan vendor:publish

## step4
php artisan migrate