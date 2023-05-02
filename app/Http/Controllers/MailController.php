<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendgridMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{

   public function sendMail(){

      $reveiverEmailAddress = "skmanish@teqmavens.com";
      Mail::to($reveiverEmailAddress)->send(new SendgridMail());
      if (Mail::failures() != 0) {
         return "Email has been sent successfully.";
     }
     return "Oops! There was some error sending the email.";
   //  $data = Mail::to('manishsingh19970@gmail.com')->send(new SendgridMail());
   //  return $data;
   }
}
