<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);
	class Vehicle_type_dropdown extends REST_Controller
	{
		public function Vehicle_type_dropdown() 
		{
			parent::__construct();
			$this->load->model('Vehicle_type_dropdown_model');
			$this->load->library('seekahoo_lib');
			//$this->load->library('Validator.php');
		}
		public function vehicle_type_get()
		{	
			$serviceName = 'Vehicle_type';
			$retVals1 =$this->Vehicle_type_dropdown_model->vehicle_type_dropdown();
			$data['Vehicle_type'] = $retVals1;	
            //$retVals1 = $this->Enquiry_form_model->enquiry_form($ip, $serviceName);
            $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, '');
            //echo $retVals1 = $this->signup_model->signup($ip, $serviceName);
            header("content-type: application/json");
	        echo $retVals1;
	        exit;
	   	}

	}
?>