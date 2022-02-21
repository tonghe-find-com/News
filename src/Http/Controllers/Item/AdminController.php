<?php

namespace Tonghe\Modules\News\Http\Controllers\Item;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use Tonghe\Modules\Newsitems\Exports\Export;
use Tonghe\Modules\News\Http\Requests\FormRequest;
use Tonghe\Modules\News\Models\Newscategory;
use Tonghe\Modules\News\Models\News;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('news::admin.item.index');
    }

    public function export(Request $request)
    {
        $filename = date('Y-m-d').' '.config('app.name').' newsitems.xlsx';

        return Excel::download(new Export($request), $filename);
    }

    public function create()
    {
        if(count(Newscategory::all())==0){
            return redirect()->back()->with('error','請先新增至少一種類別');
        }
        $model = new News();

        return view('news::admin.item.create')
            ->with(compact('model'));
    }

    public function edit(News $newsitem): View
    {
        return view('news::admin.item.edit')
            ->with(['model' => $newsitem]);
    }

    public function store(FormRequest $request): RedirectResponse
    {
        $newsitem = News::create($request->validated());

        return $this->redirect($request, $newsitem);
    }

    public function update(News $newsitem, FormRequest $request): RedirectResponse
    {
        $newsitem->update($request->validated());

        return $this->redirect($request, $newsitem);
    }
}
