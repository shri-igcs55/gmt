<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);
	/**
	* Sign up form controller
	*/
	class Book_history extends REST_Controller
	{
		public function Book_history() {
			parent::__construct();
			$this->load->model('Book_history_model');
			$this->load->library('seekahoo_lib');
			$this->load->library('Validator.php');
		}
		public function book_history_post()
		{
			$serviceName = 'Book_history';
			//getting posted values
			$ip['user_id']          = trim($this->input->post('user_id'));
			$ip['order_status']		= trim($this->input->post('order_status'));
			$logged_in_user = $this->session->userdata('logged_in_user');	
			
			$ip['user_id'] = ($logged_in_user['user_id']!='' ? $logged_in_user['user_id']:$ip['user_id']);
			$ipJson = json_encode($ip);
			//validation
			$validation_array = 1;
			$ip_array[] = array("msg", $ip['user_id'], "not_null", "user_id", "usser id is empty.");
			$ip_array[] = array("msg", $ip['order_status'], "not_null", "order_status", "order status is empty.");
			$validation_array = $this->validator->validate($ip_array);
        	if ($validation_array !=1) 
			{
				$data['message'] = $validation_array['msg'];
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else
			{
                $data =$this->Book_history_model->book_history($ip, $serviceName);
                if($data){
                	$data = $data;
                }else{
                	$data['msg'] = "No Data.";
                }
                $retVals1 =$this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
			}
		    header("content-type: application/json");
		    echo $retVals1;
		    exit;
	    }
	}
?>