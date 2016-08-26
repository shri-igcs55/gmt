<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class Quotation extends REST_Controller
	{
		public function Quotation() {
			parent::__construct();

			$this->load->model('Quotation_model');
			$this->load->library('seekahoo_lib');
			$this->load->library('Validator.php');

		}
		
		public function quotation_post()
		{
			
			$serviceName = 'Quotation';
			//getting posted values
			$ip['user_id']                    = trim($this->input->post('user_id'));
			$ip['plc_odr_id']                 = trim($this->input->post('plc_odr_id'));
			$ip['odr_qtn_amount']             = trim($this->input->post('odr_qtn_amount'));
			$ip['odr_qtn_delivered_datetime'] = trim($this->input->post('odr_qtn_delivered_datetime'));
			$ip['odr_amt_basis']              = trim($this->input->post('odr_amt_basis'));
			$ip['status_id_fk']               = trim($this->input->post('status_id_fk'));
			$ip['created_ip']                 = $_SERVER['REMOTE_ADDR'];
            $ip['modified_ip']                = $_SERVER['REMOTE_ADDR'];


			$ipJson = json_encode($ip);
                
			
			//validation
			$validation_array = 1;
			$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
									
					//$ip_array[] = array("from_city", $ip['from_city'], "not_null", "from_city", "From City is empty.");

					//$ip_array[] = array("to_city", $ip['to_city'], "not_null", "to_city", "To city is empty.");
					
					

					$validation_array = $this->validator->validate($ip_array);
					
					

					if ($validation_array !=1) 
					{
					 $data['message'] = $validation_array;
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 
					else  {
						$retVals1 =$this->Quotation_model->quotation($ip, $serviceName);

						$data['Quotation'] = $retVals1;	
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