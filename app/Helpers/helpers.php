<?php
namespace App;
use Illuminate\Support\ServiceProvider;
use App\Models\Mailseting;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class Helpers
{
    function mail($data){
        // dd($user);
        $mailsetting = Mailseting::where('mail_mailer','LIKE','%'.$data['mailseting'].'%')->first();
            // dd($data['mailseting']);
                //  foreach ($mailsettings as $mailsetting) {
                  // $requst->checkbox value  =  sendgrid
                if($data['mailseting'] == 'mailgun'){
                        // dd($mailsetting);
                        $data=[
                        'transport'        => $mailsetting->mail_mailer, 
                        'host'          => $mailsetting->mail_host,
                        'port'          => $mailsetting->mail_port,
                        'encryption'    => 'tls',
                        'username'      => $mailsetting->mail_username,
                        'password'      => $mailsetting->mail_password,
                        'domain'        => $mailsetting->domain,
                        'secret'        => $mailsetting->secret,
                        'from'          =>['address'=>$mailsetting->mail_from,'name'=>'Laravel']
                        ];
                        // dd($da+ta);   
                    Config::set('mail.mailers.smtp',$data);
                    //dd($abc);
                    return $data;
                }elseif($data['mailseting'] == 'smtp'){
                        // dd($mailsetting);
                    $data=[
                        'transport'        => $mailsetting->mail_mailer, 
                        'host'          => $mailsetting->mail_host,
                        'port'          => $mailsetting->mail_port,
                        'encryption'    => 'tls',
                        'username'      => $mailsetting->mail_username,
                        'password'      => $mailsetting->mail_password,
                        'from'          =>['address'=>$mailsetting->mail_from,'name'=>'Laravel']
                    ];
                    // dd($data);
                  Config::set('mail.mailers.smtp',$data);
                //   dd($truw);

                  return $data; // dd('fsd');
            }
        }
    }