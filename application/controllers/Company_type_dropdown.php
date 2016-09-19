<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);
	/**
	* Sign up form controller
	*/
	class Company_type_dropdown extends REST_Controller
	{
		public function Company_type_dropdown() {
			parent::__construct();
			$this->load->model('Company_type_dropdown_model');
			$this->load->library('seekahoo_lib');
		}
		public function company_type_get()
		{	
			$serviceName = 'Company_type';	
						$retVals1 =$this->Company_type_dropdown_model->company_type_dropdown();
						$data['Company_type'] = $retVals1;	
                          $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, '');
			          header("content-type: application/json");
			          echo $retVals1;
			          exit;
	     	}
	}
?>