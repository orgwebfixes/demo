<?php

namespace App\Http\Controllers;

use App;
use AppHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User_Profile;
use Flash;
use Illuminate\Http\Request;
use Redirect;
use Sentinel;

class UserProfilesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('sentinel.access:users.profile_view', ['only' => ['getProfile']]);
        view()->share('title', 'User Profile');
        AppHelper::path('uploads/user/');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getProfile(Request $request)
    {
        $user_id = $this->user->id;
        /* Get States */

        $userData = User::where('id', $user_id)->first();

        view()->share('user_image', $userData->image);
        view()->share('title', trans('comman.user_profile'));

        return view('admin.user_profiles.profile', [
            'userData' => $userData,
        ]);
    }

    /**
     * Update a Changes Of Profile.
     *
     * @return Response
     */
    public function postProfile(Request $request)
    {
        $result = $this->validate(
            $request,
            [
            'name' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif|max:2048',
            'password' => 'confirmed|min:6|required_with:current_password|regex:/^(?=.*?[A-Za-z])(?=.*?[0-9])(?=.*[$!@#$%^_&*!?)(,]{1,}).{6,}$/',
        ],
            [
                'name.required' => trans('module_validation.name_required'),
                'password.confirmed' => trans('module_validation.password_confirmed'),
                'password.regex' => 'password will be one special charator,number,and alphabet',
                'image.uploaded' => 'The image may not be greater than 2MB.',
            ]
        );

        $input = $request->except('_token', 'psk_id', 'email');
        $user_id = $this->user->id;
        $input['user_id'] = $this->user->id;

        if ($request->hasFile('image')) {
            $result = $this->validate($request, [
                'image' => 'mimes:jpeg,jpg,png|max:2048',
            ], ['image.mimes' => 'The image field must be image.']);
            $file['image'] = AppHelper::getUniqueFilename($request->file('image'), AppHelper::getImagePath());
            $request->file('image')->move(AppHelper::getImagePath(), $file['image']);
            $input['image'] = $file['image'];
        }

        $user = User::findOrFail($user_id);
        if (isset($input['image'])) {
            $user->image = $input['image'];
        }
        $user->name = $input['name'];
        $user->mobile_no = $input['mobile_no'];
        $user->save();
        if ($request->get('current_password')) {
            $result = $this->validate($request, [
                'current_password' => 'validate_currentpassword'], [
                'current_password.validate_currentpassword' => trans('validation.validate_currentpassword'),
            ]);
        }

        if ($request->get('password')) {
            $editUser = Sentinel::getUser();
            $credentials['password'] = bcrypt($request->get('password'));
            $editUser->update($credentials);
        }

        Flash::success('User Profile Updated!');

        return Redirect::route('update.profile')->withInput();
    }
}
