<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);
	class User extends REST_Controller
	{
		public function User() 
		{
			parent::__construct();
			$this->load->model('User_model');
			$this->load->library('email');
			$this->load->library('upload');
			$this->load->library('seekahoo_lib');
			$this->load->library('Validator.php');
			date_default_timezone_set('Asia/Kolkata');
    	}	

    	// User type list
    	public function user_type_list_get()
		{	
			$serviceName = 'User_type_list';
			$ip = '';
			$ipJson = json_encode($ip);			
			$data =$this->User_model->get_user_type();
		    $data = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
			header("content-type: application/json");
		    echo $data;
		    exit;
     	}

     	// User type for login list
    	public function login_user_type_list_get()
		{	
			$serviceName = 'Login_User_type_list';
			$ip = '';
			$ipJson = json_encode($ip);			
			$data =$this->User_model->get_login_user_type();
			$data = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
			header("content-type: application/json");
		    echo $data;
		    exit;
     	}

     	// company type list
     	public function comp_type_list_get()
		{	
			$serviceName = 'Company_type_list';
			$ip = '';
			$ipJson = json_encode($ip);			
			$data =$this->User_model->get_comp_type();
		    $data = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
			header("content-type: application/json");
		    echo $data;
		    exit;
     	}

     	// vehicle type list
     	public function vehicle_list_get()
		{	
			$serviceName = 'Vehicle_list';
			$ip = '';
			$ipJson = json_encode($ip);			
			$data =$this->User_model->get_vehicle_type();
		    $data = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
			header("content-type: application/json");
		    echo $data;
		    exit;
     	}

     	// work description list
     	public function work_desc_list_get()
		{	
			$serviceName = 'Work_description_list';
			$ip = '';
			$ipJson = json_encode($ip);			
			$data =$this->User_model->get_work_type();
		    $data = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
			header("content-type: application/json");
		    echo $data;
		    exit;
     	}

     	// material type list
     	public function material_type_list_get()
		{	
			$serviceName = 'Material_type_list';
			$ip = '';
			$ipJson = json_encode($ip);			
			$data =$this->User_model->get_material_type();
		    $data = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
			header("content-type: application/json");
		    echo $data;
		    exit;
     	}

     	// service type list
     	public function service_type_list_get()
		{	
			$serviceName = 'Service_type_list';
			$ip = '';
			$ipJson = json_encode($ip);			
			$data =$this->User_model->get_service_type();
		    $data = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
			header("content-type: application/json");
		    echo $data;
		    exit;
     	}

     	// service type list
     	public function designation_type_list_get()
		{	
			$serviceName = 'Designation_type_list';
			$ip = '';
			$ipJson = json_encode($ip);			
			$data =$this->User_model->get_designation_list();
		    $data = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
			header("content-type: application/json");
		    echo $data;
		    exit;
     	}

     	// user signup
		public function user_signup_post()
		{
			$six_digit_random_number = mt_rand(100000, 999999);
			$serviceName = 'user_signup';
			$validation_array = 1;

			//getting posted values
			$ip['user_type']        = trim($this->input->post('user_type'));
			$ip['first_name']       = trim($this->input->post('first_name'));
			$ip['last_name']        = trim($this->input->post('last_name'));
			$ip['user_email']       = trim($this->input->post('user_email'));
			$ip['user_mob']         = trim($this->input->post('user_mob'));
			$ip['user_pass']        = trim($this->input->post('user_pass'));
			$ip['c_pass']           = trim($this->input->post('c_pass'));
			$ip['firm_name']        = trim($this->input->post('firm_name'));
            $ip['pan']              = trim($this->input->post('pan'));
            
            $ip['company_type']     = trim($this->input->post('company_type'));
            $ip['other_company_type']=trim($this->input->post('other_company_type_new'));
            
            $ip['designation']      = trim($this->input->post('designation'));
            $ip['other_designation']= trim($this->input->post('other_designation_new'));
            
            $ip['address1']         = trim($this->input->post('address1'));
            $ip['address2']         = trim($this->input->post('address2'));
            // $ip['country']          = trim($this->input->post('country'));
            $ip['state']            = trim($this->input->post('state'));
            $ip['district']         = trim($this->input->post('district'));
            $ip['city']             = trim($this->input->post('city'));
            $ip['pin']              = trim($this->input->post('pin'));
            $ip['tc']              	= trim($this->input->post('tc'));
         	// $ip['user_image']       = trim($this->input->post('user_image'));
            $ip['device_token']     = trim($this->input->post('device_token'));
            // $ip['pkg_id']     		= trim($this->input->post('pkg_id'));
            $ip['user_otp']         = $six_digit_random_number;
            $ip['user_status']      = '1';
            $ip['created_datetime'] = Date('Y-m-d h:i:s');
            $ip['created_ip']       = $_SERVER['REMOTE_ADDR'];
            $ip['modified_datetime']= Date('Y-m-d h:i:s');
            $ip['modified_ip']      = $_SERVER['REMOTE_ADDR'];

	        	 if($ip['user_type'] == 3) { $user_code = 'cust_indv-';	} //Customer 
	        else if($ip['user_type'] == 4) { $user_code = 'cust_comp-';	} //Customer company
	        else if($ip['user_type'] == 5) { $user_code = 'pm-'; 		} //packers and movers
	        else if($ip['user_type'] == 6) { $user_code = 'cp-';		} //crain provider
	        else if($ip['user_type'] == 8) { $user_code = 'tprt_cs-';	} //tr container 
	        else if($ip['user_type'] == 9) { $user_code = 'tprt_ca-';	} //tr commission 
	        else if($ip['user_type'] == 10){ $user_code = 'tprt_fo-';	} //tr fleet owner
	        else if($ip['user_type'] == 11){ $user_code = 'tprt_tnls-';	} //transporter 
	        else if($ip['user_type'] == 12){ $user_code = 'tprt_tp-';	} //trolly tanker
	        else {
				$user_code = "";
	        }

	        $ip['user_rand_id']     = $user_code.strtotime(Date('Y-m-d H:i:s'));

			//validation
			$ip_array[] = array("msg", $ip['user_type'], "not_null", "user_type","User type is empty");
			$ip_array[] = array("msg", $ip['user_email'], "not_null", "user_email","E-Mail is empty.");
			$ip_array[] = array("msg", $ip['user_mob'], "not_null", "user_mob", "Mobile number is empty.");
			$ip_array[] = array("msg", $ip['first_name'], "not_null", "first_name", "First name is empty.");
			$ip_array[] = array("msg", $ip['address1'], "not_null", "address1", "Address is empty.");
			$ip_array[] = array("msg", $ip['state'], "not_null", "state", "State is empty.");
			$ip_array[] = array("msg", $ip['district'], "not_null", "district", "District is empty.");
			$ip_array[] = array("msg", $ip['city'], "not_null", "city", "City is empty.");
			$ip_array[] = array("msg", $ip['pin'], "not_null", "pin", "Pincode is empty.");
			// $ip_array[] = array("msg", $ip['pkg_id'], "not_null", "pkg_id", "Package id is empty.");
			// print_r($ip_array[2][0]);exit();

			if($ip['user_type']==4)
			{
				if($ip['company_type'] == 1){
				    $ip_array[] = array("msg", $ip['other_company_type'], "not_null", "other_company_type", "Other Company Type is empty.");
				}else{
					$ip_array[] = array("msg", $ip['company_type'], "not_null", "company_type", "Company Type is empty.");		    
				}
               

			    if($ip['designation'] == 'Other'){
				    $ip_array[] = array("msg", $ip['other_designation'], "not_null", "other_designation", "Other Designation is empty.");
				}else{
				    $ip_array[] = array("msg", $ip['designation'], "not_null", "designation", "Designation is empty.");
				}

			    $ip_array[] = array("msg", $ip['firm_name'], "not_null", "firm_name", "Firm name is empty.");
			    $ip_array[] = array("msg", $ip['pan'], "not_null", "pan", "Pan Number is empty.");
			}
			else if($ip['user_type']== 5 || $ip['user_type']== 6 || $ip['user_type']== 8 || 
			   		$ip['user_type']== 9 || $ip['user_type']==10 || $ip['user_type']==11 || 
			   		$ip['user_type']==12)
			{
				$ip_array[] = array("msg", $ip['firm_name'], "not_null", "firm_name", "Firm name is empty.");
			    $ip_array[] = array("msg", $ip['pan'], "not_null", "pan", "Pan is empty.");
			}

			$validation_array = $this->validator->validate($ip_array);
			$ipJson = json_encode($ip);
	                
			if(empty($ip['user_pass']))
			{
				$data['message'] = "All * marked fields must not be empty.";
			    $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			}
			else if($ip['user_pass'] != $ip['c_pass'])
            {
            	$data['message'] = "Password and Confirm Password not matched.";
			    $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
            } 
			else if ($model_mob = $this->User_model->check_mob_reg($ip)) 
			{
                $data['message'] = 'Mobile number alerady registered.';
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else if ($model_email = $this->User_model->check_email_reg($ip)) 
			{
                $data['message'] = 'Email address alerady registered.';
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			}
			else if ($validation_array !=1) 
			{
				// print_r($model_mob);
				// echo "<br/>";
				// print_r($model_email);
                $data['message'] = $validation_array['msg'];
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else  
			{
                // $retVals1 = $this->User_model->user_breif($ip, $serviceName);
                if (!null==($ip['user_mob']) || !empty($ip['user_mob']))
	            {
	               	/*=================GENRAING OTP=====================*/
		            $user="developer11112@indglobal-consulting.com:indglobal123";
				    $sender="TEST SMS";
				    $number = $ip['user_mob'];
				    $message="Your One Time Password is :".$six_digit_random_number." For confirm the registration. Please do not share this password with Anyone - Getmytruck.com"; 
				    /*=========ENDING OF GENRAING OTP=================*/
				}
				$retVals1 = $this->User_model->signup($ip, $serviceName);
            	$ch = curl_init();
              	curl_setopt($ch,CURLOPT_URL,"http://api.mVaayoo.com/mvaayooapi/MessageCompose");
              	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
              	curl_setopt($ch, CURLOPT_POST, 1);
              	curl_setopt($ch, CURLOPT_POSTFIELDS,"user=".$user."&senderID=".$sender."&receipientno=".$number."&msgtxt=".$message."");
			    $buffer = curl_exec($ch);
			    curl_close($ch);
			    json_decode($retVals1);	
			}
            header("content-type: application/json");
	        echo $retVals1;
	        exit;
	   	}
		
		/*Sign in Section*/
        public function user_signin_post()
        {
		    $serviceName = 'user_signin';
		    //getting posted values
		    $ip['email_mob'] = trim($this->input->post('email_mob'));
		    $ip['password'] = trim($this->input->post('password'));
		    // $ip['user_type_id'] = trim($this->input->post('utype_id'));
		    $ipJson = json_encode($ip);

		    //validation
		    $validation_array = 1;
		    
		    $ip_array[] = array("msg", $ip['email_mob'], "not_null", "email_mob", "Email id or Mobile number is empty.");
			$ip_array[]=array("msg",$ip['password'], "not_null", "password", "Password is empty.");
			// $ip_array[] = array("msg", $ip['user_type_id'], "not_null", "user_type_id", "User role is empty.");
			$validation_array = $this->validator->validate($ip_array);
			if ($validation_array !=1) 
			{
				$data['message'] = $validation_array['msg'];
				$retVals=$this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			}else if($em_data = $this->User_model->check_email($ip)){
				// $ip['email'] = $em_data[0]->user_email;
				if(!empty($em_data)){
					$retVals = $this->User_model->check_signin($ip, $serviceName);
				}else{
					$data['message'] = 'Email id is wrong.';
          			$retVals = $this->seekahoo_lib->return_status('Error', $serviceName, $data, $ipJson);
				}
		    }else if($em_data = $this->User_model->check_mob($ip)){
		    	// $ip['mobile'] = $em_data[0]->user_mob;
		    	if(!empty($em_data)){
					$retVals = $this->User_model->check_signin($ip, $serviceName);
		    	}else{
					$data['message'] = 'Mobile id is wrong.';
          			$retVals = $this->seekahoo_lib->return_status('Error', $serviceName, $data, $ipJson);
				}
		    }else{
		    	$data['message'] = 'Please check login details you Entered.';
          		$retVals=$this->seekahoo_lib->return_status('Error', $serviceName, $data, $ipJson);
		    }
			json_decode($retVals);
			header("content-type: application/json");
		    echo $retVals;
		    exit;
	    }
		/*End of Sign in Section*/

		public function chng_pass_post()
		{
			$serviceName = 'change password';
			//getting posted values
			$ip['user_id']  = trim($this->input->post('user_id'));
			$logged_in_user = $this->session->userdata('logged_in_user');	
			
			$ip['user_id'] 	= ($logged_in_user['user_id']!='' ? $logged_in_user['user_id']:$ip['user_id']);
			$ip['old_pass'] = trim($this->input->post('old_pass'));
			$ip['new_pass'] = trim($this->input->post('new_pass'));
		    $ip['c_pass']   = trim($this->input->post('c_pass'));
			
			$ipJson = json_encode($ip);
			//validation
			$validation_array = 1;

			$ip_array[] = array("msg", $ip['new_pass'],"not_null","new_pass","New password is Empty.");
			$ip_array[] = array("msg",$ip['c_pass'],"not_null","c_pass","Conifirm password is empty.");
			$ip_array[] = array("msg", $ip['old_pass'],"not_null","old_pass","Old password is Empty.");
			$ip_array[] = array("msg", $ip['user_id'], "not_null", "user_id", "User id is empty.");

			$validation_array = $this->validator->validate($ip_array);		
            if($ip['new_pass'] !== $ip['c_pass'])
		    {
			   	$data['message'] = "Password missmatch.";
			   	$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
            }
			else if ($validation_array !=1) 
			{
			 	$data['message'] = $validation_array['msg'];
			 	$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else
			{
			    $change=$this->User_model->c_pass($ip);
			    if($change){
					$data['message'] = "Paasword Changed Successfully";
				 	$retVals1 = $this->seekahoo_lib->return_status('success',$serviceName, $data, $ipJson);
				}else{
					$data['message'] = "Password Not Chagned please try again.";
			   		$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
				}
			} 
     		//echo $retVals1 = $this->signup_model->signup($ip, $serviceName);
			header("content-type: application/json");
			echo $retVals1;
			exit;
	    }
		/*End of chng_pass Section*/

		/* User Profile update */
		public function user_update_profile_post()
		{
			// print_r($_POST);exit();
			$serviceName = 'user_update';
			$validation_array = 1;

			$ip['user_id'] = trim($this->input->post('user_id'));
			$ip['user_type'] = trim($this->input->post('user_type'));
			
			$logged_in_user = $this->session->userdata('logged_in_user');	
			
			$ip['user_id'] = ($logged_in_user['user_id']!='' ? $logged_in_user['user_id']:$ip['user_id']);
			$ip['user_type'] = ($logged_in_user['user_type']!='' ? $logged_in_user['user_type']:$ip['user_type']);

			//getting posted values
			$ip['first_name']       = trim($this->input->post('first_name'));
			$ip['last_name']        = trim($this->input->post('last_name'));
			// $ip['user_email']       = trim($this->input->post('user_email'));
			// $ip['user_mob']         = trim($this->input->post('user_mob'));
			// $ip['user_pass']        = trim($this->input->post('user_pass'));
			// $ip['c_pass']           = trim($this->input->post('c_pass'));
			$ip['firm_name']        = trim($this->input->post('firm_name'));
            $ip['pan']              = trim($this->input->post('pan'));
            $ip['company_type']     = trim($this->input->post('company_type'));
            $ip['designation']      = trim($this->input->post('designation'));
            $ip['address1']         = trim($this->input->post('address1'));
            $ip['address2']         = trim($this->input->post('address2'));
            // $ip['country']          = trim($this->input->post('country'));
            $ip['state']            = trim($this->input->post('state'));
            $ip['district']         = trim($this->input->post('district'));
            $ip['city']             = trim($this->input->post('city'));
            $ip['pin']              = trim($this->input->post('pin'));
            // $ip['tc']               = trim($this->input->post('tc'));
         	// $ip['user_image']       = trim($this->input->post('user_image'));
            // $ip['device_token']     = trim($this->input->post('device_token'));
            // $ip['pkg_id']     	   = trim($this->input->post('pkg_id'));
            // $ip['user_otp']         = $six_digit_random_number;
            // $ip['user_status']      = '1';
            $ip['tin'] 				= trim($this->input->post('tin'));
            $ip['stax'] 			= trim($this->input->post('stax'));
            $ip['modified_datetime']= Date('Y-m-d h:i:s');
            $ip['modified_ip']      = $_SERVER['REMOTE_ADDR'];

	        	/* if($ip['user_type'] == 3) { $user_code = 'cust_indv-';	} //Customer 
	        else if($ip['user_type'] == 4) { $user_code = 'cust_comp-';	} //Customer company
	        else if($ip['user_type'] == 5) { $user_code = 'pm-'; 		} //packers and movers
	        else if($ip['user_type'] == 6) { $user_code = 'cp-';		} //crain provider
	        else if($ip['user_type'] == 8) { $user_code = 'tprt_cs-';	} //tr container 
	        else if($ip['user_type'] == 9) { $user_code = 'tprt_ca-';	} //tr commission 
	        else if($ip['user_type'] == 10){ $user_code = 'tprt_fo-';	} //tr fleet owner
	        else if($ip['user_type'] == 11){ $user_code = 'tprt_tnls-';	} //transporter 
	        else if($ip['user_type'] == 12){ $user_code = 'tprt_tp-';	} //trolly tanker
	        else {
				$user_code = "";
	        }
	        $ip['user_rand_id']     = $user_code.strtotime(Date('Y-m-d H:i:s'));*/

	        //validation
			$ip_array[] = array("msg", $ip['user_type'], "not_null", "user_type","User type is empty");
			// $ip_array[] = array("msg", $ip['user_email'], "not_null", "user_email","E-Mail is empty.");
			// $ip_array[] = array("msg", $ip['user_mob'], "not_null", "user_mob", "Mobile number is empty.");
			$ip_array[] = array("msg", $ip['first_name'], "not_null", "first_name", "First name is empty.");
			$ip_array[] = array("msg", $ip['address1'], "not_null", "address1", "Address is empty.");
			$ip_array[] = array("msg", $ip['state'], "not_null", "state", "State is empty.");
			$ip_array[] = array("msg", $ip['district'], "not_null", "district", "District is empty.");
			$ip_array[] = array("msg", $ip['city'], "not_null", "city", "City is empty.");
			$ip_array[] = array("msg", $ip['pin'], "not_null", "pin", "Pincode is empty.");
			// $ip_array[] = array("msg", $ip['pkg_id'], "not_null", "pkg_id", "Package id is empty.");
			// print_r($ip_array[2][0]);exit();

			if($ip['user_type']==4)
			{
                $ip_array[] = array("msg", $ip['company_type'], "not_null", "company_type", "Company Type is empty.");
			    $ip_array[] = array("msg", $ip['designation'], "not_null", "designation", "Designation is empty.");
			    $ip_array[] = array("msg", $ip['firm_name'], "not_null", "firm_name", "Firm name is empty.");
			    $ip_array[] = array("msg", $ip['pan'], "not_null", "pan", "Pan Number is empty.");
			}
			else if($ip['user_type']== 5 || $ip['user_type']== 6 || $ip['user_type']== 8 || 
			   		$ip['user_type']== 9 || $ip['user_type']==10 || $ip['user_type']==11 || 
			   		$ip['user_type']==12)
			{
				$ip_array[] = array("msg", $ip['firm_name'], "not_null", "firm_name", "Firm name is empty.");
			    $ip_array[] = array("msg", $ip['pan'], "not_null", "pan", "Pan Number is empty.");
			    $ip_array[] = array("msg", $ip['tin'], "not_null", "tin", "VAT-TIN Number is empty.");
			    $ip_array[] = array("msg", $ip['stax'], "not_null", "stax", "Service Tax Number is empty.");
			}

			$validation_array = $this->validator->validate($ip_array);
			$ipJson = json_encode($ip);
	                
			/*if(empty($ip['user_pass']))
			{
				$data['message'] = "All * marked fields must not be empty.";
			    $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			}
			else if($ip['user_pass'] != $ip['c_pass'])
            {
            	$data['message'] = "Password and Confirm Password not matched.";
			    $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
            } 
			else if ($model_mob = $this->User_model->check_mob_reg($ip)) 
			{
                $data['message'] = 'Mobile number alerady registered.';
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else if ($model_email = $this->User_model->check_email_reg($ip)) 
			{
                $data['message'] = 'Email address alerady registered.';
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			}
			else */
			if ($validation_array !=1) 
			{
				// print_r($model_mob);
				// echo "<br/>";
				// print_r($model_email);
                $data['message'] = $validation_array['msg'];
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else  
			{
                // $retVals1 = $this->User_model->user_breif($ip, $serviceName);
    			//   if (!null==($ip['user_mob']) || !empty($ip['user_mob']))
	   			//   {
	   			// 	 	/*=================GENRAING OTP=====================*/
		  		//     	$user="developer11112@indglobal-consulting.com:indglobal123";
				//     	$sender="TEST SMS";
				//     	$number = $ip['user_mob'];
				//     	$message="Your One Time Password is :".$six_digit_random_number." For confirm the registration. Please do not share this password with Anyone - Getmytruck.com"; 
				//     	/*=========ENDING OF GENRAING OTP=================*/
				// 	  }
				$retVals1 = $this->User_model->update_user($ip, $serviceName);
            	/*$ch = curl_init();
              	curl_setopt($ch,CURLOPT_URL,"http://api.mVaayoo.com/mvaayooapi/MessageCompose");
              	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
              	curl_setopt($ch, CURLOPT_POST, 1);
              	curl_setopt($ch, CURLOPT_POSTFIELDS,"user=".$user."&senderID=".$sender."&receipientno=".$number."&msgtxt=".$message."");
			    $buffer = curl_exec($ch);
			    curl_close($ch);*/
			    json_decode($retVals1);	
			}
            header("content-type: application/json");
	        echo $retVals1;
	        exit;
	   	}

	   	/* Forget password(Recover) Section*/
        public function recover_post()
		{
			$ip['six_digit_random_number'] = mt_rand(10000000, 99999999);
		            
			$serviceName = 'Forgot Password';
			$ip['email_mob']   = trim($this->input->post('email_mob'));
			
			$ipJson = json_encode($ip);

		    //validation
		    $validation_array = 1;
		    
		    $ip_array[] = array("msg", $ip['email_mob'], "not_null", "email_mob", "Email id or Mobile number is empty.");
			
			$validation_array = $this->validator->validate($ip_array);
			if ($validation_array !=1) 
			{
				$data['message'] = $validation_array['msg'];
				$retVals=$this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			}else if($em_data = $this->User_model->check_email($ip)){
				// $ip['email'] = $em_data[0]->user_email;
				if(!empty($em_data)){
					
					/*======================Mailing Part======================*/
			        $from_email = "noreply@getmytruck.in"; 
			        $to_email = $ip['email_mob']; 
			        $this->email->from($from_email, 'Getmytruck.in'); 
			        $this->email->to($to_email);
			        $this->email->subject('New Password Email'); 
			        $this->email->message('Your new password is '.$ip['six_digit_random_number']);
			        if($this->email->send()):

						if($this->User_model->new_otp_pass($ip, $serviceName)){
							/*==================Sending Otp Again=====================*/ 
		                    $user="developer321322@indglobal-consulting.com:indglobal123";
							$sender="TEST SMS";
							$number = $ip['email_mob'];
							$message="Your Temporary Password is : ".$ip['six_digit_random_number']." To change Your Paasword Login with this Please do not share this password with Anyone - Doctorway"; 
							$ch = curl_init();
							curl_setopt($ch,CURLOPT_URL, "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_POST, 1);
							curl_setopt($ch, CURLOPT_POSTFIELDS, "user=".$user."&senderID=".$sender."&receipientno=".$number."&msgtxt=".$message."");
							$buffer = curl_exec($ch);
							curl_close($ch);
							/*==================Sending Otp Again=====================*/
	         				$data['message'] = 'OTP sent, Please check email or mobile.';
	          				$retVals = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson); 
	          			}

         			endif;
                    /*=====================Ending Mailing Part====================*/  

				}else{
					$data['message'] = 'Email id is wrong.';
          			$retVals = $this->seekahoo_lib->return_status('Error', $serviceName, $data, $ipJson);
				}
		    }else if($em_data = $this->User_model->check_mob($ip)){
		    	// $ip['mobile'] = $em_data[0]->user_mob;
		    	if(!empty($em_data)){

		    		/*======================Mailing Part======================*/
			        $from_email = "noreply@getmytruck.in"; 
			        $to_email = $ip['email_mob']; 
			        $this->email->from($from_email, 'Getmytruck.in'); 
			        $this->email->to($to_email);
			        $this->email->subject('New Password Email'); 
			        $this->email->message('Your new password is '.$ip['six_digit_random_number']);
			        if($this->email->send()):
					
						if($this->User_model->new_otp_pass($ip, $serviceName)){
							/*==================Sending Otp Again=====================*/ 
		                    $user="developer321322@indglobal-consulting.com:indglobal123";
							$sender="TEST SMS";
							$number = $ip['email_mob'];
							$message="Your Temporary Password is : ".$ip['six_digit_random_number']." To change Your Paasword Login with this Please do not share this password with Anyone - Doctorway"; 
							$ch = curl_init();
							curl_setopt($ch,CURLOPT_URL, "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_POST, 1);
							curl_setopt($ch, CURLOPT_POSTFIELDS, "user=".$user."&senderID=".$sender."&receipientno=".$number."&msgtxt=".$message."");
							$buffer = curl_exec($ch);
							curl_close($ch);
							/*==================Sending Otp Again=====================*/
							$data['message'] = 'OTP sent, Please check email or mobile.';
		          			$retVals = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson); 
	          			}
	          		endif;
		    	}else{
					$data['message'] = 'Mobile id is wrong.';
          			$retVals = $this->seekahoo_lib->return_status('Error', $serviceName, $data, $ipJson);
				}
		    }

	        header("content-type: application/json");
			echo $retVals;
			exit;
	    }  
		/*End of Forget (Recover) Section*/























		/*----------------------------------------------------------------------------*/		
		/*Verification Section*/
        public function verify_post()
		{
			$serviceName = 'verify';
			$ip['v_code']     = trim($this->input->post('v_code'));
            $ip['mobile_num'] = trim($this->input->post('mobile_num'));
            $ip['email']      = trim($this->input->post('email'));
            $ipJson = json_encode($ip);
            if(empty($ip['v_code']) && empty($ip['mobile_num']))
            {
               $data['message'] = "Feilds are Required";
			   $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
            } 
            else
            {
                $chkotp=$this->User_model->check_otp($ip);
                if($chkotp=="true")
                {
                	$code =$ip['v_code'];
                 	$data['message'] = "OTP Matched";
                 	$retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
                 	$up_status = array(
								       'user_status' => 'Active'
					                  );
                 	$chkotp=$this->User_model->update_status($up_status,$code);
                    /*======================Mailing Part======================*/
			        $from_email = "Anuragdubey@gmail.com"; 
			        $to_email = $this->input->post('email'); 
			        $this->email->from($from_email, 'Getmytruck.com'); 
			        $this->email->to($to_email);
			        $this->email->subject('Email Test'); 
			        $this->email->message('Testing the email class.');
                    /*=====================Ending Mailing Part====================*/   
                }
            	else 
	            {
    	        	$data['message'] = "OTP Not Matching";
			    	$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			    	json_decode($retVals1);
           	    }
        	}
	        //echo $retVals1 = $this->signup_model->signup($ip, $serviceName);
            header("content-type: application/json");
            echo $retVals1;
            exit;
	    }
		/*End of Verification in Section*/

		/*Resend Otp Section*/
        public function resend_post()
		{
			$six_digit_random_number = mt_rand(100000, 999999);
			$serviceName = 'resend otp';
			$ip['user_mob']   = trim($this->input->post('mobile'));
			$ipJson = json_encode($ip);
			if (empty($ip['user_mob']))
            {    
                $data['message'] = "Mobile number is null....";
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		        //json_decode($retVals1);	
			}
			else 
			{  
			  	//var_dump($ip);exit();
			   	$chkmob=$this->User_model->check_mob_for_otp($ip);
                if($chkmob=="true")
		        {
		            $six_digit_random_number = mt_rand(100000, 999999);
			        $ipJson = json_encode($ip);
			        $data['user_mob'] = "Otp send to number";
			        $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson); 
				    /*==================Sending Otp Again=====================*/ 
                    $user="developer2222@indglobal-consulting.com:indglobal123";
                    $sender="TEST SMS";
				    $number = $ip['user_mob'];
				    $message="Your One Time Password is :".$six_digit_random_number." For confirm the registration. Please do not share this password with Anyone - Getmytruck.com"; 
				    $ch = curl_init();
					curl_setopt($ch,CURLOPT_URL, "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
				    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				    curl_setopt($ch, CURLOPT_POST, 1);
				    curl_setopt($ch, CURLOPT_POSTFIELDS, "user=".$user."&senderID=".$sender."&receipientno=".$number."&msgtxt=".$message."");
				    $buffer = curl_exec($ch);
				    curl_close($ch);
				    /*==================Sending Otp Again=====================*/
				    /*==================Updating Otp Again=====================*/
                    $upuser = array( 
                				   'user_otp' => $six_digit_random_number,
                					   );
                    $user = $this->User_model->updt_otp($ip,$upuser);
				    /*==================Updating Otp Again=====================*/    
		        }
		        else
		        {
		           	$data['message'] = "Please Sign up first";
				    $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);	
				    json_decode($retVals1);
	            }		        
	        }
		    header("content-type: application/json");
		    echo $retVals1;
	        exit;
     	}
		/*End of Resend Otp Section*/

		/* Update Section*/
        public function update_brief_post()
		{
			$six_digit_random_number = mt_rand(100000, 999999);
			$serviceName = 'update_breif';
			//getting posted values
			$ip['user_id']             = trim($this->input->post('user_id'));
			$logged_in_user = $this->session->userdata('logged_in_user');	
			
			$ip['user_id'] = ($logged_in_user['user_id']!='' ? $logged_in_user['user_id']:$ip['user_id']);
			$ip['u_detail_name']       = trim($this->input->post('u_detail_name'));
			$ip['u_detail_firm_name']  = trim($this->input->post('u_detail_firm_name'));
			$ip['state_fk']            = trim($this->input->post('state_fk'));
			$ip['city_fk']             = trim($this->input->post('city_fk'));
			$ip['u_detail_pin']        = trim($this->input->post('u_detail_pin'));
			$ip['u_detail_pan']        = trim($this->input->post('u_detail_pan'));
		    $ip['u_detail_tin']        = trim($this->input->post('u_detail_tin'));
		    $ip['u_detail_stax']       = trim($this->input->post('u_detail_stax'));
		    $ip['comp_type_id_fk']     = trim($this->input->post('comp_type_id_fk'));
		    $ip['trans_cat_id_fk']     = trim($this->input->post('trans_cat_id_fk'));
		    $ip['created_datetime']    = Date('Y-m-d h:i:s');
            $ip['created_ip']          = $_SERVER['REMOTE_ADDR'];
		    $ip['modified_datetime']   = Date('Y-m-d h:i:s');
		    $ip['modified_ip']         = $_SERVER['REMOTE_ADDR'];
			//var_dump($_FILES['user_pic']);exit();
            // print_r($ip); exit();
			$ipJson = json_encode($ip);
			//validation
			$validation_array = 1;
			$ip_array[] = array("u_detail_name", $ip['u_detail_name'], "not_null", "u_detail_name", "User name is empty.");
			$ip_array[] = array("u_detail_firm_name", $ip['u_detail_firm_name'], "not_null", "u_detail_firm_name", "Firm name is empty.");
			$ip_array[] = array("state_fk", $ip['state_fk'], "not_null", "state_fk","State is empty.");
			$ip_array[] = array("city_fk", $ip['city_fk'], "not_null", "city_fk", "City is empty.");
			$ip_array[] = array("u_detail_pin", $ip['u_detail_pin'], "not_null", "u_detail_pin", "Pin is empty.");
			$ip_array[] = array("u_detail_pan", $ip['u_detail_pan'], "not_null", "u_detail_pan", "Pan id is empty.");
			$ip_array[] = array("u_detail_tin", $ip['u_detail_tin'], "not_null", "u_detail_tin", "Tin id is empty.");
			$ip_array[] = array("u_detail_stax", $ip['u_detail_stax'], "not_null", "u_detail_stax", "Service tax id is empty.");
			$ip_array[] = array("comp_type_id_fk", $ip['comp_type_id_fk'], "not_null", "comp_type_id_fk", "comp_type id is empty.");
			$ip_array[] = array("trans_cat_id_fk", $ip['trans_cat_id_fk'], "not_null", "trans_cat_id_fk", "Transporter category id is empty.");
			$validation_array = $this->validator->validate($ip_array);		
		    if ($validation_array !=1) 
			{
			    $data['message'] = $validation_array;
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else  
			{
				$details_update = $this->User_model->update_brief($ip);
				$data = $details_update[0];
			  	$data['message'] = "Profile Details updated ";
			  	$retVals1 = $this->seekahoo_lib->return_status('success',$serviceName, $data, $ipJson);
			} 
            //echo $retVals1 = $this->signup_model->signup($ip,  $serviceName);
			header("content-type: application/json");
			echo $retVals1;
			exit;
	    }
		/*End of Update Section*/

		/*Mobile num change Section Starts*/
        public function mobchange_post()
		{
			$serviceName = 'Mobile_num_change';
			//getting posted values
			$ip['mobile'] = trim($this->input->post('mobile'));
			$ip['user_id'] = trim($this->input->post('user_id'));
			$ipJson = json_encode($ip);
			//validation
			$validation_array = 1;	
			$ip_array[] = array("mobile", $ip['mobile'], "not_null", "mobile", "Mobile num is empty.");
			$validation_array = $this->validator->validate($ip_array);
			if ($validation_array !=1) 
			{
			    $data['message'] = $validation_array;
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else if (isset($ip['mobile'])) 
			{      
			    $upmob = array( 
               			   'user_status'=>'Pending',
               			   'user_mob'   =>$ip['mobile']
               			    );
				$this->User_model->update_mob($ip,$upmob);
				$data['message'] ="Mobile number Successfully Changed";
				$retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
				json_decode($retVals1);
			}			
     		//echo $retVals1 = $this->signup_model->signup($ip, $serviceName);
			header("content-type: application/json");
			echo $retVals1;
			exit;
	    }
		/*End of mobile change Section*/
		
		/*View Profile Section Starts*/
        public function view_profile_post()
		{
			$serviceName = 'view_profile';
			//getting posted values
			$ip['user_id']             = trim($this->input->post('user_id'));
			$logged_in_user = $this->session->userdata('logged_in_user');	
			
			$ip['user_id'] = ($logged_in_user['user_id']!='' ? $logged_in_user['user_id']:$ip['user_id']);
			$ipJson = json_encode($ip);
				//validation
		    $validation_array = 1;	
			$ip_array[] = array("user_id", $ip['user_id'], "not_null", "user_id", "Field is empty.");
			$validation_array = $this->validator->validate($ip_array);	
        	if ($validation_array !=1) 
			{
	            $data['message'] = $validation_array;
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
			} 
			else
			{
                $data['View_profile'] =$this->User_model->view_profile($ip, $serviceName);
                $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
			}
		    header("content-type: application/json");
		    echo $retVals1;
		    exit;
	    }
		/*End of View details Section*/
	}
































		/* chng_pass Section*/
  		//       public function chng_pass_post()
	// {
		// 	$serviceName = 'change password';
		// 	//getting posted values
		// 	$ip['old_pass']    = trim($this->input->post('old_pass'));
		// 	$ip['new_pass']    = trim($this->input->post('new_pass'));
		//     $ip['c_pass']      = trim($this->input->post('cn_pass'));
		//     $ip['mobile']      = trim($this->input->post('mobile'));
		//     $ip['cust_id']     = trim($this->input->post('cust_id'));
		//     $ip['user_name']   = trim($this->input->post('user_name'));
		// 	//var_dump($_FILES['user_pic']);exit();
  		//           // print_r($ip); exit();
		// 	if (!null==($ipJson = json_encode($ip)))
  		//           {
  		//              	/*=================GENRAING OTP=====================*/
	 	//            $user="developer22211@indglobal-consulting.com:indglobal123";
		// 	    $sender ="TEST SMS";
		// 	    $number = $ip['mobile'];
		// 	    $name   = "Dear User";//$ip['user_name'];
		// 	    $message="Hi:".$name." Your Password is Changed Successfully You can Login in Few minutes - Getmytruck.com"; 
		// 	    $ipJson = json_encode($ip);  
		// 	    $chk_pass=$this->User_model->c_pass($ip);
  		//               /*=================ENDING OF GENRAING OTP=====================*/
		// 	}
		// 	//validation
		// 	$validation_array = 1;
		// 	$ip_array[] = array("old_pass", $ip['old_pass'], "not_null", "old_pass", "Old password is empty.");
		// 	$ip_array[] = array("new_pass", $ip['new_pass'], "not_null", "new_pass", "New password is Empty.");
		// 	$ip_array[] = array("c_pass", $ip['c_pass'], "not_null", "c_pass", "Conifirm password is empty.");
		// 	$ip_array[] = array("mobile", $ip['mobile'], "not_null", "mobile", "Mobile number is empty.");
		// 	$ip_array[] = array("cust_id", $ip['cust_id'], "not_null", "cust_id", "customer id is empty.");
		// 	$validation_array = $this->validator->validate($ip_array);		
  		//           if($ip['new_pass'] != $ip['c_pass'])
		//     {
		// 	   	$data['message'] = "Password missmatch.";
		// 	   	$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
  		//           }
		// 	else if ($validation_array !=1) 
		// 	{
		// 	 	$data['message'] = $validation_array;
		// 	 	$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		// 	} 
		// 	else if ($chk_pass=="True") 
		// 	{
		// 	    $change=$this->User_model->c_pass($ip);
		// 		$data['message'] = "Paasword Changed Successfully";
		// 	 	$retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
		// 		 /*===============Sending Otp==================*/
  		//               $ch = curl_init();
		// 	    curl_setopt($ch,CURLOPT_URL,"http://api.mVaayoo.com/mvaayooapi/MessageCompose");
		// 	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// 	    curl_setopt($ch, CURLOPT_POST, 1);
		// 	    curl_setopt($ch, CURLOPT_POSTFIELDS, "user=".$user."&senderID=".$sender."&receipientno=".$number."&msgtxt=".$message."");
		// 	    $buffer = curl_exec($ch);
		// 	    curl_close($ch);
		// 	     /*===============Sending Otp===================*/
		// 	} 
		// 	else  
		// 	{
		// 	  	//$done_otp=$this->update_model->updt_status_with($ip);
		// 	  	$data['message'] = "Paasword Not Correct";
		// 	  	$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		// 	  	json_decode($retVals1);	  
		// 	}
  		//    		//echo $retVals1 = $this->signup_model->signup($ip, $serviceName);
		// 	header("content-type: application/json");
		// 	echo $retVals1;
		// 	exit;
//    }
?>