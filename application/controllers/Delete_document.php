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
		        $data['message'] = $validation_array;
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else
			{
				$data['Delete'] ='Deleted Successfully';
                $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
			}
		    header("content-type: application/json");
		    echo $retVals1;
		    exit;
	    }
	}
?>