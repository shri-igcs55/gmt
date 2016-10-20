<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);
	class Search_order extends REST_Controller
	{
		public function Search_order() 
		{
			parent::__construct();
			$this->load->model('Search_order_model');
			$this->load->library('seekahoo_lib');
			$this->load->library('Validator.php');
		}
		public function search_order_post()
		{
			$serviceName = 'Search_order';
			//getting posted values
			$ip['user_id']		= trim($this->input->post('user_id'));
			$ip['user_type']	= trim($this->input->post('user_type'));
			$logged_in_user = $this->session->userdata('logged_in_user');	
			
			$ip['user_id']=($logged_in_user['user_id']!='' ? $logged_in_user['user_id']:$ip['user_id']);
			$ip['user_type']=($logged_in_user['user_type']!='' ? $logged_in_user['user_type']:$ip['user_type']);

			$ip['from_city']    = trim($this->input->post('from_city'));
			$ip['to_city']      = trim($this->input->post('to_city'));
			$ip['vehicle_type'] = trim($this->input->post('vehicle_type'));
			$ip['weight']       = trim($this->input->post('weight'));
			$ip['sehdule_date'] = trim($this->input->post('sehdule_date'));
			$ipJson = json_encode($ip);	
					    
			//validation
			$validation_array = 1;
			$ip_array[] = array("msg", $ip['user_id'], "not_null", "user_id", "User id is empty.");
			$ip_array[] = array("msg", $ip['user_type'], "not_null", "user_type", "User type is empty");
			$validation_array = $this->validator->validate($ip_array);
			if ($validation_array !=1) 
			{
			    $data['message'] = $validation_array['msg'];
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else
			{
                $data['Search_order'] =$this->Search_order_model->Search_order($ip, $serviceName);
                $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
			}
            header("content-type: application/json");
	        echo $retVals1;
	        exit;
	    }
	}
?>