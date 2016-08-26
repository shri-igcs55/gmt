<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class State_dropdown extends REST_Controller
	{
		public function State_dropdown() {
			parent::__construct();

			$this->load->model('State_dropdown_model');
			$this->load->library('seekahoo_lib');
			//$this->load->library('Validator.php');

		}
		
		public function state_get()
		{
			
			$serviceName = 'State';
			
						$retVals1 =$this->State_dropdown_model->State_dropdown();

						$data['State'] = $retVals1;	
                           //$retVals1 = $this->Enquiry_form_model->enquiry_form($ip, $serviceName);
                          $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, '');
						   	
					

     		          //echo $retVals1 = $this->signup_model->signup($ip, $serviceName);
			          header("content-type: application/json");
			          echo $retVals1;
			          exit;
	     	}

	}
?>