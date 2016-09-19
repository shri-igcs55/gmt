<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);
	class Service_dropdown extends REST_Controller
	{
		public function Service_dropdown() 
		{
			parent::__construct();

			$this->load->model('Service_dropdown_model');
			$this->load->library('seekahoo_lib');
		}		
		public function service_get()
		{			
			$serviceName = 'Service_for';
			$retVals1 =$this->Service_dropdown_model->Service_dropdown();
			$data['Service'] = $retVals1;	
            $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, '');
			header("content-type: application/json");
			echo $retVals1;
			exit;
	    }

	}
?>