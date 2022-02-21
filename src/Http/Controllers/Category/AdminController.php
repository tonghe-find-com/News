<?php

namespace TypiCMS\Modules\News\Http\Controllers\Category;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\News\Exports\Export;
use TypiCMS\Modules\News\Http\Requests\CategoryFormRequest as FormRequest;
use TypiCMS\Modules\News\Models\Newscategory;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('news::admin.category.index');
    }

    public function export(Request $request)
    {
        $filename = date('Y-m-d').' '.config('app.name').' newscategories.xlsx';

        return Excel::download(new Export($request), $filename);
    }

    public function create(): View
    {
        $model = new Newscategory();

        return view('news::admin.category.create')
            ->with(compact('model'));
    }

    public function edit(newscategory $newscategory): View
    {
        return view('news::admin.category.edit')
            ->with(['model' => $newscategory]);
    }

    public function store(FormRequest $request): RedirectResponse
    {
        $newscategory = Newscategory::create($request->validated());

        return $this->redirect($request, $newscategory);
    }

    public function update(newscategory $newscategory, FormRequest $request): RedirectResponse
    {
        $newscategory->update($request->validated());

        return $this->redirect($request, $newscategory);
    }
}
