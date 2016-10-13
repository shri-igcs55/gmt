<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);
	class Document_upload extends REST_Controller
	{
		public function Document_upload() {
			parent::__construct();
			$this->load->model('Document_upload_model');
			$this->load->library('seekahoo_lib');
			$this->load->library('Validator.php');
		}
		/*public function document_upload_post()
		{
			$pathToUpload = 'assets/user_docs';
			$serviceName = 'document_upload';  
            $filename = $_FILES['trans_doc_pic_path']['name'];
            $this->load->library('Uploader.php');
            $flag = "profile";
            $ipp['user_id'] = trim($this->input->post('user_id'));
            $ipp['flag'] = $flag;
            if(!empty($_FILES['trans_doc_pic_path']['name'])){
		        $target_file = $this->uploader->upload_image($_FILES['trans_doc_pic_path'], $flag,$ipp);
		    }
		    $ip['trans_doc_pic_path']  = $target_file['profile_org_url'];		
			$ip['user_id']             = trim($this->input->post('user_id'));
			$ip['trans_doc_type']      = $this->input->post('trans_doc_type');
			$ip['created_ip']          = $_SERVER['REMOTE_ADDR'];
			$ip['modified_ip']         = $_SERVER['REMOTE_ADDR'];
			$ipJson = json_encode($ip);
			$validation_array = 1;
			$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
			$validation_array = $this->validator->validate($ip_array);
			if ($validation_array !=1) 
			{
		        $data['message'] = $validation_array;
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else  
			{
				$retVals1 =$this->Document_upload_model->document_upload($ip, $serviceName);
				$data['Document_upload'] = $retVals1;	
		    }
		    header("content-type: application/json");
		    echo $retVals1;
     	}*/


     	// upload document
		public function add_document_post() {
			$this->load->library('upload');
	      	$this->load->helper(array('url'));
			//ini_set('max_execution_time', 1000);
			$serviceName = 'add_document';
			$flag = "document";
			$ip['user_id'] = $this->input->post('user_id');
			$ip['doc_name'] = trim($this->input->post('doc_name'));
			// print_r($upic = $_FILES['user_doc']);
			// exit;
			
			$_FILES['user_doc']['name'] = preg_replace("/[\s_]/", "_",$_FILES['user_doc']['name']);
			$upic = $_FILES['user_doc'];
			// print_r($upic);
			// exit;
			$logged_in_user = $this->session->userdata('logged_in_user');	
			$ip['user_id']=($logged_in_user['user_id']!='' ? $logged_in_user['user_id']:$ip['user_id']);
			
			// $ip['flag'] = $flag;
			$ipJson = json_encode($ip);
			$validation_array = 1;
			$ip_array[] = array("msg",$ip['user_id'],"not_null","user_id","Wrong or Invalid user_id.");
			$ip_array[] = array("msg",$ip['doc_name'],"not_null","doc_name","Document name is empty.");
			$ipJson = json_encode($ip);
			
			$validation_array = $this->validator->validate($ip_array);
			if ($validation_array !=1) {
				$data['message'] = $validation_array['msg'];
				$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else {
				$this->load->library('uploader');
				/*foreach($_FILES as $key => $value) {
					//print_r($ip);
					$uploadPhoto[] = $this->uploader->upload_image($value, $flag, $ip);
				}*/
				$uploadPhoto[] = $this->uploader->upload_image($upic, $flag,$ip);
				//print_r($uploadPhoto);exit();
				
				if ($uploadPhoto[0] == 'failed') {
					$data['message'] = 'Upload Failed. Please try again';
					$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
				} else {
					// $ip['doc_detail'] = $uploadPhoto[0];
					$uploadDb = $this->Document_upload_model->document_upload($ip, $uploadPhoto, $serviceName);
					if (!$uploadDb) {
						$data['message'] = 'Failed to add Document to database';
						$status = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} else {
						$data['uploaded_data'] = $uploadDb;
						$data['message'] = 'Successfully Uploaded';
						$retVals = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
					}
				}
			}
			header("content-type: application/json");
			echo $retVals;
			exit;
		}

		// documents
     	public function document_post()
		{	
			$serviceName = 'user_uploaded_doc';
			$ip['user_id'] = $this->input->post('user_id');
			
			$logged_in_user = $this->session->userdata('logged_in_user');	
			$ip['user_id']=($logged_in_user['user_id']!='' ? $logged_in_user['user_id']:$ip['user_id']);
			
			$ipJson = json_encode($ip);
			$validation_array = 1;
			$ip_array[] = array("msg",$ip['user_id'],"not_null","user_id","Wrong or Invalid user_id.");

			$validation_array = $this->validator->validate($ip_array);
			if ($validation_array !=1) {
				$data['message'] = $validation_array['msg'];
				$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else {
				$data =$this->Document_upload_model->get_uploaded_document($ip);
		    	$data =$this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
			}
			header("content-type: application/json");
		    echo $data;
		    exit;
     	}
    }
?>