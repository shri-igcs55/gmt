<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);
	class Material_type_dropdown extends REST_Controller
	{
		public function Material_type_dropdown() 
		{
			parent::__construct();
			$this->load->model('Material_type_dropdown_model');
			$this->load->library('seekahoo_lib');
			//$this->load->library('Validator.php');
		}		
		public function material_type_get()
		{			
			$serviceName = 'Material_type';			
			$retVals1 =$this->Material_type_dropdown_model->material_type_dropdown();
			$data['Material_type'] = $retVals1;	
            $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, '');			   						
		    header("content-type: application/json");
		    echo $retVals1;
		    exit;
	    }
	}
?>