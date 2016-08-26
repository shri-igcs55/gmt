<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class City_dropdown extends REST_Controller
	{
		public function City_dropdown() {
			parent::__construct();

			$this->load->model('City_dropdown_model');
			$this->load->library('seekahoo_lib');
			$this->load->library('Validator.php');

		}
		
		public function city_dropdown_post()
		{
			
			$serviceName = 'City_dropdown';
			//getting posted values
			$ip['state']             = trim($this->input->post('state'));
		

			$ipJson = json_encode($ip);
                
			
			//validation
			$validation_array = 1;
			$ip_array[] = array("state", $ip['state'], "not_null", "state", "state is empty.");

			
									
					

					$validation_array = $this->validator->validate($ip_array);
					
					

					if ($validation_array !=1) 
					{
					 $data['message'] = $validation_array;
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 
					else  {
						$retVals1 =$this->City_dropdown_model->city_dropdown($ip, $serviceName);

						$data['City_dropdown'] = $retVals1;	
                           //$retVals1 = $this->Enquiry_form_model->enquiry_form($ip, $serviceName);
                           $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
						   	
					      }

     		          //echo $retVals1 = $this->signup_model->signup($ip, $serviceName);
			          header("content-type: application/json");
			          echo $retVals1;
			          exit;
	     	}

	}
?>