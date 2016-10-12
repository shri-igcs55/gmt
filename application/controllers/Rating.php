<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);
	class Rating extends REST_Controller
	{
		public function Rating() 
		{
			parent::__construct();
			$this->load->model('Rating_model');
			$this->load->library('seekahoo_lib');
			$this->load->library('Validator.php');
		}
		public function rating_post()
		{
			$serviceName = 'rating';
			//getting posted values
			$ip['user_id']             = trim($this->input->post('user_id'));
			$logged_in_user = $this->session->userdata('logged_in_user');	
			
			$ip['user_id'] = ($logged_in_user['user_id']!='' ? $logged_in_user['user_id']:$ip['user_id']);
			$ip['to_user_id']          = trim($this->input->post('to_user_id'));
			$ip['subject']             = trim($this->input->post('subject'));
			$ip['feadback']            = trim($this->input->post('feadback'));
            $ip['created_ip']          = $_SERVER['REMOTE_ADDR'];
			$ip['modified_ip']         = $_SERVER['REMOTE_ADDR'];
			$ipJson = json_encode($ip);
            //validation
			$validation_array = 1;
			$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
			$ip_array[] = array("feadback", $ip['feadback'], "not_null", "feadback", "feadback is empty.");					
			$validation_array = $this->validator->validate($ip_array);
			if ($validation_array !=1) 
			{
			    $data['message'] = $validation_array;
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else  
			{
				$retVals1 =$this->Rating_model->rating($ip, $serviceName);
				$data['Rating'] = $retVals1;	
            }
            header("content-type: application/json");
            echo $retVals1;
            exit;
     	}

	}
?>