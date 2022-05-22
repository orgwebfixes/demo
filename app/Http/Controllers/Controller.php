<?php

namespace App\Http\Controllers;

use AppHelper;
use App\Models\Setting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Onzup\Services\Permission;
use Sentinel;
use View;

// use Imagick;

class Controller extends BaseController
{
    use AuthorizesRequests,
    DispatchesJobs,
        ValidatesRequests;

    protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Sentinel::getUser();
            if ($this->user != null) {
                $settingPermission = 0;
                $explodeEmail = explode('@', $this->user->email);
                if (!empty($explodeEmail) && $explodeEmail[1] == 'savaliya11.ketan@gmail.com') {
                    $settingPermission = 1;
                }
                view()->share('current_user', $this->user);
                view()->share('current_user_name', $this->user->name);
                view()->share('setting_permission', $settingPermission);
            }
            return $next($request);
        });
        $this->permission = new Permission;
        $getAllPermissions = $this->permission->getPermissions();
        view()->share('getAllPermissions', $getAllPermissions);
        View::share('theme', 'limitless.layout');
        if (request()->input('download', false)) {
            View::share('theme', 'limitless.ajax');
        }
        View::share('form_submit_seconds', Setting::where('name', 'form_submit_seconds')->pluck('value')->first());
        AppHelper::setDefaultImage('uploads/default/default.jpg');
    }
}
