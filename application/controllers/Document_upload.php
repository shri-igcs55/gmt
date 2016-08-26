<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class Document_upload extends REST_Controller
	{
		public function Document_upload() {
			parent::__construct();

			$this->load->model('Document_upload_model');
			$this->load->library('seekahoo_lib');
			$this->load->library('Validator.php');

		}
		
		public function document_upload_post()
		{
			$pathToUpload = 'assets/user_docs';
			
			$serviceName = 'document_upload';
			//getting posted values
			$ip['user_id']             = trim($this->input->post('user_id'));
			$ip['trans_doc_type']      = $this->input->post('trans_doc_type');
			$ip['created_ip']          = $_SERVER['REMOTE_ADDR'];
			$ip['modified_ip']          = $_SERVER['REMOTE_ADDR'];

			$filename      = $_FILES['trans_doc_pic_path']['name'];
			$ip['trans_doc_pic_path']  = $pathToUpload;;
            $this->load->library('upload');
            $config['allowed_types'] = 'gif|jpeg|jpg|png|pdf';
            $config['file_name'] = $filename;

			$ipJson = json_encode($ip);
                
			
			//validation
			$validation_array = 1;
			$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
									
					

					

					$validation_array = $this->validator->validate($ip_array);
					
					

					if ($validation_array !=1) 
					{
					 $data['message'] = $validation_array;
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 
					else  {
						$retVals1 =$this->Document_upload_model->document_upload($ip, $serviceName);

						$data['Document_upload'] = $retVals1;	
                           //$retVals1 = $this->Enquiry_form_model->enquiry_form($ip, $serviceName);
                           //$retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
						   	
					      }

     		          //echo $retVals1 = $this->signup_model->signup($ip, $serviceName);
			          header("content-type: application/json");
			          echo $retVals1;
			          exit;
	     	}

	}
?>