<?php

namespace App\DataTables;

use App\Models\Product;
use Yajra\DataTables\Services\DataTable;
use Sentinel;
use Html;

class ProductDatatable extends DataTable
{

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return datatables()
                    ->eloquent($this->query())
                    ->editColumn('status', function ($row) {
                        if ($row->status == 1) {
                            $temp_no = $row->status == 1 ? 'Active' : $row->status;
                            return HTML::decode("<label class='badge badge-success'>{$temp_no}</label>");
                        } else {
                            $temp_no = $row->status == 0 ? 'Inactive' : $row->status;
                            return HTML::decode("<label class='badge badge-danger'>{$temp_no}</label>");
                        }
                    })
                    ->editColumn('category_id', function ($row) {
                        return $row->getCategory->name;
                    })
                    ->addColumn('action', function ($row) {
                        return $this->checkrights($row);
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
    }

    public function checkrights($row)
    {
        $user = Sentinel::getUser();

        $menu = '';

        $token = csrf_token();

        $editurl = route('product.edit', $row->id);
        $deleteurl = route('product.destroy', $row->id);
        $showUrl = route('product.show', $row->id);
            $menu .= '<td class="text-center">
                    <ul class="icons-list">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-menu9"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">';
     
          

            $menu .= '<li><a href="' . $editurl . '" title="Edit"><i class="icon-pencil7"></i> ' . trans('comman.edit') . '</a></li>';

            $menu .= '<li><a href="' . $deleteurl . '" data-method="delete" data-modal-text=" <b>' . $row->name . '</b> ' . 'product' . '?" data-original-title="Delete currency" class="action_confirm text-danger-600" title="Delete"><i class="icon-trash"></i> ' . trans('comman.delete') . '</a></li>';
            $menu .= '</ul></li></ul></td>';

        return $menu;
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $status = request()->get('status');
        $models = Product::with('getCategory')->select();
        if (request()->get('name', false)) {
            $models->where('name', 'like', '%' . request()->get('name') . '%');
        }
     
        if (isset($status) && $status != 'Select Status') {
            $models->where('status', $status);
        }

        return $this->applyScopes($models);
    }
}
