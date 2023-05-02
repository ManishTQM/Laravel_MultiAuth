<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Mailseting;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//          $mailsettings = Mailseting::all();
// // dd($mailsetting);
//          foreach ($mailsettings as $mailsetting) {
//           // $requst->checkbox value  =  sendgrid
//         if($mailsetting->status == 1){
//             // dd($mailsetting);
//             $data=[
//                'driver'        => $mailsetting->mail_mailer, 
//                'host'          => $mailsetting->mail_host,
//                'port'          => $mailsetting->mail_port,
//                'encryption'    => 'tls',
//                'username'      => $mailsetting->mail_username,
//                'password'      => $mailsetting->mail_password,
//                'domain'        => $mailsetting->domain,
//                'secret'        => $mailsetting->secret,
//                'from'          =>['address'=>$mailsetting->mail_from,'name'=>'Laravel']
//             ];
//             // dd($data);   
//          Config::set('mail',$data);
//         }else{
//             $data=[
//                 'driver'        => $mailsetting->mail_mailer, 
//                 'host'          => $mailsetting->mail_host,
//                 'port'          => $mailsetting->mail_port,
//                 'encryption'    => 'tls',
//                 'username'      => $mailsetting->mail_username,
//                 'password'      => $mailsetting->mail_password,
//                 // 'domain'        => $mailsetting->domain,
//                 // 'secret'        => $mailsetting->secret,
//                 'from'          =>['address'=>$mailsetting->mail_from,'name'=>'Laravel']
//              ];
//             // dd('fsd');
    // }
// }
// }
    }
}
