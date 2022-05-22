<?php

namespace App\DataTables;

use App\Models\Role;
use Sentinel;
use Yajra\DataTables\Services\DataTable;

class RolesDatatable extends DataTable
{
    // protected $printPreview  = 'path.to.print.preview.view';

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('action', function ($row) {
                return $this->checkrights($row);
            })
            ->addColumn('users', function ($row) {
                $count = $row->users;
                return $count->count();
            })
            ->make(true);
    }

    public function checkrights($row)
    {
        $user = Sentinel::getUser();

        $menu = '';

        $editurl = route('roles.edit', $row->id);
        $deleteurl = route('roles.destroy', $row->id);
        $showUrl = route('roles.show', $row->id);

        if ($user->hasAnyAccess(['roles.update', 'roles.delete'])) {
            $menu .= '<td class="text-center">
                    <ul class="icons-list">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-menu9"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">';
        }

        if ($user->hasAccess(['roles.update'])) {
            $menu .= '<li><a href="' . $editurl . '" title="Edit"><i class="icon-pencil7"></i>Edit</a></li>';
        }

        if ($user->hasAccess(['roles.delete'])) {
            $menu .= '<li><a href="' . $deleteurl . '" data-method="delete" data-modal-text=" <b>' . $row->name . '</b> ' . trans('comman.role') . '?" data-original-title="Delete Role" class="action_confirm text-danger-600" title="Delete"><i class="icon-trash"></i>Delete</a></li>';
        }
        if ($user->hasAnyAccess(['roles.update', 'roles.delete'])) {
            $menu .= '</ul></li></ul></td>';
        }

        return $menu;
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $models = Role::with('users')->select();

        if (request()->get('name', false)) {
            $models->where('name', 'like', '%' . request()->get('name') . '%');
        }
        if (request()->get('slug', false)) {
            $models->where('slug', 'like', '%' . request()->get('slug') . '%');
        }
        return $this->applyScopes($models);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->parameters(['searching' => false])
            ->columns($this->getColumns())
            ->ajax('');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns()
    {
        return [
            ['data' => 'name', 'name' => 'name', 'title' => trans('comman.name')],
            ['data' => 'slug', 'name' => 'slug', 'title' => trans('comman.slug')],
            ['name' => 'users', 'data' => 'users', 'title' => trans('comman.users'), 'orderable' => false, 'searchable' => false],
            ['data' => 'action', 'name' => 'action', 'title' => trans('comman.action'), 'render' => null, 'orderable' => false, 'searchable' => false, 'exportable' => false, 'printable' => false, 'footer' => '', 'width' => '80px'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Role';
    }

    private function getFilterColumns()
    {
        return ['name', 'slug'];
    }
}
