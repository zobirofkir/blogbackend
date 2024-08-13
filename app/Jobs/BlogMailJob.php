<?php

namespace App\Jobs;

use App\Mail\BlogMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class BlogMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $blog;
    protected $userEmail;

    /**
     * Create a new job instance.
     *
     * @param mixed $blog
     * @param string $userEmail
     */
    public function __construct($blog, $userEmail)
    {
        $this->blog = $blog;
        $this->userEmail = $userEmail;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->userEmail)->send(new BlogMail($this->blog));
    }
}
