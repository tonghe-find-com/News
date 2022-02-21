@extends('pages::public.master')

@section('title',$page->meta_title==""?$page->title:$page->meta_title)
@section('keywords',$page->meta_keywords)
@section('description',$page->meta_description)


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
                    <h1 class="heading">{{ $page->title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><i class="fas fa-home"></i> <a href="{{ TypiCMS::homeUrl() }}">{{Pages::getHomeTitle()}}</a></li>
                            @isset($model)
                            <li class="breadcrumb-item"><a href="{{ $page->url() }}">{{ $page->title }}</a></li>
                            @endisset
                            <li aria-current="page" class="breadcrumb-item active">{{$model->title ?? $page->title}}</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="block-news">

                <div class="container">
                    <div class="newsbox-group">
                        @foreach ($list as $item)
                        <a href="{{ $item->url() }}" class="newsbox wow fadeInUp" id="">
                            <div class="newsbox__pic">
                                <div class="newsbox__pic-inner" style="background-image: url('{{ $item->getImage() }}');"></div>
                                <div class="newsbox__cate">{{ $item->category->title }}</div>
                            </div>
                            <div class="newsbox__info">
                                <h2 class="newsbox__title">{{$item->title}}</h2>
                                <div class="newsbox__context">{{$item->summary}}</div>
                                <div class="newsbox__date">{{ $item->show_date->format('Y/m/d') }}</div>
                            </div>
                        </a>
                        @endforeach
                    </div>

                    {!! $list->links('template.pagination') !!}
                </div>


            </div>

        </div>

    </section>
@endsection
