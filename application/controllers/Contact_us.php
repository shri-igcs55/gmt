<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	require('application/libraries/REST_Controller.php');  

/**
* contact us 
*/

//error_reporting(0);
class Contact_us extends REST_Controller
{
	public function Contact_us()
	{
		parent::__construct();
		$this->load->model('contact_us_model');
		$this->load->library('email');
		$this->load->library('email_sms');
		$this->load->library('seekahoo_lib');
		$this->load->library('Validator.php');
		date_default_timezone_set('Asia/Kolkata');
	}

	// user signup
	public function contact_us_post()
	{
		$serviceName = 'contact_us';
		$validation_array = 1;

		//getting posted values
		$ip['full_name']        = trim($this->input->post('full_name'));
		$ip['user_email']       = trim($this->input->post('user_email'));
		$ip['user_mob']         = trim($this->input->post('user_mob'));
		$ip['c_msg']			= trim($this->input->post('contact_msg'));

		$ip['device_token']     = trim($this->input->post('device_token'));

        $ip['created_datetime'] = Date('Y-m-d h:i:s');
        $ip['created_ip']       = $_SERVER['REMOTE_ADDR'];
        
		//validation
		$ip_array[] = array("msg", $ip['user_email'], "not_null", "user_email","E-Mail is empty.");
		$ip_array[] = array("msg", $ip['user_mob'], "not_null", "user_mob", "Mobile number is empty.");
		$ip_array[] = array("msg", $ip['full_name'], "not_null", "first_name", "First name is empty.");
		$ip_array[] = array("msg", $ip['c_msg'], "not_null", "c_msg", "Message is empty.");
		
		$validation_array = $this->validator->validate($ip_array);
		$ipJson = json_encode($ip);
                
		if ($validation_array !=1) 
		{
			$data['message'] = $validation_array['msg'];
			$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		} 
		else  
		{
            $retVals1 = $this->contact_us_model->contact_msg($ip, $serviceName);
        	
        	/*======================Mailing Part======================*/
	        $to_email = $ip['user_email']; 
	        $subject = 'Get My Truck Website.'; 
	        $message ='Thank you for contacting us, our executive will contact you soon.';
			$mailstatus = $this->email_sms->send_email_method($to_email,$subject,$message);
            /*=====================Ending Mailing Part====================*/ 

            /*======================Mailing Part======================*/
	        $from_email = $ip['user_email'];
	        // $to_email =  "support@getmytruck.in"; 
	        $to_email = "codeigniter1@indglobal-consulting.com"; 
	        $name = $ip['full_name'];
	        $user_msg = $ip['c_msg'];
	        // $this->email->from($from_email, $name); 
	        // $this->email->to($to_email);
	        // $this->email->subject('Message from Get My Truck contact us'); 
	        // $this->email->message($user_msg);
			// $to_email = "support@getmytruck.in"; 
			$subject = 'Message from Get My Truck contact us'; 
			$message = "Sender Name: ".$name."
Sender Email: ".$from_email."
Message: 
".$user_msg;
			$mailstatus = $this->email_sms->send_email_method($to_email,$subject,$message);
            /*=====================Ending Mailing Part====================*/

		    json_decode($retVals1);	
		}
        header("content-type: application/json");
        echo $retVals1;
        exit;
   	}
	
}
?>