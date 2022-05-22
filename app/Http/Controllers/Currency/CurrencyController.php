<?php

namespace App\Http\Controllers\Currency;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\DataTables\CurrencyDatatable;
use App\Repositories\GeneralRepo;
use App\Models\Currency;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Flash;

class CurrencyController extends Controller
{
    public function __construct(GeneralRepo $generalRepo)
    {
        parent::__construct();
       
        $this->title = 'Category';
        view()->share('title', $this->title);

        $getstatus = $generalRepo->getstatus();
        view()->share('status', $getstatus);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(CurrencyDatatable $dataTable)
    {
        $action_nav = [
            'add_new' => ['title' => '<b><i class="icon-diff-added"></i></b> Add category', 'url' => route('currency.create'), 'attributes' => ['class' => 'btn bg-success btn-labeled heading-btn btn-add', 'title' => 'Add New']],
        ];
       
        view()->share('module_action', $action_nav);
        return $dataTable->render('Currency.currency.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        view()->share('module_action', [
            'back' => ['title' => '<b><i class="icon-arrow-left52"></i></b> Go Back', 'url' => route('currency.index'),
                'attributes' => ['class' => 'btn btn-xs bg-blue btn-labeled heading-btn btn-back', 'title' => 'Back']],
        ]);
        return view('Currency.currency.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validation['name'] = 'required|unique:currencies,name';
        $this->validate($request, $validation, [
            'name.required' => trans('module_validation.name_required'),
        ]);
        $input['created_by'] = $this->user->id;
        $model = Currency::create($input);
        session()->flash('success', 'New category Added Successfully');
        if ($request->get('save_exit')) {
            return redirect('currency');
        }
        return redirect('currency/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function show($id)
    {
        if (!$id) {
            return redirect('currency');
        }
        $currency = Currency::findOrFail($id);
        return view('Currency.currency.show', compact('currency'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function edit($id)
    {
        view()->share('module_title', 'Edit category');
        view()->share('module_action', [
            'back' => ['title' => '<b><i class="icon-arrow-left52"></i></b> Go Back', 'url' => route('currency.index'),
                'attributes' => ['class' => 'btn btn-xs bg-blue btn-labeled heading-btn btn-back', 'title' => 'Back']],
        ]);
        $currency = Currency::findOrFail($id);
        if (empty($currency)) {
            session()->flash('error', 'You do not have permission to do that.');
            return redirect()->route('currency.index');
        }
        return view('Currency.currency.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $currency = Currency::findOrFail($id);
        $validation['name'] = 'required|unique:currencies,name,'.$id;
        $this->validate($request, $validation, [
            'name.required' => trans('module_validation.name_required'),
        ]);
        $input = $request->all();
        $input['updated_by'] = $this->user->id;
        $currency->update($input);
        session()->flash('success', $this->title . ' Updated Successfully');
        if ($request->get('save_exit')) {
            return redirect('currency');
        }
        return redirect()->route('currency.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $model = Currency::find($id);
        if ($model) {
            $dependency = $model->deleteValidate($id);
            if (!$dependency) {
                $model->delete();
                session()->flash('success', $this->title . ' Deleted Successfully');
            } else {
                Flash::error('This category is used in ' . $dependency);
            }
        } else {
            Flash::error($this->title . ' Not deleted as you don\'t have permission!');
        }

        return redirect('currency');
    }
}
