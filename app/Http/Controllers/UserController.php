<?php

namespace App\Http\Controllers;

use App;
use AppHelper;
use App\DataTables\UserDatatable;
use App\DataTables\UserNotActiveDatatable;
use App\Models\RoleUser;
use App\Models\User;
use App\Models\UserProcess;
use Carbon\Carbon;
use Centaur\AuthManager;
use DB;
use Illuminate\Http\Request;
use Sentinel;

class UserController extends Controller
{
    /** @var Cartalyst\Sentinel\Users\IlluminateUserRepository */
    protected $userRepository;

    /** @var Centaur\AuthManager */
    protected $authManager;

    protected $roleUser;

    public function __construct(AuthManager $authManager)
    {
        parent::__construct();
        $this->title = 'Users';
        view()->share('title', $this->title);
        $this->userModel = new User;
        AppHelper::setClass(__class__);

        // Middleware
        $this->middleware('sentinel.auth');
        $this->middleware('sentinel.access:users.create', ['only' => ['create', 'store']]);
        $this->middleware('sentinel.access:users.view', ['only' => ['index', 'show']]);
        $this->middleware('sentinel.access:users.update', ['only' => ['edit', 'update']]);
        $this->middleware('sentinel.access:users.delete', ['only' => ['destroy']]);
        $this->middleware('sentinel.access:users.activeDeactive', ['only' => ['activeDeactive']]);
        // Dependency Injection
        $this->userRepository = app()->make('sentinel.users');
        $this->activations = app()->make('sentinel.activations');

        $this->authManager = $authManager;
        view()->share('module_title', 'Users');
        view()->share('title', 'Users');
        AppHelper::path('uploads/user/');
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserDatatable $dataTable)
    {
        $action_nav = [
            'add_new' => ['title' => '<b><i class="icon-diff-added"></i></b> Add User', 'url' => route('users.create'), 'attributes' => ['class' => 'btn bg-success btn-labeled heading-btn btn-add', 'title' => 'Add New']],
        ];
        if (!$this->user->hasAccess(['users.create'])) {
            unset($action_nav['add_new']);
        }
        view()->share('module_action', $action_nav);
        return $dataTable->render('admin.users.index');
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        view()->share('module_title', 'Add Users');

        if ($this->user->hasAccess(['users.create'])) {
            view()->share('module_action', [
                'back' => [
                    'title' => '<b><i class="icon-arrow-left52"></i></b> Go Back', 'url' => route('users.index'),
                    'attributes' => ['class' => 'btn btn-xs bg-blue btn-labeled heading-btn btn-back', 'title' => 'Back'],
                ],
            ]);
        }

        // Process

        $roles = app()->make('sentinel.roles')->createModel()->all();

        view()->share('title', 'Users');
        view()->share('roles_required', true);
        return view('admin.users.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->validate(
            $request,
            [
                'name' => 'required',
                'roles' => 'required',
                'mobile_no' => 'required|regex:/^[6-9]{1}[0-9]{9}$/',
                'email' => 'required|email|max:255',
                'password' => 'required|confirmed|min:6|regex:/^(?=.*?[A-Za-z])(?=.*?[0-9])(?=.*[$!@#$%^_&*!?)(,]{1,}).{6,}$/',
                'image' => 'mimes:jpeg,jpg,png|max:2048',
            ],
            [
                'mobile_no.required' => trans('module_validation.mobile_no_required'),
                'mobile_no.regex' => 'Please enter valid Mobile Number i.e. 9000000000',
                'roles.required' => trans('module_validation.roles_required'),
                'email.required' => trans('module_validation.email_required'),
                'password.required' => trans('module_validation.password_required'),
                'password.regex' => 'password will be one special character,number,and alphabet',
                'image.mimes' => 'The image field must be image.',
                'image.uploaded' => 'The image may not be greater than 2MB.',
                'name.required' => trans('module_validation.name_required'),
            ]
        );
        $getExistUser = User::select(['id'])->where('email', trim($request->get('email')))->first();
        if (!empty($getExistUser)) {
            session()->flash('error', 'The E-mail has already been taken.');
            return redirect()->back()->withInput();
        }
        $tracedRecord = User::withTrashed()->where('email', trim($request->get('email')))->first();
        if (!empty($tracedRecord)) {
            $tracedRecord->forceDelete();
        }
        // Assemble registration credentials and attributes
        $credentials = [
            'email' => trim($request->get('email')),
            'name' => $request->get('name', null),
            'password' => $request->get('password', null),
            'mobile_no' => $request->get('mobile_no', null),
        ];
        $activate = (bool) $request->get('activate', false);

        if ($request->hasFile('image')) {
            $file['image'] = \AppHelper::getUniqueFilename($request->file('image'), AppHelper::getImagePath());
            $request->file('image')->move(AppHelper::getImagePath(), $file['image']);
            $credentials['image'] = $file['image'];
        }

        DB::beginTransaction();
        try {
            $result = $this->authManager->register($credentials, $activate);
            if ($result->isFailure()) {
                return $result->dispatch;
            }
            // Do we need to send an activation email?

            // Assign User Roles
            $result->user->roles()->sync([$request->get('roles')]);

            DB::commit();

            //send user info to ajax response if request is ajax
            if ($request->ajax()) {
                return response()->json([
                    'success' => 'true',
                    'data' => $result->user,
                ]);
            }
        } catch (Exception $e) {
            DB::rollback();
        }

        if (!$activate) {
            $result->setMessage(trans('comman.user') . ' ' . $request->get('email') . trans('comman.created') . trans('comman.user_added_active'));
        }
        session()->flash('success', 'New User Added Successfully');
        if ($request->get('save_exit')) {
            return redirect()->route('users.index');
        } else {
            return redirect()->route('users.create');
        }
    }

