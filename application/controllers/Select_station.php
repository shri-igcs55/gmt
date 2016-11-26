<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  require('application/libraries/REST_Controller.php');  
  //error_reporting(0);
  class Select_station extends REST_Controller
  {
    public function Select_station() 
    {
        parent::__construct();
        $this->load->model('Select_station_model');
        $this->load->library('seekahoo_lib');
        $this->load->library('Validator.php');
    }
    public function select_station_post()
    {
		
        $serviceName = 'select_station';
        //getting posted values
        $ip['user_id'] = trim($this->input->post('user_id'));
        $ip['to_city'] = $this->input->post('to_city');
        $ip['from_city'] = $this->input->post('from_city');
        $logged_in_user = $this->session->userdata('logged_in_user');   
        
        $ip['user_id'] = ($logged_in_user['user_id']!='' ? $logged_in_user['user_id']:$ip['user_id']);

        $ip['created_ip']   = $_SERVER['REMOTE_ADDR'];
        $ip['modified_ip']  = $_SERVER['REMOTE_ADDR'];
        $ipJson = json_encode($ip);
        //validation
        $validation_array = 1;
        $ip_array[] = array("msg", $ip['user_id'], "not_null", "user_id", "User id is empty.");
        $ip_array[] = array("msg", $ip['to_city'], "not_null", "to_city", "To city is empty.");
        $ip_array[] = array("msg", $ip['from_city'], "not_null","from_city","From city is empty.");
        // print_r($ip);exit();

        $validation_array = $this->validator->validate($ip_array);
        if ($validation_array !=1) 
        {
            $data['message'] = $validation_array['msg'];
            $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
        } 
        else  
        {
            $retVals1 = $this->Select_station_model->select_station($ip, $serviceName);   
        }
        header("content-type: application/json");
        echo $retVals1;
        exit;
    }

  }
?>