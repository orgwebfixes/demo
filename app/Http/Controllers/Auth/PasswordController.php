<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Centaur\AuthManager;
use DB;
use Illuminate\Http\Request;
use Mail;
use Reminder;
use Sentinel;
use Session;
use App\Mail\ResetPasswordMail;

class PasswordController extends Controller
{
    /** @var Centaur\AuthManager */
    protected $authManager;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(AuthManager $authManager)
    {
        $this->middleware('sentinel.guest');
        $this->authManager = $authManager;
    }

    /**
     * Show the password reset request form
     * @return View
     */
    public function getRequest()
    {
        return view('admin.auth.reset');
    }

    /**
     * Send a password reset link
     * @return Response|Redirect
     */
    public function postRequest(Request $request)
    {
        // Validate the form data
        $result = $this->validate(
            $request,
            [
            'email' => 'required|email|max:255'],
            [
                'email.required' => trans('module_validation.email_required'),
            ]
        );

        // Fetch the user in question
        $user = Sentinel::findUserByCredentials(['email' => $request->get('email')]);

        // Only send them an email if they have a valid, inactive account
        if ($user) {
            // Generate a new code
            $reminder = Reminder::create($user);

            // Send the email
            $code = $reminder->code;
            $email = $user->email;

            $bcc = explode(',', config('project.bccmail'));
            $message = Mail::to($email);
            if (!empty($bcc)) {
                $message->bcc($bcc);
            }
            $message->queue(new ResetPasswordMail(['code' => $code]));

            $message = trans('comman.message_for_email_sent');

            if ($request->ajax()) {
                return response()->json(['message' => $message, 'code' => $code], 200);
            }
            Session::put('success', $message);
            return redirect()->route('auth.login.form');
        } else {
            Session::put('error', trans('comman.wrong_password'));
            return redirect()->back();
        }
    }

    /**
     * Show the password reset form if the reset code is valid
     * @param  Request $request
     * @param  string  $code
     * @return View
     */
    public function getReset(Request $request, $code)
    {
        // Is this a valid code?
        if (!$this->validatePasswordResetCode($code)) {
            // This route will not be accessed via ajax;
            // no need for a json response
            Session::flash('error', trans('comman.invalid_expired'));
            return redirect()->route('dashboard');
        }
        return view('admin.auth.password')
            ->with('code', $code);
    }

    /**
     * Process a password reset form submission
     * @param  Request $request
     * @param  string  $code
     * @return Response|Redirect
     */
    public function postReset(Request $request, $code)
    {
        // Validate the form data
        $result = $this->validate(
            $request,
            [
            'password' => 'required|confirmed|min:6'],
            [
                'password.required' => trans('module_validation.password_required'),
            ]
        );

        // Attempt the password reset
        $result = $this->authManager->resetPassword($code, $request->get('password'));
        // This Code Sending new password
        $user_id = DB::table('reminders')->select('user_id')
            ->where('code', $code)->first();

        $user = Sentinel::findById($user_id->user_id);
        $email = $user->email;

        // Send the email
        Mail::queue('admin.email.newPassword', ['email' => $email], function ($message) use ($email) {
            $message->to($email)->subject('Your new password on Production');
            $bcc = explode(',', config('project.bccmail'));
            if (!empty($bcc)) {
                $message->bcc($bcc);
            }
        });

        if ($result->isFailure()) {
            return $result->dispatch();
        }

        // Return the appropriate response
        return $result->dispatch(route('auth.login.form'));
    }

    /**
     * @param  string $code
     * @return boolean
     */
    protected function validatePasswordResetCode($code)
    {
        return DB::table('reminders')
            ->where('code', $code)
            ->where('completed', false)->count() > 0;
    }
}
