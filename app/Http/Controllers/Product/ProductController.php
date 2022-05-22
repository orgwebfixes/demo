<?php

namespace App\Http\Controllers\Product;

use App\Http\Requests;
use AppHelper;
use App\Http\Controllers\Controller;
use App\DataTables\ProductDatatable;
use App\Repositories\GeneralRepo;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Flash;

class ProductController extends Controller
{
    public function __construct(GeneralRepo $generalRepo)
    {
        parent::__construct();
       
        $this->title = 'Product';
        view()->share('title', $this->title);

        $getstatus = $generalRepo->getstatus();
        view()->share('status', $getstatus);

        $category = $generalRepo->getAllCurrency();
        view()->share('category', $category);

        AppHelper::path('uploads/user/');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(ProductDatatable $dataTable)
    {
        $action_nav = [
            'add_new' => ['title' => '<b><i class="icon-diff-added"></i></b> Add product', 'url' => route('product.create'), 'attributes' => ['class' => 'btn bg-success btn-labeled heading-btn btn-add', 'title' => 'Add New']],
        ];
       
        view()->share('module_action', $action_nav);
        return $dataTable->render('Product.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        view()->share('module_action', [
            'back' => ['title' => '<b><i class="icon-arrow-left52"></i></b> Go Back', 'url' => route('product.index'),
                'attributes' => ['class' => 'btn btn-xs bg-blue btn-labeled heading-btn btn-back', 'title' => 'Back']],
        ]);
        return view('Product.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validation['name'] = 'required';
        $validation['category_id'] = 'required';
        $validation['sku'] = 'required|unique:product,sku';
        $this->validate($request, $validation, [
            'name.required' => trans('module_validation.name_required'),
        ]);

        if ($request->hasFile('image_product')) {
           
            $file['image_product'] = AppHelper::getUniqueFilename($request->file('image_product'), AppHelper::getImagePath());
            $request->file('image_product')->move(AppHelper::getImagePath(), $file['image_product']);
            $input['image'] = $file['image_product'];
        }

        if($input['date']!='')
        {
            $input['date'] = date("Y-m-d", strtotime($input['date']));
        }
        
        
        $input['created_by'] = $this->user->id;
        $model = Product::create($input);
        session()->flash('success', 'New Product Added Successfully');
        if ($request->get('save_exit')) {
            return redirect('product');
        }
        return redirect('product/create');
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
            return redirect('product');
        }
        $product = Product::findOrFail($id);
        return view('Product.product.show', compact('product'));
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
            'back' => ['title' => '<b><i class="icon-arrow-left52"></i></b> Go Back', 'url' => route('product.index'),
                'attributes' => ['class' => 'btn btn-xs bg-blue btn-labeled heading-btn btn-back', 'title' => 'Back']],
        ]);
        $product = Product::findOrFail($id);

        view()->share('image', $product->image);

        if (empty($product)) {
            session()->flash('error', 'You do not have permission to do that.');
            return redirect()->route('product.index');
        }
        return view('Product.product.edit', compact('product'));
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
        $product = Product::findOrFail($id);

        $validation['name'] = 'required';
        $validation['category_id'] = 'required';
        $validation['sku'] = 'required|unique:product,sku,'.$id;

        $this->validate($request, $validation, [
            'name.required' => trans('module_validation.name_required'),
        ]);

        if ($request->hasFile('image_product')) {
           
            $file['image_product'] = AppHelper::getUniqueFilename($request->file('image_product'), AppHelper::getImagePath());
            $request->file('image_product')->move(AppHelper::getImagePath(), $file['image_product']);
            $product->image = $file['image_product'];
        }

       


        $input = $request->all();

        if($input['date']!='')
        {
            $input['date'] = date("Y-m-d", strtotime($input['date']));
        }

        $input['updated_by'] = $this->user->id;
        $product->update($input);
        session()->flash('success', $this->title . ' Updated Successfully');
        if ($request->get('save_exit')) {
            return redirect('product');
        }
        return redirect()->route('product.edit', $id);
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
        $model = Product::find($id);
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

        return redirect('product');
    }
}
