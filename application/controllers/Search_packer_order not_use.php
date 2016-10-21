<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);
	class Search_packer_order extends REST_Controller
	{
		public function Search_packer_order() 
		{
			parent::__construct();
			$this->load->model('Search_packer_order_model');
			$this->load->library('seekahoo_lib');
			$this->load->library('Validator.php');
		}
		public function search_packer_order_post()
		{
			$serviceName = 'Search_packer_order';
			//getting posted values
			$ip['user_id']				= trim($this->input->post('user_id'));
			$ip['user_type']			= trim($this->input->post('user_type'));
			$ip['user_type_parent_id']	= trim($this->input->post('user_type_parent_id'));
			$logged_in_user = $this->session->userdata('logged_in_user');	
			
			$ip['user_id']=($logged_in_user['user_id']!='' ? $logged_in_user['user_id']:$ip['user_id']);
			$ip['user_type']=($logged_in_user['user_type']!='' ? $logged_in_user['user_type']:$ip['user_type']);

			$ip['from_city']    	= trim($this->input->post('from_city'));
			$ip['to_city']      	= trim($this->input->post('to_city'));
			$ip['sehdule_date'] 	= trim($this->input->post('schedule_date'));
			$ipJson = json_encode($ip);	
					    
			//validation
			$validation_array = 1;

			$ip_array[] = array("msg", $ip['user_id'], "not_null", "user_id", "User id is empty.");
			$ip_array[] = array("msg", $ip['user_type'], "not_null", "user_type", "User type is empty");
			$ip_array[] = array("msg", $ip['user_type_parent_id'], "not_null", "user_type_parent_id", "User parent type id is empty.");

			$validation_array = $this->validator->validate($ip_array);
			if ($validation_array !=1) 
			{
			    $data['message'] = $validation_array['msg'];
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else
			{
                $data =$this->Search_packer_order_model->search_packer_order($ip, $serviceName);
                if($data){
     
					foreach($data as $order):						
						$FromCity[$order['order_id']][] = $order['from_city'];
						$ToCity[$order['order_id']][] = $order['to_city'];
						$pickup_area_location[$order['order_id']][] = $order['pickup_area_location'];
						$drop_area_location[$order['order_id']][] = $order['drop_area_location'];
						$tmpOrder[$order['order_id']] = $order;
						$tmpOrder[$order['order_id']]['from_city'] = $FromCity[$order['order_id']];
						$tmpOrder[$order['order_id']]['to_city'] = $ToCity[$order['order_id']];
						$tmpOrder[$order['order_id']]['pickup_area_location'] = $pickup_area_location[$order['order_id']];
						$tmpOrder[$order['order_id']]['drop_area_location'] = $drop_area_location[$order['order_id']];
					endforeach;
					
					$data = $tmpOrder;
                }else{
                	$data['message'] = "No Order Found.";
                }
                $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
			}
            header("content-type: application/json");
	        echo $retVals1;
	        exit;
	    }
	}
?>