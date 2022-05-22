<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data = [])
    {
        view()->share('code', $data['code']);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build($data = [])
    {
        return $this->subject('Forgot Password on Production')->view('admin.email.reset');
    }
}
