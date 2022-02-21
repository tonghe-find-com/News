@extends('core::admin.master')

@section('title', __('New News Category'))

@section('content')

    <div class="header">
        @include('core::admin._button-back', ['module' => 'newscategories'])
        <h1 class="header-title">@lang('New News Category')</h1>
    </div>

    {!! BootForm::open()->action(route('admin::index-newscategories'))->multipart()->role('form') !!}
        @include('news::admin.category._form')
    {!! BootForm::close() !!}

@endsection
