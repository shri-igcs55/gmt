<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);
	class View_profile extends REST_Controller
	{
		public function View_profile() {
			parent::__construct();
			$this->load->model('View_profile_model');
			$this->load->library('seekahoo_lib');
			$this->load->library('Validator.php');
		}
		
		public function view_profile_post()
		{
			$serviceName = 'view_profile';
			//getting posted values
			$ip['user_id']             = trim($this->input->post('user_id'));
			$logged_in_user = $this->session->userdata('logged_in_user');	
			
			$ip['user_id'] = ($logged_in_user['user_id']!='' ? $logged_in_user['user_id']:$ip['user_id']);
			$ipJson = json_encode($ip);
			//validation
			$validation_array = 1;									
			$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "User id field is empty.");
			$validation_array = $this->validator->validate($ip_array);
			if ($validation_array !=1) 
			{
			    $data['message'] = $validation_array['user_id'];
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else
			{
                $data = $this->View_profile_model->view_profile($ip, $serviceName);
                $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
			}
            header("content-type: application/json");
            echo $retVals1;
            exit;
	    }

	    public function view_order_profile_post()
		{
			$serviceName = 'view_order_profile';
			//getting posted values
			$ip['order_id']             = trim($this->input->post('order_id'));
			$logged_in_user = $this->session->userdata('logged_in_user');	
			
			$ip['order_id'] = ($logged_in_user['order_id']!='' ? $logged_in_user['order_id']:$ip['order_id']);
			$ipJson = json_encode($ip);
			//validation
			$validation_array = 1;									
			$ip_array[] = array("order_id", $ip['order_id'], "not_null", "order_id", "Order id field is empty.");
			$validation_array = $this->validator->validate($ip_array);
			if ($validation_array !=1) 
			{
			    $data['message'] = $validation_array['order_id'];
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else
			{
                $data = $this->View_profile_model->view_order_profile($ip, $serviceName);
                $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
			}
            header("content-type: application/json");
            echo $retVals1;
            exit;
	    }
	}
?>