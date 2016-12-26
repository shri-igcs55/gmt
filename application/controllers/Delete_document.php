<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);
	class Delete_document extends REST_Controller
	{
		public function Delete_document() {
			parent::__construct();
			
			$this->load->model('Delete_document_model');
			$this->load->library('seekahoo_lib');
			$this->load->library('Validator.php');
			
			date_default_timezone_set('Asia/Kolkata');
		}
		
		public function delete_document_post()
		{
			$serviceName = 'Delete_document';
			$ip['trans_doc_id'] = trim($this->input->post('trans_doc_id'));
			$ipJson = json_encode($ip);
			$validation_array = 1;
			$ip_array[] = array("trans_doc_id", $ip['trans_doc_id'], "not_null", "trans_doc_id", "Field is empty.");
			$validation_array = $this->validator->validate($ip_array);
        	if ($validation_array !=1) 
			{
		        $data['message'] = $validation_array['trans_doc_id'];
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else
			{
				if ($this->Delete_document_model->delete_document($ip)) {
					$data['message'] ='Document Deleted Successfully';
	                $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
	            }else{
	            	$data['message'] ='Something went wrong while storing Document.';
	                $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
	            }
			}
		    header("content-type: application/json");
		    echo $retVals1;
		    exit;
	    }

	    public function delete_order_post(){
	    	$serviceName = 'Delete_Order';
	    	
	    	$ip['order_id'] = trim($this->input->post('order_id'));
	    	
	    	$ip['user_id'] = trim($this->input->post('user_id'));
	    	$logged_in_user = $this->session->userdata('logged_in_user');	
			
			$ip['user_id'] 	= ($logged_in_user['user_id']!='' ? $logged_in_user['user_id']:$ip['user_id']);
	    	
            $ip['modified_datetime']= Date('Y-m-d H:i:s');
            $ip['modified_ip']      = $_SERVER['REMOTE_ADDR'];

	    	$ipJson =  json_encode($ip);

	    	$validation_array = 1;
	    	$ip_array[] = array('msg',$ip['order_id'],'not_null','order_id', 'Order id is empty.');
	    	$ip_array[] = array('msg',$ip['user_id'],'not_null', 'user_id', 'User id is empty.');

	    	$validation_array = $this->validator->validate($ip_array);
	    	if ($validation_array != 1) {
	    		$data['message'] = $validation_array['msg'];
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
	    	} else {
	    		if($this->Delete_document_model->delete_order($ip)){
		    		$data['message'] ='Order Deleted Successfully';
	                $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
	            }else{
	            	$data['message'] ='Order not deleted';
	                $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
	            }
	    	}
	    	header("content-type: application/json");
		    echo $retVals1;
		    exit;
	    }
	}
?>