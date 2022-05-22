<?php
namespace Onzup\Services;

use Mail;

/**
 * This class is onzup service for sending emails.
 */
class Email
{
    public function send($view, $data, $to, $from, $subject, $files)
    {
        if (env('MAIL_PRETEND', true)) {
            return true;
        }
        echo "test";
        Mail::queue($view, $data, function ($message) use ($to, $from, $subject, $files) {
            $message->from($from);
            $message->subject($subject);
            $message->to($to);
        });
    }
}
