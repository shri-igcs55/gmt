<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Email_sms {

	var $CI;
	public function Email_sms() {
		
		$this->CI = &get_instance();
		$this->CI->load->library('email');
	}

    public function send_email_method($to_email, $subject, $message)
    {
    	$from_email = "noreply@getmytruck.in";

    	$this->CI->email->from($from_email, 'Getmytruck.in'); 
        $this->CI->email->to($to_email);
		$this->CI->email->subject($subject); 
		$this->CI->email->message($message);
		
		$send_email_status = $this->CI->email->send();

		return $send_email_status;
	}

	public function send_sms_method($to_number, $message)
    {

    	$gateway_user = "developer2@indglobal-consulting.com:indglobal123";
    	$from_sender = "TEST SMS";

    	$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "user=".$gateway_user."&senderID=".$from_sender."&receipientno=".$to_number."&msgtxt=".$message);
		$buffer = curl_exec($ch);
		curl_close($ch);

		return $buffer;
    }
}