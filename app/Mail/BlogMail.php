<?php
namespace App\Mail;

use App\Models\Blog;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;  
use Illuminate\Queue\SerializesModels;

class BlogMail extends Mailable
{
    use Queueable, SerializesModels;

    public $blog;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Blog $blog)
    {
        $this->blog = $blog;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Blog Created Successfully')
                    ->view('emails.blog_created');
    }
}
