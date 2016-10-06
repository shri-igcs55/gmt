<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);
	/**
	* Sign up form controller
	*/
	class indian_city_dropdown extends REST_Controller
	{
		public function indian_city_dropdown() 
		{
			parent::__construct();
			$this->load->model('City_dropdown_model');
			$this->load->library('seekahoo_lib');
			$this->load->library('Validator.php');
		}

		public function state_dropdown_get()
		{	
			$serviceName = 'state_dropdown';
			$ip = '';
			$ipJson = json_encode($ip);			
			$data =$this->City_dropdown_model->state_dropdown();
		    $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
			header("content-type: application/json");
		    echo $retVals1;
		    exit;
     	}

     	public function city_district_list_post()
		{	
			$serviceName = 'city_district_state_list';
			$ip['state'] = trim($this->input->post('state'));
			$ipJson = json_encode($ip);			
			$validation_array = 1;
			$ip_array[] = array("state", $ip['state'], "not_null", "state", "Please select State first.");					
			$validation_array = $this->validator->validate($ip_array);
			if ($validation_array !=1) 
			{
			    $data['message'] = $validation_array['state'];
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else  
			{	
				$data =$this->City_dropdown_model->city_district($ip);
		    	$retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data,$ipJson);
		    }
			header("content-type: application/json");
		    echo $retVals1;
		    exit;
     	}

		public function district_dropdown_post()
		{	
			$serviceName = 'District_dropdown';
			//getting posted values
			$ip['state'] = trim($this->input->post('state'));
			$ipJson = json_encode($ip);			
			$validation_array = 1;
			$ip_array[] = array("state", $ip['state'], "not_null", "state", "Please select State first.");					
			$validation_array = $this->validator->validate($ip_array);
			if ($validation_array !=1) 
			{
			    $data['message'] = $validation_array['state'];
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else  
			{
			    $data =$this->City_dropdown_model->district_dropdown($ip, $serviceName);
				$retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
			}
		    header("content-type: application/json");
		    echo $retVals1;
		    exit;
     	}

		public function city_dropdown_post()
		{	
			$serviceName = 'City_dropdown';
			//getting posted values
			$ip['district'] = trim($this->input->post('district'));
			$ip['state'] = trim($this->input->post('state'));
			$ipJson = json_encode($ip);			
			$validation_array = 1;
			$ip_array[] = array("district", $ip['district'], "not_null", "district", "Please select District first.");
			$ip_array[] = array("state", $ip['state'], "not_null", "state", "Please select State first.");					
			$validation_array = $this->validator->validate($ip_array);
			if ($validation_array !=1) 
			{
			    $data['message'] = $validation_array['district'];
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else  
			{
			    $data =$this->City_dropdown_model->city_dropdown($ip, $serviceName);
				$retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
			}
		    header("content-type: application/json");
		    echo $retVals1;
		    exit;
     	}
	}
?>