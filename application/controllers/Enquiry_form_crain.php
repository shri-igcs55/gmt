<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  require('application/libraries/REST_Controller.php');  
  //error_reporting(0);
  class Enquiry_form_crain extends REST_Controller
  {
    public function Enquiry_form_crain() 
    {
      parent::__construct();
      $this->load->model('Enquiry_form_crain_model');
      $this->load->library('seekahoo_lib');
      $this->load->library('Validator.php');
    }
  
    public function enquiry_form_crain_post()
    {
      $serviceName = 'enquiry_form_crain';
      //getting posted values
      $ip['user_id']          = trim($this->input->post('user_id'));
      $logged_in_user = $this->session->userdata('logged_in_user'); 
      
      $ip['user_id'] = ($logged_in_user['user_id']!='' ? $logged_in_user['user_id']:$ip['user_id']);
      $ip['user_type_id']     = trim($this->input->post('user_type_id'));
      $ip['odr_by_fname']     = trim($this->input->post('odr_by_fname'));
      $ip['odr_by_lname']     = trim($this->input->post('odr_by_lname'));
      $ip['contact']          = trim($this->input->post('odr_by_mob'));

      $ip['from_state']       = trim($this->input->post('from_state'));
      $ip['from_city']        = trim($this->input->post('from_city'));
      $ip['from_location']    = trim($this->input->post('from_location'));
      $ip['from_address']     = trim($this->input->post('from_address'));

      $ip['to_state']         = trim($this->input->post('to_state'));
      $ip['to_city']          = trim($this->input->post('to_city'));
      $ip['to_location']      = trim($this->input->post('to_location'));
      $ip['to_address']       = trim($this->input->post('to_address'));

      $ip['weight']           = trim($this->input->post('weight'));
      $ip['desc_of_goods']    = trim($this->input->post('desc_of_work'));
      $ip['sechdule_date']    = trim($this->input->post('sechdule_date'));
      $ip['created_ip'] = $ip['modified_ip'] = $_SERVER['REMOTE_ADDR'];
      //$ip['modified_ip']         = $_SERVER['REMOTE_ADDR'];
      $ipJson = json_encode($ip);      
      //validation
      $validation_array = 1;

      $ip_array[] = array("msg", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
      $ip_array[] = array("msg", $ip['odr_by_fname'], "not_null", "odr_by_fname","First name is empty");
      $ip_array[] = array("msg", $ip['odr_by_lname'], "not_null", "odr_by_lname", "Last Name is empty");
      $ip_array[] = array("msg", $ip['contact'], "not_null", "contact", "Mobile No. is empty");
      $ip_array[] = array("msg", $ip['weight'], "not_null", "weight", "Weight is empty");
      $ip_array[] = array("msg", $ip['sechdule_date'], "not_null", "sechdule_date", "Schedule date is empty");

      $ip_array[] = array("msg", $ip['from_city'], "not_null", "from_city", "City is empty.");
      $ip_array[] = array("msg", $ip['from_state'], "not_null", "from_state", "State is empty.");
      $ip_array[] = array("msg", $ip['from_location'], "not_null", "from_location", "City Location is empty");
      $ip_array[] = array("msg", $ip['from_address'], "not_null", "from_address", "Address is empty.");

      $ip_array[] = array("msg", $ip['to_city'], "not_null", "to_city", "City is empty.");
      $ip_array[] = array("msg", $ip['to_state'], "not_null", "to_state", "State is empty.");
      $ip_array[] = array("msg", $ip['to_location'],"not_null", "to_location","City Location is empty");
      $ip_array[] = array("msg", $ip['to_address'], "not_null", "to_address", "Address is empty.");

      $ip_array[] = array("msg", $ip['desc_of_goods'], "not_null", "desc_of_goods", "Desc_of_goods is empty.");

      $validation_array = $this->validator->validate($ip_array);
      if ($validation_array !=1) 
      {
        $data['message'] = $validation_array['msg'];
        $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
      } 
      else  
      {
        $retVals1 =$this->Enquiry_form_crain_model->enquiry_form_crain($ip, $serviceName);
        $data['Enquiry_form'] = $retVals1;  
      }
      header("content-type: application/json");
      echo $retVals1;
      exit;
    }

  }
?>