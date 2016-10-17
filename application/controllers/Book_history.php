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
		
			$ip['order_status'] = ($ip['order_status']=='' ? 3 : $ip['order_status']);
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
                $data = $this->Book_history_model->book_history($ip, $serviceName);
                if($data){
					$data = $data;
					
					foreach($data as $order):						
						$FromCity[$order['order_id']][] = $order['from_city'];
						$ToCity[$order['order_id']][] = $order['to_city'];						
						$tmpOrder[$order['order_id']] = $order;
						$tmpOrder[$order['order_id']]['from_city'] = $FromCity[$order['order_id']];
						$tmpOrder[$order['order_id']]['to_city'] = $ToCity[$order['order_id']];
					endforeach;
					
					$data = $tmpOrder; 
					//echo '<pre>';
					//print_r($data);
					//exit;
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