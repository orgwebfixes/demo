<?php

namespace App\Http\Controllers\Auth;

use Config;
use Sentinel;
use Session;
use Flash;
use Centaur\AuthManager;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Event;
use Lang;
use App\Models\OtpTransection;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use App\Events\SendOtp;
use Centaur\Replies\ExceptionReply;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;

class SessionController extends Controller
{
    /** @var Centaur\AuthManager */
    protected $authManager;
    protected $userRepository;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(AuthManager $authManager)
    {
        $this->middleware('sentinel.guest', ['except' => 'getLogout']);
        $this->authManager = $authManager;
        $this->userRepository = app()->make('sentinel.users');
    }

    /**
     * Show the Login Form
     * @return View
     */
    public function getLogin()
    {
        return view('admin.auth.login');
    }

    /**
     * Show the OTP Login Form
     * @return View
     */
    public function getOtpLogin()
    {
        return view('admin.auth.otp-login');
    }

    /**
     * Handle a Login Request
     * @return Response|Redirect
     */
    public function postLogin(Request $request)
    {
        // Validate the Form Data
        $result = $this->validate(
            $request,
            [
            'email' => 'required',
            'password' => 'required'],
            [
                'email.required' => trans('module_validation.email_required'),
                'password.required' => trans('module_validation.password_required'),
            ]
        );

        // Assemble Login Credentials
        $credentials = [
            'login' => str_replace(' ', '', $request->get('email')),
            'password' => $request->get('password'),
        ];

        $remember = (bool) $request->get('remember', false);

        // Attempt the Login
        try {
            $result = $this->authManager->authenticate($credentials, $remember);
            if ($result->statusCode == '500' && $result->exception instanceof ThrottlingException) {
                $delay = intval($result->exception->getDelay() / 60) ;
                $delay = $delay > 0 ? $delay : '1';
                $message = 'Suspicious activity has occured on your IP address and you have been denied access for another [' . $delay . '] minute(s).';
                $result->setMessage($message);
            }
        } catch (Exception $e) {
            dd($e);
        }

        $user = Sentinel::getUser();

        // Validate IP Address if not allowe notify to super admin
        if (!empty($user)) {
            $this->validateIPAddress($user);
        }

        if ($user) {
            if ($user->status === 'reject') {
                Session::put('error', trans('This User is banned Please Contact Administrator'));
                $this->authManager->logout(null, null);
                $route = 'auth.login.form';
            }
        }
        if ($result->statusCode === 200) {
            $route = 'dashboard';
        } else {
            $this->authManager->logout(null, null);
            $route = 'auth.login.form';
        }

        // Return the appropriate response
        $path = session()->pull('url.intended', route($route));

        return $result->dispatch($path);
    }

    /**
     * Handle a Login Request
     * @return Response|Redirect
     */
    public function postOtpLogin(Request $request)
    {
        // Validate the Form Data
        $result = $this->validate(
            $request,
            [
            'psk_id' => 'required'],
            [
                'psk_id.required' => 'Mobile no. filed is required.',
            ]
        );
        // Assemble Login Credentials
        $id = trim(str_replace(' ', '', $request->get('psk_id')));
        // Attempt the Login
        $result = $this->userRepository->where('psk_id', $id)->first();
        if (!empty($result)) {
            if (!empty($result['mobile_no'])) {
                $otp_array = [];
                $sucess = [];
                $check = OtpTransection::select('id', 'otp', 'valid_to')->where('user_id', $result->id)->orderBy('valid_to', 'desc')->first();
                $otp_array['user_id'] = $result->id;
                $otp_array['transection_type'] = 'Login';
                $otp_array['created_user_id'] = $result->id;
                $otp_array['otp'] = mt_rand(1000, 9999);
                $otp_array['valid_to'] = Carbon::now()->addHours(config('project.otp_valid_hours'));
                $sucess = OtpTransection::create($otp_array);
                if (!empty($sucess)) {
                    $otp_array['mobile_no'] = $result['mobile_no'];
                }
                $response_json = Event::fire(new SendOtp($otp_array));
                Flash::success('Verification Code has been sent to +91-XXXXX-X' . substr($result['mobile_no'], -4));
                if (($request->get('resend'))) {
                    $update = OtpTransection::where('id', $check->id)->update(['valid_to' => Carbon::now()]);
                    $sucess = 'true';
                    return $sucess;
                } else {
                    return view('admin.auth.otp-login-send', [
                        'GetOtp' => 'true',
                        'psk_id' => $request->get('psk_id'),
                    ]);
                }
            } else {
                Flash::error('PSK ID not have mobile number.');
                return redirect()->back();
            }
        } else {
            Flash::error(trans('comman.invalid_user'));
            return redirect()->back();
        }
    }

