<?php

namespace App\Http\Controllers;

use App\DataTables\RolesDatatable;
use App\Models\RoleUser;
use Flash;
use Illuminate\Http\Request;
use Onzup\Services\Permission;
use Sentinel;

class RoleController extends Controller
{
    /** @var Cartalyst\Sentinel\Users\IlluminateRoleRepository */
    protected $roleRepository;

    public function __construct()
    {
        parent::__construct();
        $this->permission = new Permission;

        // Middleware
        $this->middleware('sentinel.auth');
        $this->middleware('sentinel.access:roles.create', ['only' => ['create', 'store']]);
        $this->middleware('sentinel.access:roles.update', ['only' => ['edit', 'update']]);
        $this->middleware('sentinel.access:roles.view', ['only' => ['index', 'show']]);
        $this->middleware('sentinel.access:roles.delete', ['only' => ['destroy']]);

        // Fetch the Role Repository from the IoC container
        $this->roleRepository = app()->make('sentinel.roles');
        view()->share('module_title', 'Roles');
        view()->share('title', trans('comman.role'));
    }

    /**
     * Display a listing of the roles.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RolesDatatable $dataTable)
    {
        $action_nav = [
            'add_new' => ['title' => '<b><i class="icon-diff-added"></i></b> ' . trans('comman.add_role'), 'url' => route('roles.create'), 'attributes' => ['class' => 'btn bg-success btn-labeled heading-btn btn-add', 'title' => 'Add New']],
        ];
        if (!$this->user->hasAccess(['roles.create'])) {
            unset($action_nav['add_new']);
        }
        view()->share('module_action', $action_nav);
        return $dataTable->render('admin.roles.index');
    }

    /**
     * Show the form for creating a new role.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        view()->share('module_title', 'Add Roles');
        view()->share('module_action', [
            'back' => ['title' => '<b><i class="icon-arrow-left52"></i></b> ' . trans('comman.back'), 'url' => route('roles.index'),
                'attributes' => ['class' => 'btn bg-blue btn-labeled heading-btn btn-back', 'title' => 'Back']],
        ]);
        return view('admin.roles.create', [
            'all_permission' => $this->getPermissionArrayToNameWise((new Permission)->getPermissions()),
        ]);
    }

    /**
     * Store a newly created role in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the form data
        $input = $request->all();
        $result = $this->validate(
            $request,
            [
                'name' => 'required',
                'slug' => 'required|alpha_dash|unique:roles'],
            [
                'name.required' => trans('module_validation.name_required'),
                'slug.required' => trans('module_validation.slug_required'),
                'slug.unique' => trans('module_validation.unique_slug_unique'),
            ]
        );

        // Create the Role
        $role = Sentinel::getRoleRepository()->createModel()->create([
            'name' => trim($request->get('name')),
            'slug' => trim($request->get('slug')),
        ]);

        // Cast permissions values to boolean
        $permissions = [];
        foreach ($input['permissions'] as $permission => $value) {
            $permissions[base64_decode($permission)] = ($value != 'false') ? (bool) $value : (bool) '';
        }

        // Set the role permissions
        $role->permissions = $permissions;
        $role->save();

        // All done
        if ($request->ajax()) {
            return response()->json(['role' => $role], 200);
        }
        session()->flash('success', trans('comman.role') . ' ' . "'{$role->name}' " . ' ' . trans('comman.created'));
        if ($request->get('save_exit')) {
            return redirect()->route('roles.index');
        } else {
            return redirect()->route('roles.create');
        }
    }

    /**
     * Display the specified role.
     *
     * @param  string  $hash
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // The roles detail page has not been included for the sake of brevity.
        // Change this to point to the appropriate view for your project.
        return redirect()->route('roles.index');
    }

    /**
     * Show the form for editing the specified role.
     *
     * @param  string  $hash
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        view()->share('module_title', 'Edit Roles');
        view()->share('module_action', [
            'back' => ['title' => '<b><i class="icon-arrow-left52"></i></b> ' . trans('comman.back'), 'url' => route('roles.index'),
                'attributes' => ['class' => 'btn bg-blue btn-labeled heading-btn btn-back', 'title' => 'Back']],
        ]);
        // Fetch the role object
        $role = $this->roleRepository->findById($id);
        if ($role) {
            $groupPermissions = $this->getPermissionJsonToArray($role->permissions);
            $all_permission = $this->getPermissionArrayToNameWise((new Permission)->getPermissions());
            return view('admin.roles.edit', compact('role', 'groupPermissions', 'all_permission'));
        }

        session()->flash('error', trans('comman.invalid_role'));
        return redirect()->back();
    }

    /**
     * Update the specified role in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $hash
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Decode the role id
        // Validate the form data
        $input = $request->all();
        $result = $this->validate(
            $request,
            [
                'name' => 'required',
                'slug' => 'required|alpha_dash|unique:roles,slug,' . $id],
            [
                'name.required' => trans('module_validation.name_required'),
                'slug.required' => trans('module_validation.slug_required'),
                'slug.unique' => trans('module_validation.unique_slug_unique'),
            ]
        );

        // Fetch the role object
        $role = $this->roleRepository->findById($id);
        if (!$role) {
            if ($request->ajax()) {
                return response()->json(trans('comman.invalid_role'), 422);
            }
            session()->flash('error', trans('comman.invalid_role'));
            return redirect()->back()->withInput();
        }

        // Update the role
        $role->name = $request->get('name');
        $role->slug = $request->get('slug');

        // Cast permissions values to boolean
        $permissions = [];
        foreach ($input['permissions'] as $permission => $value) {
            $permissions[base64_decode($permission)] = ($value != 'false') ? (bool) $value : (bool) '';
        }
        // Set the role permissions
        $role->permissions = $permissions;
        $role->save();

        // All done
        if ($request->ajax()) {
            return response()->json(['role' => $role], 200);
        }

        session()->flash('success', 'Role ' . "'{$role->name}' " . ' update.');
        if ($request->get('save_exit')) {
            return redirect()->route('roles.index');
        } else {
            return redirect()->route('roles.edit', $id);
        }
    }

    /**
     * Remove the specified role from storage.
     *
     * @param  string  $hash
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // Fetch the role object
        $role = $this->roleRepository->findById($id);
        $role_user = RoleUser::where('role_id', $id)->get()->first();
        if ($role_user) {
            Flash::error('Role "' . $role->name . '" can\'t delete as used in User');
            return redirect()->route('roles.index');
        }
        $role->delete();
        $message = trans('comman.role') . ' ' . "'{$role->name}'" . ' ' . trans('comman.removed');
        if ($request->ajax()) {
            return response()->json([$message], 200);
        }
        session()->flash('success', $message);
        return redirect()->route('roles.index');
    }

    /**
     * Uses to set name wise array to permission base array
     * INPUT = 'users'=> [ 'users.create', 'users.update', 'users.view', 'users.destroy']
     * OUTPUT = 'users'=> [ 'create', 'update', 'view', 'destroy']
     * @param1 array
     * @return array
     * @uses PermissionController,EmployeeController
     */
    public function getPermissionArrayToNameWise($permission = [])
    {
        // print_r($permission);
        // exit();
        $data = [];
        foreach ($permission as $permission_key => $permission_array) {
            foreach ($permission_array as $permission_name => $permission_value) {
                $permi = explode('.', $permission_value);
                $data[$permi[0]][$permission_name] = [
                    'permission' => base64_encode($permission_value),
                    'label' => $permi[1],
                    'can_inherit' => -1,
                ];
            }
        }
        return $data;
    }

    /**
     * Uses to set name wise JSON to permission base array
     * INPUT = [ 'users.create', 'users.update', 'users.view', 'users.destroy']
     * OUTPUT = 'users'=> [ 'create', 'update', 'view', 'destroy']
     * @param1 array
     * @return array
     * @uses PermissionController,EmployeeController
     */
    public function getPermissionJsonToArray($permission = [])
    {
        // print_r($permission);
        // exit();
        $data = [];
        $i = 0;
        foreach ($permission as $permission_key => $permission_value) {
            $permi = explode('.', $permission_key);
            $data[base64_encode($permission_key)] = $permission_value;
        }
        return $data;
    }
}
