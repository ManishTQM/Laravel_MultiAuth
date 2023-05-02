<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Mail\SendgridMail;
use Illuminate\Support\Facades\Mail;

class NewUserWelcomeMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        $users=$this->user;
        dd($users);
        //Mail::mailer('smtp2')->to($users->email)->send(new SendgridMail($users));
     
        Mail::to($users->email)->send(new SendgridMail($users));
        dd($users->email);
        return "hello";
    }
}
