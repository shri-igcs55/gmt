<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');		
	//error_reporting(0);
	require_once(APPPATH.'controllers/View_profile.php'); //include controller
	class Quotation extends REST_Controller
	{
		public function Quotation() 
		{
			parent::__construct();
			$this->load->model('Quotation_model');
			$this->load->library('Email_sms');
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
			$order['odr_amt_basis'] = trim($this->input->post('odr_amt_basis'));
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
		
		public function confirmOrder_post(){
			            
			$serviceName = 'Order confirmed or cancled';
			$order['order_id'] = trim($this->input->post('order_id'));			
			$order['transpoter_id'] = trim($this->input->post('transpoter_id'));
			$order['order_status'] = trim($this->input->post('order_status'));
			$order['modified_ip'] = $_SERVER['REMOTE_ADDR'];			
			$order_status = $this->Quotation_model->confirmorder($order, $serviceName);			
			
			
			//Getting data of Transoter
			//$userTranspoter = $this->View_profile->view_profile_post($order['transpoter_id']);
			//$userTranspoter = $userTranspoter['data'];
			
			//Getting Data for Customer
			//$userCustomer = $this->View_profile->view_order_profile_post($order['order_id']);		
			//$userCustomer = $userCustomer['data'];
			
			$orderNo = 'Order no:'.$order['order_id'];
			if($order_status==7){
				$subject = $orderNo.' Order has been cancled';
				$data['message'] = 'Order has been cancled.'; 
				$messageBody = '<b>Your order no:'.$order['order_id'].' has been cancled</b>';
			}		
			if($order_status==9){
				$subject = $orderNo.' Order has been confirmed';
				$data['message'] = 'Order has been confirmed.'; 
				$messageBody = '<b>Your order no:'.$order['order_id'].' has been confirmed</b>';
			}
			//$messageHeader = 'Hello, '.$userTranspoter['first_name'];
			
			/*
			//Send SMS & Email to Transoter
			$smsstatus = $this->email_sms->send_sms_method($userTranspoter['mobile'], $messageHeader.$messageBody);
			$mailstatus = $this->email_sms->send_email_method($userTranspoter['email'],$subject,$messageHeader.$messageBody);
			
			$messageHeader = 'Hello, '.$userCustomer['first_name'];
			//Send SMS & Email to Customer
			$smsstatus = $this->email_sms->send_sms_method($userCustomer['mobile'], $messageHeader.$messageBody);
			$mailstatus = $this->email_sms->send_email_method($userCustomer['email'],$subject,$messageHeader.$messageBody);
			*/
			
			$this->Quotation_model->reOrder($order['order_id']);
			$status = $this->seekahoo_lib->return_status('success', $serviceName, $data, json_encode($order));				
			header("content-type: application/json");
			echo $status;
			exit;
		}
		
		public function deletetimeoutorder(){
			return $this->Quotation_model->deleteTimeOutOrder();
		}
		
		
		
	}
?>