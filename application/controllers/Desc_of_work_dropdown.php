<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);
	class Desc_of_work_dropdown extends REST_Controller
	{
		public function Desc_of_work_dropdown() {
			parent::__construct();
			$this->load->model('Desc_of_work_dropdown_model');
			$this->load->library('seekahoo_lib');
		}		
		public function desc_of_work_get()
		{	
			$serviceName = 'Desc_of_work';	
			$retVals1 =$this->Desc_of_work_dropdown_model->Desc_of_work_dropdown();
			$data['Desc_of_work'] = $retVals1;	
            $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, '');
			header("content-type: application/json");
			echo $retVals1;
		}
	}
?>