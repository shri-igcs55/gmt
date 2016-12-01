<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);
	class Quotation extends REST_Controller
	{
		public function Quotation() 
		{
			parent::__construct();
			$this->load->model('Quotation_model');
			$this->load->library('seekahoo_lib');
			$this->load->library('Validator.php');
		}		
		public function quotation_post()
		{			
			$serviceName = 'Quotation';
			//getting posted values
			$ip['user_id']             = trim($this->input->post('user_id'));
			$logged_in_user = $this->session->userdata('logged_in_user');	
			
			$ip['user_id'] = ($logged_in_user['user_id']!='' ? $logged_in_user['user_id']:$ip['user_id']);
			$ip['plc_odr_id']                 = trim($this->input->post('plc_odr_id'));
			$ip['odr_qtn_amount']             = trim($this->input->post('odr_qtn_amount'));
			$ip['odr_qtn_delivered_datetime'] = trim($this->input->post('odr_qtn_delivered_datetime'));
			$ip['odr_amt_basis']              = trim($this->input->post('odr_amt_basis'));
			$ip['status_id_fk']               = trim($this->input->post('status_id_fk'));
			$ip['created_ip']                 = $_SERVER['REMOTE_ADDR'];
            $ip['modified_ip']                = $_SERVER['REMOTE_ADDR'];
			$ipJson = json_encode($ip);			
			//validation
			$validation_array = 1;
			$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
			$validation_array = $this->validator->validate($ip_array);
		    if ($validation_array !=1) 
			{
			    $data['message'] = $validation_array;
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else  
			{
				$retVals1 =$this->Quotation_model->quotation($ip, $serviceName);
				$data['Quotation'] = $retVals1;	
            }
	        header("content-type: application/json");
	        echo $retVals1;
	        exit;
	   	}
		
		public function rateToOrder_post(){			
			$serviceName = 'Rate to Order by the customer';
			$logged_in_user = $this->session->userdata('logged_in_user');
			$order['user_id'] = $logged_in_user['user_id'];
			$order['order_id'] = trim($this->input->post('order_id'));			
			$order['quoted_rate'] = trim($this->input->post('quoted_rate'));
			$order['created_ip']                 = $_SERVER['REMOTE_ADDR'];
            $order['modified_ip']                = $_SERVER['REMOTE_ADDR'];
			//echo 'test';exit;
			$validation_array = 1;
			$ip_array[] = array("user_id", $order['user_id'], "not_null", "user_id", "user_id is empty.");
			$validation_array = $this->validator->validate($ip_array);
		    if ($validation_array !=1) 
			{
				$order = json_encode($order);
			    $data['message'] = $validation_array;
				$order = $this->seekahoo_lib->return_status('error', $serviceName, $data, $order);
			} 
			else  
			{
				$order = $this->Quotation_model->rate_to_order($order, $serviceName);
			}			
	        header("content-type: application/json");
	        echo $order;
	        exit;
		}
		
		
		public function acceptOrder_post(){	
			$serviceName = 'Accept order by customer';
			$order['order_id'] = trim($this->input->post('order_id'));			
			$order['transpoter_id'] = trim($this->input->post('transpoter_id'));			
            $order['modified_ip'] = $_SERVER['REMOTE_ADDR'];
			
			$order = $this->Quotation_model->acceptorder($order, $serviceName);
						
	        header("content-type: application/json");
	        echo $order;
	        exit;
		}
		
		
		
	}
?>