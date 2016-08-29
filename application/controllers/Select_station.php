<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
  require('application/libraries/REST_Controller.php');  
  //error_reporting(0);

  /**
  * Sign up form controller
  */
  class Select_station extends REST_Controller
  {
    public function Select_station() {
      parent::__construct();

      $this->load->model('Select_station_model');
      $this->load->library('seekahoo_lib');
      $this->load->library('Validator.php');

    }
    
    public function select_station_post()
    {
      
      $serviceName = 'select_station';
      //getting posted values
      $ip['user_id']             = trim($this->input->post('user_id'));
      $ip['from_state']          = trim($this->input->post('from_state'));
      $ip['from_city']           = trim($this->input->post('from_city'));
      $ip['to_state']            = trim($this->input->post('to_state'));
      $ip['to_city']             = trim($this->input->post('to_city'));
      $ip['from_state2']         = trim($this->input->post('from_state2'));
      $ip['from_city2']          = trim($this->input->post('from_city2'));
      $ip['to_state2']           = trim($this->input->post('to_state2'));
      $ip['to_city2']            = trim($this->input->post('to_city2'));
      $ip['from_state3']         = trim($this->input->post('from_state3'));
      $ip['from_city3']          = trim($this->input->post('from_city3'));
      $ip['to_state3']           = trim($this->input->post('to_state3'));
      $ip['to_city3']            = trim($this->input->post('to_city3'));
      $ip['created_ip']          = $_SERVER['REMOTE_ADDR'];
      $ip['modified_ip']         = $_SERVER['REMOTE_ADDR'];

      $ipJson = json_encode($ip);
                
      
      //validation
      $validation_array = 1;
      $ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
                  
          $ip_array[] = array("from_city", $ip['from_city'], "not_null", "from_city", "From City is empty.");
          $ip_array[] = array("from_city2", $ip['from_city2'], "not_null", "from_city2", "From City2 is empty.");
          $ip_array[] = array("from_city3", $ip['from_city3'], "not_null", "from_city3", "From City3 is empty.");
          $ip_array[] = array("to_city", $ip['to_city'], "not_null", "to_city", "to City is empty.");
          $ip_array[] = array("to_city2", $ip['to_city2'], "not_null", "to_city2", "to City2 is empty.");
          $ip_array[] = array("to_city3", $ip['to_city3'], "not_null", "to_city3", "to City3 is empty.");
          $ip_array[] = array("from_state", $ip['from_state'], "not_null", "from_state", "From State is empty.");
          $ip_array[] = array("from_state2", $ip['from_state2'], "not_null", "from_state2", "From State2 is empty.");
          $ip_array[] = array("from_state3", $ip['from_state3'], "not_null", "from_state3", "From State3 is empty.");
          $ip_array[] = array("to_state", $ip['to_state'], "not_null", "to_state", "To State is empty.");

          $ip_array[] = array("to_state2", $ip['to_state2'], "not_null", "to_state2", "To State2 is empty.");

          $ip_array[] = array("to_state3", $ip['to_state3'], "not_null", "to_state3", "To State3 is empty.");
          
          
          

          $validation_array = $this->validator->validate($ip_array);
          
          

          if ($validation_array !=1) 
          {
           $data['message'] = $validation_array;
           $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
          } 
          else  {
            $retVals1 =$this->Select_station_model->select_station($ip, $serviceName);
            $data['Select_station'] = $retVals1;  
            //$retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
            $retVals1 =$this->Select_station_model->select_station_sec($ip, $serviceName);
            $data['Select_station_sec'] = $retVals1;                            
            //$retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
            $retVals1 =$this->Select_station_model->select_station_thi($ip, $serviceName);
            $data['Select_station_thi'] = $retVals1;  

            //$retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
                
                }

                  //echo $retVals1 = $this->signup_model->signup($ip, $serviceName);
                header("content-type: application/json");
                echo $retVals1;
                
                exit;
        }

  }
?>