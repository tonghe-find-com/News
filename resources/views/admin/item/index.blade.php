@extends('core::admin.master')

@section('title', __('News Items'))

@section('content')
<item-list
    url-base="/api/newsitems"
    locale="{{ config('typicms.content_locale') }}"
    fields="id,status,image_id,title,show_date,updated_at,category_id"
    table="newsitems"
    title="{{__('News Items')}}"
    include="image"
    appends="thumb,parent"
    :exportable="false"
    :searchable="['title']"
    :sorting="['show_date']">

    <template slot="add-button" v-if="$can('create newsitems')">
        @include('core::admin._button-create', ['module' => 'newsitems'])
    </template>

    <template slot="columns" slot-scope="{ sortArray }">
        <item-list-column-header name="checkbox" v-if="$can('update newsitems')||$can('delete newsitems')"></item-list-column-header>
        <item-list-column-header name="edit" v-if="$can('update newsitems')"></item-list-column-header>
        <item-list-column-header name="status_translated" sortable :sort-array="sortArray" :label="$t('Status')"></item-list-column-header>
        <item-list-column-header name="show_date" sortable :sort-array="sortArray" :label="$t('顯示日期')"></item-list-column-header>
        <item-list-column-header name="title_translated" sortable :sort-array="sortArray" :label="$t('Title')"></item-list-column-header>
        <item-list-column-header name="category_id" :label="$t('分類')"></item-list-column-header>
        <item-list-column-header :label="$t('Last Update Time')"></item-list-column-header>
    </template>

    <template slot="table-row" slot-scope="{ model, checkedModels, loading }">
        <td class="checkbox" v-if="$can('update newsitems')||$can('delete newsitems')"><item-list-checkbox :model="model" :checked-models-prop="checkedModels" :loading="loading"></item-list-checkbox></td>
        <td v-if="$can('update newsitems')">@include('core::admin._button-edit', ['module' => 'newsitems'])</td>
        <td><item-list-status-button :model="model"></item-list-status-button></td>
        <td>@{{ getDate(model.show_date) }}</td>
        <td>@{{ model.title_translated }}</td>
        <td>@{{ model.parent.title.cht }}</td>
        <td>@{{ getMoment(model.updated_at ) }}</td>
    </template>

</item-list>
@endsection
