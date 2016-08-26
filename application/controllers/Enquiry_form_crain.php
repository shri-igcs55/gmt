<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
  require('application/libraries/REST_Controller.php');  
  //error_reporting(0);

  /**
  * Sign up form controller
  */
  class Enquiry_form_crain extends REST_Controller
  {
    public function Enquiry_form_crain() {
      parent::__construct();

      $this->load->model('Enquiry_form_crain_model');
      $this->load->library('seekahoo_lib');
      $this->load->library('Validator.php');

    }
    
    public function enquiry_form_crain_post()
    {
      
      $serviceName = 'enquiry_form_crain';
      //getting posted values
      $ip['user_id']             = trim($this->input->post('user_id'));
      $ip['user_type_id']        = trim($this->input->post('user_type_id'));
      $ip['name']                = trim($this->input->post('name'));
      $ip['contact']             = trim($this->input->post('contact'));
      $ip['state']               = trim($this->input->post('state'));
      $ip['city']                = trim($this->input->post('city'));
      $ip['location']            = trim($this->input->post('location'));
      $ip['address']             = trim($this->input->post('address'));
      $ip['weight']              = trim($this->input->post('weight'));      
      $ip['desc_of_goods']       = trim($this->input->post('desc_of_goods'));
      $ip['sechdule_date']       = trim($this->input->post('sechdule_date'));
      $ip['created_ip']          = $_SERVER['REMOTE_ADDR'];
      $ip['modified_ip']         = $_SERVER['REMOTE_ADDR'];

      $ipJson = json_encode($ip);
                
      
      //validation
      $validation_array = 1;
      $ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
                  
          $ip_array[] = array("from_city", $ip['from_city'], "not_null", "from_city", "From City is empty.");

          
          
          

          $validation_array = $this->validator->validate($ip_array);
          
          

          if ($validation_array !=1) 
          {
           $data['message'] = $validation_array;
           $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
          } 
          else  {
            $retVals1 =$this->Enquiry_form_crain_model->enquiry_form_crain($ip, $serviceName);

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