<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class Enquiry_form extends REST_Controller
	{
		public function Enquiry_form() {
			parent::__construct();

			$this->load->model('Enquiry_form_model');
			$this->load->library('seekahoo_lib');
			$this->load->library('Validator.php');

		}
		
		public function enquiry_form_post()
		{
			
			$serviceName = 'enquiry_form';
			//getting posted values
			$ip['user_id']             = trim($this->input->post('user_id'));
			$ip['trans_cat_id_fk']     = trim($this->input->post('trans_cat_id_fk'));
			$ip['from_state']          = trim($this->input->post('from_state'));
			$ip['from_city']           = trim($this->input->post('from_city'));
			$ip['from_location']       = trim($this->input->post('from_location'));
			$ip['to_state']            = trim($this->input->post('to_state'));
			$ip['to_city']             = trim($this->input->post('to_city'));
			$ip['to_location']         = trim($this->input->post('to_location'));
			$ip['material_type']       = trim($this->input->post('material_type'));
			$ip['no_of_quantity']      = trim($this->input->post('no_of_quantity'));
			$ip['weight']              = trim($this->input->post('weight'));
			$ip['feet']                = trim($this->input->post('feet'));
			$ip['vehicle_type']        = trim($this->input->post('vehicle_type'));
            $ip['no_of_vehicle']       = trim($this->input->post('no_of_vehicle'));
            $ip['pickup_points']       = trim($this->input->post('pickup_points'));
            $ip['destination_points']  = trim($this->input->post('destination_points'));
            $ip['sechdule_date']       = trim($this->input->post('sechdule_date'));
            $ip['created_ip']          = $_SERVER['REMOTE_ADDR'];
			$ip['modified_ip']         = $_SERVER['REMOTE_ADDR'];

			$ipJson = json_encode($ip);
                
			
			//validation
			$validation_array = 1;
			$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
									
					$ip_array[] = array("from_city", $ip['from_city'], "not_null", "from_city", "From City is empty.");

					$ip_array[] = array("to_city", $ip['to_city'], "not_null", "to_city", "To city is empty.");
					
					$ip_array[] = array("material_type", $ip['material_type'], "not_null", "material_type", "Material type is empty.");

					$validation_array = $this->validator->validate($ip_array);
					
					

					if ($validation_array !=1) 
					{
					 $data['message'] = $validation_array;
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 
					else  {
						$retVals1 =$this->Enquiry_form_model->enquiry_form($ip, $serviceName);

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