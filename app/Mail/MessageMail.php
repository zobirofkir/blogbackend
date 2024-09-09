<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;

    /**
     * Create a new message instance.
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }
    
    public function build()
    {
        return $this->to('zobirofkir19@gmail.com')
                    ->subject('New Message Received')
                    ->view('emails.message_received')
                    ->with('messageData', $this->message);
    }
}
