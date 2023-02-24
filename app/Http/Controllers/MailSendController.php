<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

class MailSendController extends Controller
{
    public function sendRegEngComplete(){

    	$data = [
			'user_name' => '日向翔陽1',
			'user_login_id' => 'hinatashoyo@gmailxx.com1',
		];
    /*	Mail::send('layout_section.layout_section_mail.section_mail_send', $data, function($message){
    	    $message->to('shutaro.sasaki@gmail.com', 'Test')
                ->subject('This is a test mail');
    	});
	*/
		
		Mail::to('shutaro.sasaki@gmail.com')->send(new SendMail($data));

Log::debug("メール送信完了");

		return view('layout_section.layout_section_mail.section_mail_send', $data);
    }

}
