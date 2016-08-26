<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
  require('application/libraries/REST_Controller.php');  
  //error_reporting(0);

  /**
  * Sign up form controller
  */
  class Save_contact extends REST_Controller
  {
    public function Save_contact() {
      parent::__construct();

      $this->load->model('Save_contact_model');
      $this->load->library('seekahoo_lib');
      $this->load->library('Validator.php');

    }
    
    public function save_contact_post()
    {
      
      $serviceName = 'save_contact';
      //getting posted values
      $ip['user_id']             = trim($this->input->post('user_id'));
      $ip['reg_id_fk']           = trim($this->input->post('reg_id_fk'));
      $ip['cont_group_name']     = trim($this->input->post('cont_group_name'));
      $ip['created_ip']          = $_SERVER['REMOTE_ADDR'];
      $ip['modified_ip']         = $_SERVER['REMOTE_ADDR'];

      $ipJson = json_encode($ip);
                
      
      //validation
      $validation_array = 1;
      $ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
                  
          //$ip_array[] = array("from_city", $ip['from_city'], "not_null", "from_city", "From City is empty.");

          
          
          

          $validation_array = $this->validator->validate($ip_array);
          
          

          if ($validation_array !=1) 
          {
           $data['message'] = $validation_array;
           $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
          } 
          else  {
            $retVals1 =$this->Save_contact_model->save_contact($ip, $serviceName);

            $data['Save_contact'] = $ip;  
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