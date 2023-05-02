<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class WelcomeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $user;
    protected $data;

    public function __construct($user,$data)
    {
        $this->user = $user;
        $this->data = $data;
        // dd($data);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users=$this->user;
        $data=$this->data;
        $maildata = \App\Helpers::mail($data);
        $xyz =Config::get('mail');
        // dd('first',$maildata,'second',$xyz);
        Mail::to($users->email)->send(new WelcomeMail($users));
        return "hello";
    }
}
