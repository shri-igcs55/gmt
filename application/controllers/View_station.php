<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);
	class View_station extends REST_Controller
	{
		public function View_station() 
		{
			parent::__construct();
			$this->load->model('View_station_model');
			$this->load->library('seekahoo_lib');
			$this->load->library('Validator.php');
		}
		public function view_station_post()
		{
			$serviceName = 'view_station';
			//getting posted values
			$ip['user_id']             = trim($this->input->post('user_id'));
			$logged_in_user = $this->session->userdata('logged_in_user');	
			
			$ip['user_id'] = ($logged_in_user['user_id']!='' ? $logged_in_user['user_id']:$ip['user_id']);
			$ipJson = json_encode($ip);
			//validation
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
                $data['View_station'] =$this->View_station_model->view_station($ip, $serviceName);
                $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
			}
            header("content-type: application/json");
            echo $retVals1;
            exit;
	    }

	}
?>