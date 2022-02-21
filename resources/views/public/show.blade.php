@extends('pages::public.master')

@section('title',$model->meta_title==""?$model->title:$model->meta_title)
@section('keywords',$model->meta_keywords)
@section('description',$model->meta_description)

@push('css')
    <!-- $$$ Single CSS $$$ -->
    <link rel="stylesheet" href="/project/css/wrapper.min.css">
@endpush

@push('js')
    <!-- $$$ Single JS $$$ -->
    <script defer src=""></script>
    <script>
        $currentpage = "NEWS"
    </script>
@endpush

@push('banner')
    @include('template.banner')
@endpush

@section('content')
    <section>

        <div class="wrapper-news wrapper-A">

            <div class="container">
                <div class="flexCCC">
                    <h1 class="heading">{{ $model->title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><i class="fas fa-home"></i> <a href="{{ TypiCMS::homeUrl() }}">{{Pages::getHomeTitle()}}</a></li>
                            <li class="breadcrumb-item"><a href="{{ $page->url() }}">{{$page->title}}</a></li>
                            <li class="breadcrumb-item"><a href="{{ $model->category->url() }}">{{$model->category->title}}</a></li>
                            <li aria-current="page" class="breadcrumb-item active">{{$model->title}}</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="block-newsdetail">

                <div class="container">

                    <div class="newsbar">
                        <div class="newsbar__cate">{{$model->category->title}}</div>
                        <div class="newsbar__date">{{ $model->show_date->format('Y/m/d') }}</div>
                    </div>

                    <div class="newsdetail__context">
                        <!-- 置入編輯器 -->
                        {!! $model->body !!}
                    </div>
                    <div class="flexCC mt-md mt-0-sm-d">
                        <a href="{{ $model->category->url() }}" class="btn btn-back">
                            {{ __('BACK') }}
                        </a>
                    </div>
                    <div class="flexSB mt-xl mt-lg-sm-d mb-md mb-lg-sm-d">
                        @if($prev)
                        <a href="{{ $prev->url() }}" class="btn btn-prev">
                            {{__('Previous')}}
                        </a>
                        @endif
                        @if($next)
                        <a href="{{ $next->url() }}" class="btn btn-next">
                            {{__('Next')}}
                        </a>
                        @endif
                    </div>

                </div>

            </div>

        </div>

    </section>
@endsection
