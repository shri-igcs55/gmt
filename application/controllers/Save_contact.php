<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    require('application/libraries/REST_Controller.php');  
    //error_reporting(0);
    class Save_contact extends REST_Controller
    {
        public function Save_contact() 
        {
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
            $logged_in_user = $this->session->userdata('logged_in_user');   
            
            $ip['user_id'] = ($logged_in_user['user_id']!='' ? $logged_in_user['user_id']:$ip['user_id']);
            
            $ip['cont_name']           = trim($this->input->post('cont_name'));
            $ip['cont_email']          = trim($this->input->post('cont_email'));
            $ip['cont_number']         = trim($this->input->post('cont_number'));

            $ip['reg_id_fk']           = trim($this->input->post('reg_id_fk'));
            $ip['cont_group_id']     = trim($this->input->post('cont_group_id'));
            
            $ipJson = json_encode($ip);
            
            //validation
            $validation_array = 1;
            $ip_array[] = array("msg", $ip['user_id'], "not_null", "user_id", "User id is empty.");
            $ip_array[] = array("msg", $ip['cont_name'], "not_null", "cont_name", "Contact name is empty.");
            $ip_array[] = array("msg", $ip['cont_email'], "not_null", "cont_email", "Contact email is empty.");
            $ip_array[] = array("msg", $ip['cont_number'], "not_null", "cont_number", "Contact number is empty.");
            $ip_array[] = array("msg", $ip['cont_group_id'], "not_null", "cont_group_id", "Contact group name id is empty.");

            $validation_array = $this->validator->validate($ip_array);
            if ($validation_array !=1) 
            {
                $data['message'] = $validation_array['msg'];
                $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
            } 
            else  
            {
                $data['details'] = $this->Save_contact_model->save_contact($ip, $serviceName);
                $data['message'] = "Contact saved Successfully.";
                $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
            }
            header("content-type: application/json");
            echo $retVals1;
            exit;
        }

        public function view_contact_post()
        {
            $serviceName = 'view_contact';
            //getting posted values
            $ip['user_id']             = trim($this->input->post('user_id'));
            $logged_in_user = $this->session->userdata('logged_in_user');   
            
            $ip['user_id'] = ($logged_in_user['user_id']!='' ? $logged_in_user['user_id']:$ip['user_id']);
            
            $ipJson = json_encode($ip);
            
            //validation
            $validation_array = 1;
            $ip_array[] = array("msg", $ip['user_id'], "not_null", "user_id", "user id is empty.");
            
            $validation_array = $this->validator->validate($ip_array);
            if ($validation_array !=1) 
            {
                $data['message'] = $validation_array['msg'];
                $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
            } 
            else  
            {
                $data = $this->Save_contact_model->view_contact($ip, $serviceName);
                if($data){
                    $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
                }
                else{
                    $data['message'] = "No Contact saved.";
                    $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
                }
            }
            header("content-type: application/json");
            echo $retVals1;
            exit;
        }

        public function delete_contact_post()
        {
            $serviceName = "delete_contact";

            $ip['user_id']      = trim($this->input->post('user_id'));
            $logged_in_user = $this->session->userdata('logged_in_user');   
            
            $ip['user_id'] = ($logged_in_user['user_id']!='' ? $logged_in_user['user_id']:$ip['user_id']);
            
            $ip['contact_id']   = trim($this->input->post('contact_id'));

            $ipJson = json_encode($ip);
            
            //validation
            $validation_array = 1;
            $ip_array[] = array("msg", $ip['user_id'], "not_null", "user_id", "user id is empty.");
            $ip_array[] = array("msg", $ip['contact_id'], "not_null", "contact_id", "Contact number id is empty.");

            $validation_array = $this->validator->validate($ip_array);
            if ($validation_array !=1) 
            {
                $data['message'] = $validation_array['msg'];
                $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
            } 
            else  
            {
                $rel = $this->Save_contact_model->delete_contact($ip, $serviceName);
                if($rel > 0){
                    $data['message'] = "Contact deleted.";
                    $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
                }
                else{
                    $data['message'] = "Contact not deleted.";
                    $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
                }
            }
            header("content-type: application/json");
            echo $retVals1;
            exit;
        }

        public function edit_contact_post()
        {
            $serviceName = 'edit_contact';
            //getting posted values
            $ip['user_id']  = trim($this->input->post('user_id'));
            $logged_in_user = $this->session->userdata('logged_in_user');   
            
            $ip['user_id'] = ($logged_in_user['user_id']!='' ? $logged_in_user['user_id']:$ip['user_id']);
            
            $ip['cont_group_id']= trim($this->input->post('cont_group_id'));
            $ip['contact_id']   = trim($this->input->post('contact_id'));
            
            $ipJson = json_encode($ip);
            
            //validation
            $validation_array = 1;
            $ip_array[] = array("msg", $ip['user_id'], "not_null", "user_id", "user id is empty.");
            $ip_array[] = array("msg", $ip['cont_group_id'], "not_null", "cont_group_id", "contact group name id is empty.");
            $ip_array[] = array("msg",$ip['contact_id'],"not_null","contact_id","Please select Contact number first.");

            $validation_array = $this->validator->validate($ip_array);
            if ($validation_array !=1) 
            {
                $data['message'] = $validation_array['msg'];
                $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
            } 
            else  
            {
                if($this->Save_contact_model->edit_contact($ip, $serviceName)){
                    $data['message'] = "Contact edited and saved Successfully.";
                    $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
                }else{
                    $data['message'] = "Nothing  is edited.";
                    $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
                }
            }
            header("content-type: application/json");
            echo $retVals1;
            exit;
        }

        public function edit_one_contact_post()
        {
            $serviceName = 'edit_contact';
            //getting posted values
            $ip['user_id']  = trim($this->input->post('user_id'));
            $logged_in_user = $this->session->userdata('logged_in_user');   
            
            $ip['user_id'] = ($logged_in_user['user_id']!='' ? $logged_in_user['user_id']:$ip['user_id']);
            
            $ip['contact_id'] = trim($this->input->post('contact_id'));
            
            $ipJson = json_encode($ip);
            
            //validation
            $validation_array = 1;
            $ip_array[] = array("msg", $ip['user_id'], "not_null", "user_id", "user id is empty.");
            $ip_array[] = array("msg",$ip['contact_id'],"not_null","contact_id","Contact number id is empty.");

            $validation_array = $this->validator->validate($ip_array);
            if ($validation_array !=1) 
            {
                $data['message'] = $validation_array['msg'];
                $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
            } 
            else  
            {
                $result = $this->Save_contact_model->edit_one_contact($ip, $serviceName);
                if($result){
                    $data = $result;
                    $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
                }else{
                    $data['message'] = "Nothing is selected to edited.";
                    $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
                }
            }
            header("content-type: application/json");
            echo $retVals1;
            exit;
        }

        /*-----------------------------------*/

        public function save_group_post()
        {
            $serviceName = 'save_group';
            //getting posted values
            $ip['user_id']    = trim($this->input->post('user_id'));
            $logged_in_user = $this->session->userdata('logged_in_user');   
            
            $ip['user_id'] = ($logged_in_user['user_id']!='' ? $logged_in_user['user_id']:$ip['user_id']);
            $ip['cont_group_name']  = trim($this->input->post('cont_group_name'));
            
            $ipJson = json_encode($ip);
            //validation
            $validation_array = 1;
            $ip_array[] = array("msg", $ip['user_id'], "not_null", "user_id", "user id is empty.");
            $ip_array[] = array("msg", $ip['cont_group_name'], "not_null", "cont_group_name", "contact group name is empty.");

            $validation_array = $this->validator->validate($ip_array);
            if ($validation_array !=1) 
            {
                $data['message'] = $validation_array['msg'];
                $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
            } 
            else  
            {
                $data['details'] = $this->Save_contact_model->save_group($ip, $serviceName);
                $data['message'] = "Contact saved Successfully.";
                $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
            }
            header("content-type: application/json");
            echo $retVals1;
            exit;
        }

        public function listGroup_post()
        {
            $serviceName = "list_of_group";

            $ip['user_id'] = trim($this->input->post('user_id'));
            $logged_in_user = $this->session->userdata('logged_in_user');   
            
            $ip['user_id'] = ($logged_in_user['user_id']!='' ? $logged_in_user['user_id']:$ip['user_id']);
            $ipJson = json_encode($ip);
            // validation
            $validation_array = 1;
            $ip_array[] = array("msg",$ip['user_id'],"not_null","user_id","User id is empty.");

            $validation_array = $this->validator->validate($ip_array);
            if($validation_array != 1){
                $data['message'] = $validation_array['msg'];
                $retVals1 = $this->seekahoo_lib->return_status('error',$serviceName,$data,$ipJson);
            }else{
                $data = $this->Save_contact_model->view_contact_group($ip, $serviceName);
                // print_r($data);exit();
                $retVals1=$this->seekahoo_lib->return_status('success',$serviceName,$data,$ipJson);
            }
            header("content-type: application/json");
            echo $retVals1;
            exit;
        }

        public function delete_group_post()
        {
            $serviceName = "delete_group";

            $ip['user_id']      = trim($this->input->post('user_id'));
            $logged_in_user = $this->session->userdata('logged_in_user');   
            
            $ip['user_id'] = ($logged_in_user['user_id']!='' ? $logged_in_user['user_id']:$ip['user_id']);
            
            $ip['group_id']   = trim($this->input->post('group_id'));

            $ipJson = json_encode($ip);
            
            //validation
            $validation_array = 1;
            $ip_array[] = array("msg", $ip['user_id'], "not_null", "user_id", "user id is empty.");
            $ip_array[] = array("msg", $ip['group_id'],"not_null","group_id","group id is empty.");

            $validation_array = $this->validator->validate($ip_array);
            if ($validation_array !=1) 
            {
                $data['message'] = $validation_array['msg'];
                $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
            } 
            else  
            {
                $rel = $this->Save_contact_model->delete_group($ip, $serviceName);
                if($rel > 0){
                    $data['message'] = "Group deleted.";
                    $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
                }
                else{
                    $data['message'] = "No Group deleted.";
                    $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
                }
            }
            header("content-type: application/json");
            echo $retVals1;
            exit;
        }
    }
?>