<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MessageNotApprove extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    /**
     * Create a new message instance.
     */
    public function __construct(Request $request)
    {
        $this->email = $request;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        $recipient_email = 'admin@dashboard-admin.com';
        // dd($this->email);

        return $this->from($recipient_email)
            ->subject('Dashboard Admin Forgot Password')
            ->view('email')
            ->to('info@dashboard-admin.com')
            ->replyTo($this->email->email)
            ->with(
                [
                    'name' => $this->email->name,
                    'content' => $this->email->message,
                    'date' => $this->email->date
                ]
            );
    }
}
