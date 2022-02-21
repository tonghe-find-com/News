@push('js')
    <script src="{{ asset('components/ckeditor4/ckeditor.js') }}"></script>
    <script src="{{ asset('components/ckeditor4/config-full.js') }}"></script>
@endpush

@component('core::admin._buttons-form', ['model' => $model])
@endcomponent

{!! BootForm::hidden('id') !!}
<file-manager related-table="{{ $model->getTable() }}" :related-id="{{ $model->id ?? 0 }}"></file-manager>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" href="#tab-content"  data-bs-toggle="tab">{{ __('Content') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#tab-meta"  data-bs-toggle="tab">{{ __('Meta') }}</a>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade show active" id="tab-content">
        <file-field type="image" field="image_id" :init-file="{{ $model->image ?? 'null' }}"></file-field>
        <div style="color:#f6416c;position: relative; color: rgb(246, 65, 108); top: -17px;">建議圖片尺寸: 340 x 220</div>
        @include('core::form._title-and-slug')
        <div class="form-group">
            {!! TranslatableBootForm::hidden('status')->value(0) !!}
            {!! TranslatableBootForm::checkbox(__('Published'), 'status') !!}
        </div>
        <div class="form-row">
            <div class="col-sm-6">
                {!! BootForm::date(__('Show Date'), 'show_date')->value(old('show_date') ? : $model->present()->dateOrNow('show_date'))->addClass('datepicker')->required() !!}
            </div>
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
                {!! BootForm::date(__('Start Date'), 'start_date')->value(old('start_date') ? : $model->present()->dateOrNow('start_date'))->addClass('datepicker')->required() !!}
            </div>
            <div class="col-sm-6">
                {!! BootForm::date(__('End Date'), 'end_date')->value(old('end_date') ? : $model->present()->dateOrNow('end_date'))->addClass('datepicker')->required() !!}
                {!! BootForm::hidden('no_end_date')->value(0) !!}
                {!! BootForm::checkbox(__('Date End Unlimited'), 'no_end_date') !!}
            </div>
        </div>
        {!! BootForm::select(__('Category'), 'category_id', Newscategories::allForSelect())->addClass('custom-select')->required() !!}
        {!! TranslatableBootForm::textarea(__('Summary'), 'summary')->rows(4) !!}
        {!! TranslatableBootForm::textarea(__('Body'), 'body')->addClass('ckeditor-full') !!}
    </div>
    <div class="tab-pane fade" id="tab-meta">
        {!! TranslatableBootForm::text(__('Meta title'), 'meta_title') !!}
        {!! TranslatableBootForm::text(__('Meta keywords'), 'meta_keywords') !!}
        {!! TranslatableBootForm::text(__('Meta description'), 'meta_description') !!}
    </div>
</div>