    /*
    ** checkOtp form
    */
    public function checkOtp(Request $request)
    {
        $getuser = User::where('psk_id', str_replace(' ', '', $request->get('psk_id')))->first();
        $result = OtpTransection::where('user_id', $getuser->id)->where('otp', $request->get('otp_value'))->first();
        if (!empty($result) && count($result) > 0 && strtotime($result->valid_to) > strtotime(Carbon::now())) {
            $user = Sentinel::findById($getuser->id);
            $update = OtpTransection::where('id', '=', $result->id)->update(['otp_transection.valid_to' => Carbon::now()]);
            $data = Sentinel::login($user);
            return redirect()->route('dashboard');
        } else {
            Flash::error(trans('comman.invalid_otp'));
            return view('admin.auth.otp-login-send', [
                'GetOtp' => 'true',
                'psk_id' => $request->get('psk_id'),
            ]);
        }
    }

    /**
     * Handle a Logout Request
     * @return Response|Redirect
     */
    public function getLogout(Request $request)
    {
        // Terminate the user's current session.  Passing true as the
        // second parameter kills all of the user's active sessions.
        $result = $this->authManager->logout(null, null);

        // Return the appropriate response
        return $result->dispatch(route('auth.login.form'));
    }

    protected function translate($key, $message)
    {
        $key = 'centaur.' . $key;

        if (Lang::has($key)) {
            $message = trans($key);
        }

        return $message;
    }

    public function validateIPAddress($user)
    {
        return true;
        // Get the page we were before
        $allow_ips = Config::get('srtpl.settings.allow_ip', ['103.7.82.11']);
        $clientIps = request()->getClientIps();
        if (!empty($allow_ips)) {
            $allow_ips = explode(',', $allow_ips);
            $clientIp = request()->getClientIp(true);
            $otherIp = null;
            foreach ($allow_ips as $ip) {
                if (in_array($ip, $clientIps)) {
                    $otherIp = $ip;
                }
            }
            if (!in_array($clientIp, $allow_ips) && !in_array(getRealIpAddr(), $allow_ips)) {
                /**
                * Create Notification event
                */
                $notification = [];
                $notification['url'] = '';
                $message = "<table class='table table-bordered'>";
                $message .= "<tr><td colspan='2'><strong> User Login :" . $user->name . '</strong></td></tr>';

                $message .= '<tr>';
                $message .= '<td><b>Email</b></td>';
                $message .= '<td><b>' . $user->email . '</b></td>';
                $message .= '</tr>';

                $message .= '<tr>';
                $message .= '<td><b>Login Time</b></td>';
                $message .= '<td><b>' . $user->last_login->format('d-m-Y H:i:s') . '</b></td>';
                $message .= '</tr>';

                $message .= '<tr>';
                $message .= '<td><b>IP</b></td>';
                $message .= '<td><b>' . $clientIp . '</b></td>';
                $message .= '</tr>';

                $message .= '</table>';
                $message .= "<div class='border-dotted'></div><div class='link_message text-right'></div>";

                $allRoles = Role::select('id', 'permissions')->get();
                $rolesHasPermission = [];
                if ($allRoles->count()) {
                    foreach ($allRoles as $key => $role) {
                        if (isset($role->permissions['users.super_admin']) && $role->permissions['users.super_admin']) {
                            $rolesHasPermission[$role->id] = $role->id;
                        }
                    }
                }
                $userHasPermission = [];
                if (count($rolesHasPermission)) {
                    $userHasPermission = RoleUser::whereIn('role_id', $rolesHasPermission)->get()->toArray();
                }
                $notification['title'] = 'User Login Other Location Detail';
                $notification['message'] = $message;
                $notification['status'] = 'error';
                $notification['created_user_id'] = $user->id;
                $notification['to_user_id'] = array_map('current', $userHasPermission);
                Event::fire('notifications', [$notification]);
            }
        }
    }
}
