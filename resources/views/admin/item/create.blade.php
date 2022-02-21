@extends('core::admin.master')

@section('title', __('New News Item'))

@section('content')

    <div class="header">
        @include('core::admin._button-back', ['module' => 'newsitems'])
        <h1 class="header-title">@lang('New News Item')</h1>
    </div>

    {!! BootForm::open()->action(route('admin::index-newsitems'))->multipart()->role('form') !!}
        @include('news::admin.item._form')
    {!! BootForm::close() !!}

@endsection
