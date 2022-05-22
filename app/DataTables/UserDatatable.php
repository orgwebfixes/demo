<?php

namespace App\DataTables;

use AppHelper;
use Crypt;
use Html;
use Request;
use Sentinel;
use URL;
use Yajra\DataTables\Services\DataTable;

class UserDatatable extends DataTable
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
            ->editColumn('image', function ($row) {
                if (isset($row->image) && !empty($row->image)) {
                    $file = '/uploads/user/' . $row->image;
                    if (file_exists(public_path() . $file)) {
                        $img = URL::to('uploads/user/' . $row->image);
                    } else {
                        $img = URL::to('uploads/default.jpg');
                    }
                    $user_image = '<a href=' . $img . " data-popup='lightbox'>";
                    $user_image .= Html::image(AppHelper::path('uploads/user/')->size('100x100')->getImageUrl($row->image), 'User Photo', ['class' => 'img-rounded img-preview']);
                    $user_image .= '</a>';
                    return $user_image;
                } else {
                    $user_image = '<a href=' . URL::to('uploads/default.jpg') . " data-popup='lightbox'>";
                    $user_image .= Html::image(AppHelper::size('100x100')->getImageUrl(), 'User Photo', ['class' => 'img-rounded img-preview']);
                    $user_image .= '</a>';
                    return $user_image;
                }
            })
            ->editColumn('id', function ($row) {
                $data = $row->getFullName()->first();
                return $data['name'];
            })
            ->editColumn('role', function ($row) {
                if ($row->UsersRole) {
                    $data = $row->UsersRole->roleName()->first();
                    if ($data) {
                        return $data['name'];
                    } else {
                        return '';
                    }
                } else {
                    return '';
                }
            })
            ->editColumn('status', function ($row) {
                if ($row->activations[0]->completed) {
                    $status = 'Active';
                    return $status;
                } else {
                    $status = 'Inactvie';
                    return $status;
                }
            })
            ->make(true);
    }

    public function checkrights($row)
    {
        $user = Sentinel::getUser();
        $menu = '';

        $editurl = route('users.edit', $row->id);
        $object_id = $row->object_id;
        $deleteurl = route('users.destroy', $row->id);
        $activeDeactiveurl = route('users.activeDeactive', $row->id);
        $showUrl = route('users.show', $row->id);
        if ($user->hasAnyAccess(['users.view', 'users.update', 'users.delete'])) {
            $menu .= '<td class="text-center">
                    <ul class="icons-list">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-menu9"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">';
        }
        if ($user->hasAnyAccess(['users.view'])) {
            $menu .= '<li><a href="#" data-user-show=' . $row->id . ' data-lang=' . $showUrl . ' title="View">
                            <i class="icon-file-eye"></i>View</a></li>';
        }

        if ($user->hasAccess(['users.update'])) {
            $menu .= '<li><a href="' . $editurl . '" title="Edit"><i class="icon-pencil7"></i>Edit
            </a></li>';
        }

        if ($user->hasAccess(['users.delete'])) {
            $menu .= '<li><a href="' . $deleteurl . '" data-method="delete" data-modal-text=" <b>' . $row->name . '</b> ' . trans('comman.user') . '?" data-original-title="Delete User" class="action_confirm text-danger-600" title="Delete"><i class="icon-trash"></i>Delete</a></li>';
        }

        if ($user->hasAccess(['users.activeDeactive'])) {
            if (isset($row->activations) && isset($row->activations[0]->completed) && $row->activations[0]->completed == 1) {
                $menu .= '<li><a href="' . $activeDeactiveurl . '" title="Inactive User"><i class="fa fa-user fa-lg"></i>Inactive User
            </a></li>';
            } else {
                $menu .= '<li><a href="' . $activeDeactiveurl . '" title="Active User"><i class="fa fa-user-times fa-lg"></i>Active User
            </a></li>';
            }
        }

        if ($user->hasAnyAccess(['users.view', 'users.update', 'users.delete'])) {
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
        $userRepository = app()->make('sentinel.users');
        $models = $userRepository->createModel()->with('activations')->whereHas('activations', function ($query) {
        })->with('getFullName')->with('UsersRole.roleName')->select();
        if (request()->get('id', false)) {
            $models->whereHas('getFullName', function ($q) {
                $q->where('name', 'like', '%' . request()->get('id') . '%');
            });
        }
        if (request()->get('email', false)) {
            $models->where('email', 'like', '%' . request()->get('email') . '%');
        }
        if (request()->get('mobile_no', false)) {
            $models->where('mobile_no', 'like', '%' . request()->get('mobile_no') . '%');
        }
        if (request()->get('role', false)) {
            $models->whereHas('UsersRole.roleName', function ($q) {
                $q->where('name', 'like', '%' . request()->get('role') . '%');
            });
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
            ->parameters($this->getBuilderParameters())
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
            'name',
            'mobile_no',
            'email',
            'role',
            'status'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Users';
    }

    protected function getBuilderParameters()
    {
        return [
            'drawCallback' => 'function () {
               jQuery(this).find("tbody tr").slice(-3).find(".dropdown, .btn-group").addClass("dropup");
            }',
            'preDrawCallback' => 'function () {
               jQuery(this).find("tbody tr").slice(-3).find(".dropdown, .btn-group").removeClass("dropup");
            }',
            'order' => [[1, 'desc']],
        ];
    }

    private function getFilterColumns()
    {
        return ['id', 'email', 'status', 'image', 'mobile_no', 'psk_id'];
    }
}
