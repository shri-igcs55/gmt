<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);
	/**
	* Sign up form controller
	*/
	class Current_order extends REST_Controller
	{
		public function Current_order() {
			parent::__construct();
			$this->load->model('Current_order_model');
			$this->load->library('seekahoo_lib');
			$this->load->library('Validator.php');
		}
		public function current_order_post()
		{
			$serviceName = 'current_order';
			//getting posted values
			$ip['user_id'] = trim($this->input->post('user_id'));
			$ipJson = json_encode($ip);
			$validation_array = 1;
			$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "Field is empty.");
			$validation_array = $this->validator->validate($ip_array);
        	if ($validation_array !=1) 
			{
			    $data['message'] = $validation_array;
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else
			{
                $data['Search_order'] =$this->Current_order_model->current_order($ip, $serviceName);
                $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
			}
		    header("content-type: application/json");
		    echo $retVals1;
		    exit;
	    }
	}
?>