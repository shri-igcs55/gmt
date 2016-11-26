<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    require('application/libraries/REST_Controller.php');  
    //error_reporting(0);
    class Save_contact extends REST_Controller
    {
        public function Save_contact() 
        {
            parent::__construct();
            $this->load->model('Give_quotation_model');
            $this->load->library('seekahoo_lib');
            $this->load->library('Validator.php');            
            date_default_timezone_set('Asia/Kolkata');
        }
    
        public function index_post()
        {     
            $serviceName = 'give_quotation';
            //getting posted values
            $ip['user_id']  = trim($this->input->post('user_id'));
            $logged_in_user = $this->session->userdata('logged_in_user');   
            $ip['user_id'] = ($logged_in_user['user_id']!='' ? $logged_in_user['user_id']:$ip['user_id']);
            
            $ip['user_type'] = trim($this->input->post('user_type'));
            $ip['user_type'] = ($logged_in_user['user_type']!='' ? $logged_in_user['user_type']:$ip['user_type']);

            $ip['order_id'] = trim($this->input->post('order_id'));
            $ip['quot_type'] = trim($this->input->post('quot_type'));
            $ip['quot_amt'] = trim($this->input->post('quot_amt'));


            $ip['created_ip']   = $_SERVER['REMOTE_ADDR'];
            $ip['created_datetime']  = Date('Y-m-d h:i:s');

            $ipJson = json_encode($ip);
            //validation
            $validation_array = 1;
            $ip_array[] = array("msg", $ip['user_id'], "not_null", "user_id", "user_id is empty.");
            $ip_array[] = array("msg", $ip['user_type'], "not_null", "user_type", "user_type is empty.");
            $ip_array[] = array("msg",$ip['order_id'],"not_null","order_id","order_id is empty.");
            $ip_array[] = array("msg",$ip['quot_type'],"not_null","quot_type","quot_type is empty.");
            $ip_array[] = array("msg",$ip['quot_amt'],"not_null","quot_amt","quot_amt is empty.");
            
            $validation_array = $this->validator->validate($ip_array);
            if ($validation_array !=1) 
            {
                $data['message'] = $validation_array;
                $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
            } 
            else  
            {
                $retVals1 =$this->Save_contact_model->save_contact($ip, $serviceName);
                $data['Save_contact'] = $ip;  
                $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
            }
            header("content-type: application/json");
            echo $retVals1;
            exit;
        }

   }
?>