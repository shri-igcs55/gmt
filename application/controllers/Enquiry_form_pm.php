<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class Enquiry_form_pm extends REST_Controller
	{
		public function Enquiry_form_pm() {
			parent::__construct();

			$this->load->model('Enquiry_form_pm_model');
			$this->load->library('seekahoo_lib');
			$this->load->library('Validator.php');

		}
		
		public function enquiry_form_pm_post()
		{
			
			$serviceName = 'enquiry_form_pm';
			//getting posted values
			$ip['user_id']               = trim($this->input->post('user_id'));
			$ip['user_type_id']          = trim($this->input->post('user_type_id'));
			$ip['from_state']            = trim($this->input->post('from_state'));
			$ip['from_city']             = trim($this->input->post('from_city'));
			$ip['from_location']         = trim($this->input->post('from_location'));
			$ip['to_state']              = trim($this->input->post('to_state'));
			$ip['to_city']               = trim($this->input->post('to_city'));
			$ip['to_location']           = trim($this->input->post('to_location'));
			$ip['detailed_from_address'] = trim($this->input->post('detailed_from_address'));
			$ip['shift_floor_from']      = trim($this->input->post('shift_floor_from'));
			$ip['from_lift_facility']    = trim($this->input->post('from_lift_facility'));
			$ip['detailed_to_address']   = trim($this->input->post('detailed_to_address'));
			$ip['shift_floor_to']        = trim($this->input->post('shift_floor_to'));
			$ip['to_lift_facility']      = trim($this->input->post('to_lift_facility'));
			$ip['service_for']           = trim($this->input->post('service_for'));			
			$ip['desc_of_goods']         = trim($this->input->post('desc_of_goods'));
            $ip['sechdule_date']         = trim($this->input->post('sechdule_date'));
            $ip['created_ip']            = $_SERVER['REMOTE_ADDR'];
            $ip['modified_ip']           = $_SERVER['REMOTE_ADDR'];

			$ipJson = json_encode($ip);
                
			
			//validation
			$validation_array = 1;
			$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
									
			$ip_array[] = array("from_city", $ip['from_city'], "not_null", "from_city", "From City is empty.");

			$ip_array[] = array("to_city", $ip['to_city'], "not_null", "to_city", "To city is empty.");

			$ip_array[] = array("from_state", $ip['from_state'], "not_null", "from_state", "From State is empty.");

			$ip_array[] = array("to_state", $ip['to_state'], "not_null", "to_state", "To State is empty.");
					
					

					$validation_array = $this->validator->validate($ip_array);
					
					

					if ($validation_array !=1) 
					{
					 $data['message'] = $validation_array;
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 
					else  {
						$retVals1 =$this->Enquiry_form_pm_model->enquiry_form_pm($ip, $serviceName);

						$data['Enquiry_form'] = $retVals1;	
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