    /**
     * Display the specified user.
     *
     * @param  string  $hash
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $userData = Sentinel::findById($id);
        if (empty($userData)) {
            $response = ['status' => 'fail', 'message' => 'The Requested User not found !'];
            return $response;
        }
        $userRole = DB::table('role_users')
        ->join('roles', 'roles.id', '=', 'role_users.role_id')
        ->where('role_users.user_id', '=', $id)
        ->get()->first();
        $userData->role = $userRole->name;
        $userActivation = DB::table('activations')->select('completed')->where('user_id', $id)->first();
        if ($userActivation->completed == 1) {
            $userData->activations = false;
        } else {
            $userData->activations = true;
        }
        return view('admin.users.show', ['userData' => $userData]);
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  string  $hash
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        // Fetch the user object
        view()->share('module_title', 'Edit Users');
        view()->share('module_action', [
            'back' => ['title' => '<b><i class="icon-arrow-left52"></i></b> Go Back', 'url' => request()->get('_url', route('users.index')), 'attributes' => ['class' => 'btn bg-blue btn-labeled heading-btn btn-back', 'title' => 'Back']],
        ]);
        $user = $this->userRepository->findById($id);

        $user['name'] = $user->name;
        $user['mobile_no'] = $user->mobile_no;
        $user['image'] = $user->image;

        // Fetch the available roles
        $roles = app()->make('sentinel.roles')->createModel()->all();

        // Fetch the active status
        $active = app()->make('sentinel.activations')->select('completed')->where('activations.user_id', $id)->first();
        //Check for activation
        if (isset($active)) {
            view()->share('activate', $active->completed);
        }
        view()->share('title', 'Edit User');
        if ($user) {
            return view('admin.users.edit', [
                'user' => $user,
                'roles' => $roles,
            ]);
        }

        session()->flash('error', 'Invalid User Selected');
        return redirect()->to(request()->get('_url', route('users.index', request()->get('_url'))));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $hash
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = $this->validate(
            $request,
            [
                'name' => 'required',
                'email' => 'required|email|max:255|unique:users,email,' . $id,
                'password' => 'confirmed|min:6|regex:/^(?=.*?[A-Za-z])(?=.*?[0-9])(?=.*[$!@#$%^_&*!?)(,]{1,}).{6,}$/',
                'roles' => 'required',
                'image' => 'mimes:jpeg,jpg,png|max:2048',
                'mobile_no' => 'required|regex:/^[6-9]{1}[0-9]{9}$/',
            ],
            [
                'email.required' => trans('module_validation.email_required'),
                'email.unique' => trans('module_validation.email_unique'),
                'password.required' => trans('module_validation.password_required'),
                'roles.required' => trans('module_validation.roles_required'),
                'password.regex' => 'password will be one special character,number,and alphabet',
                'image.mimes' => 'The image field must be image.',
                'image.uploaded' => 'The image may not be greater than 2MB.',
                'name.required' => trans('module_validation.name_required'),
                'mobile_no.required' => trans('module_validation.mobile_no_required'),
                'mobile_no.regex' => 'Please enter valid Mobile Number i.e. 9000000000',
            ]
        );
        $attributes = [
            'email' => trim($request->get('email')),
            'name' => $request->get('name', null),
            'mobile_no' => $request->get('mobile_no', null),
        ];

        $activate = (bool) $request->get('activate', false);

        //Attachments
        if ($request->hasFile('image')) {
            $file['image'] = \AppHelper::getUniqueFilename($request->file('image'), AppHelper::getImagePath());
            $request->file('image')->move(AppHelper::getImagePath(), $file['image']);
            $attributes['image'] = $file['image'];
        }
        // Do we need to update the password as well?
        if ($request->has('password') && !empty($request->get('password'))) {
            $attributes['password'] = $request->get('password');
        }

        // Fetch the user object
        $user = $this->userRepository->findById($id);

        // Update the user
        $user = $this->userRepository->update($user, $attributes);
        // Code for Activation Update
        if (isset($user->id)) {
            $activation = $this->activations->where('user_id', $user->id)->first();
            if (isset($activation)) {
                $activation->completed = $activate;
                $activation->completed_at = Carbon::now()->format('Y-m-d H:i:s');
                $activation->save();
            }
        }

        $user->roles()->sync([$request->get('roles')]);

        if ($request->has('process_id')) {
            foreach ($request->get('process_id') as $process) {
                $process = ['user_id' => $user->id, 'process_id' => $process];
                UserProcess::create($process);
            }
        }

        session()->flash('success', $user->email . ' ' . trans('comman.updated'));
        if ($request->get('save_exit')) {
            return redirect()->to(request()->get('_url', route('users.index')));
        } else {
            return redirect()->route('users.edit', $id);
        }
    }

    public function autologin($id, Request $request)
    {
        $id = \Crypt::decrypt($id);
        $user = Sentinel::findById($id);
        if ($user) {
            Sentinel::login($user);
            if (Sentinel::check()) {
                return redirect()->route('dashboard');
            }
            return redirect()->back();
        }
    }

    public function status($id, Request $request)
    {
        if ($request->get('status')) {
            $update_Status = $request->get('status');
            $user = Sentinel::findById($id);
            $user->status = $update_Status;
            $user->save();
            session()->flash('success', trans('comman.StatusChange'));
        }
        if ($request->get('tmp') || $request->get('flag') == 1) {
            return redirect()->route('users.notActive');
        }
        return redirect()->route('users.index');
    }

    //This Method if Displayed Only NotActive user
    public function notActive(UserNotActiveDatatable $dataTable)
    {
        $action_nav = [
            'add_new' => ['title' => '<b><i class="icon-diff-added"></i></b> ' . trans('comman.add_user'), 'url' => route('users.create'), 'attributes' => ['class' => 'btn btn-xs bg-success btn-labeled heading-btn', 'title' => 'Add New']],
        ];
        if (!$this->user->hasAccess(['users.create'])) {
            unset($action_nav['add_new']);
        }
        view()->share('module_action', $action_nav);
        return $dataTable->render('admin.users.notActive');
    }

    //This method is used to check Current Password
    public function checkCurrentPassword($password)
    {
        $user = Sentinel::getUser();
        $credentials = [
            'password' => $password,
        ];
        $result = Sentinel::validateCredentials($user, $credentials);
        return $result;
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
        $model = User::find($id);
        if ($model) {
            $dependency = $this->userModel->deleteValidate($id);
            if (!$dependency) {
                $model->delete();
                RoleUser::where('user_id', $id)->delete();
                session()->flash('success', $model->email . ' ' . trans('comman.removed'));
            } else {
                Flash::error('User "' . $model->email . '" can\'t delete as used in ' . $dependency);
            }
        } else {
            Flash::error($this->title . ' Not deleted as you don\'t have permission!');
        }
        return redirect()->route('users.index');
    }

    /**
     * [activeDeactive description]
     * @return [type] [description]
     */
    public function activeDeactive($id)
    {
        $model = User::find($id);
        if (empty($model)) {
            Flash::error($this->title . ' Not deleted as you don\'t have permission!');
        }

        $activation = $this->activations->where('user_id', $id)->first();
        if (!empty($activation)) {
            if ($activation->completed == 1) {
                $activation->completed = 0;
                session()->flash('success', $model->email . ' has been inactive.');
            } else {
                session()->flash('success', $model->email . ' has been active.');
                $activation->completed = 1;
            }
            $activation->completed_at = Carbon::now()->format('Y-m-d H:i:s');
            $activation->save();
            return redirect()->route('users.index');
        }
        Flash::error('Sorry user permission not found.');
        return redirect()->route('users.index');
    }
}
