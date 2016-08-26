<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	require('application/libraries/REST_Controller.php');  
	//error_reporting(0);

	/**
	* Sign up form controller
	*/
	class User extends REST_Controller
	{
		public function User() {
			parent::__construct();

			$this->load->model('User_model');
			$this->load->library('email');
			$this->load->library('upload');
			$this->load->library('seekahoo_lib');
			$this->load->library('Validator.php');
    	}
		
		public function user_signup_post()
		{
			$six_digit_random_number = mt_rand(100000, 999999);
			$serviceName = 'user_signup';
			//getting posted values
			$ip['user_rand_id']     = 'cust-'.strtotime(Date('Y-m-d H:i:s'));
			$ip['user_email']       = trim($this->input->post('user_email'));
			$ip['user_mob']         = trim($this->input->post('user_mob'));

			$ip['user_pass']        = trim($this->input->post('user_pass'));
			$ip['c_pass']           = trim($this->input->post('c_pass'));

			$ip['user_otp']         = $six_digit_random_number;
            $ip['user_status']      = 'Pending';
            $ip['u_type_id']        = trim($this->input->post('u_type_id'));
            $ip['trans_cat_id']     = trim($this->input->post('trans_cat_id'));
            $ip['pkg_id']           = trim($this->input->post('pkg_id'));
            $ip['created_datetime'] = Date('Y-m-d h:i:s');
            $ip['created_ip']       = $_SERVER['REMOTE_ADDR'];
            
			//var_dump($_FILES['user_pic']);exit();
           // print_r($ip); exit();
			if (!null==($ipJson = json_encode($ip)))
                {
               	/*=================GENRAING OTP=====================*/
	            $user="developer11112@indglobal-consulting.com:indglobal123";

			    $sender="TEST SMS";
			    $number = $ip['user_mob'];
			    $message="Your One Time Password is :".$six_digit_random_number." For confirm the registration. Please do not share this password with Anyone - Getmytruck.com"; 
			               
			    
			    $ipJson = json_encode($ip);
                /*=================ENDING OF GENRAING OTP=====================*/
				}
			
			//validation
			$validation_array = 1;
									
					$ip_array[] = array("user_email", $ip['user_email'], "not_null", "name", "E-Mail is empty.");

					$ip_array[] = array("user_mob", $ip['user_mob'], "not_null", "user_mob", "Mobile number is empty.");

					$ip_array[] = array("user_status", $ip['user_status'], "not_null", "user_status", "User Status is empty.");

					$ip_array[] = array("u_type_id", $ip['u_type_id'], "not_null", "u_type_id", "User Type is empty.");

					$ip_array[] = array("trans_cat_id", $ip['trans_cat_id'], "not_null", "trans_cat_id", "Tranporter category id is empty.");

					$ip_array[] = array("pkg_id", $ip['pkg_id'], "not_null", "pkg_id", "Package id is empty.");
				
					
					
					$validation_array = $this->validator->validate($ip_array);
					
					if($ip['user_pass'] != $ip['c_pass'])
					 {
				     $data['message'] = "Password missmatch.";
				     $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
                     } 
					else if(empty($_POST['user_pass']))
					 {
					  $data['message'] = "Password field empty.";
				      $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					 }


					else if ($this->User_model->check_mob($ip)) 
					{
					 $data['message'] = 'Mobile number alerady registered.';
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 

					else if ($this->User_model->check_email($ip)) 
					{
					 $data['message'] = 'Email address alerady registered.';
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					}

					else if ($validation_array !=1) 
					{
					 $data['message'] = $validation_array;
					 $retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 
					else  {
                           $retVals1 = $this->User_model->signup($ip, $serviceName);
						   $ch = curl_init();
			               curl_setopt($ch,CURLOPT_URL,  "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
			               curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			               curl_setopt($ch, CURLOPT_POST, 1);
			               curl_setopt($ch, CURLOPT_POSTFIELDS, "user=".$user."&senderID=".$sender."&receipientno=".$number."&msgtxt=".$message."");
			               $buffer = curl_exec($ch);
			   
			               curl_close($ch);
			               json_decode($retVals1);	
			               
					      }

     		          //echo $retVals1 = $this->user_model->signup($ip, $serviceName);
			          header("content-type: application/json");
			          echo $retVals1;
			          exit;
	     	}


/*Sign in Section*/
        public function user_signin_post(){
		$serviceName = 'user_signin';
		//getting posted values
		$ip['email'] = trim($this->input->post('email'));
		$ip['password'] = trim($this->input->post('password'));
		$ipJson = json_encode($ip);

		//validation
		$validation_array = 1;
			$ip_array[] = array("email", $ip['email'], "email", "email_id", "Wrong or Invalid Email address.");
			$ip_array[] = array("password", $ip['password'], "not_null", "password", "Password is empty.");
			$validation_array = $this->validator->validate($ip_array);
			if ($validation_array !=1) {
				$data['message'] = $validation_array;
				$retVals = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
				json_decode($retVals1);
			} 
			else {
				$retVals = $this->User_model->check_signin($ip, $serviceName);
			}
		
		header("content-type: application/json");
		echo $retVals;
		exit;
	}
/*End of Sign in Section*/
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
/* chng_pass Section*/
 public function chng_pass_post()
		{
			$serviceName = 'change password';
			//getting posted values
			$ip['old_pass']    = trim($this->input->post('old_pass'));
			$ip['new_pass']    = trim($this->input->post('new_pass'));
		    $ip['c_pass']      = trim($this->input->post('cn_pass'));
		    $ip['mobile']      = trim($this->input->post('mobile'));
		    $ip['cust_id']     = trim($this->input->post('cust_id'));
		    $ip['user_name']   = trim($this->input->post('user_name'));

			//var_dump($_FILES['user_pic']);exit();
           // print_r($ip); exit();
			if (!null==($ipJson = json_encode($ip)))
                {
               	/*=================GENRAING OTP=====================*/
	            $user="developer22211@indglobal-consulting.com:indglobal123";

			    $sender ="TEST SMS";
			    $number = $ip['mobile'];
			    $name   = "Dear User";//$ip['user_name'];
			    $message="Hi:".$name." Your Password is Changed Successfully You can Login in Few minutes - Getmytruck.com"; 
			    $ipJson = json_encode($ip);
               
			    $chk_pass=$this->User_model->c_pass($ip);
                /*=================ENDING OF GENRAING OTP=====================*/
				}
			
			//validation
			$validation_array = 1;
									
					$ip_array[] = array("old_pass", $ip['old_pass'], "not_null", "old_pass", "Old password is empty.");

					$ip_array[] = array("new_pass", $ip['new_pass'], "not_null", "new_pass", "New password is Empty.");
					
					$ip_array[] = array("c_pass", $ip['c_pass'], "not_null", "c_pass", "Conifirm password is empty.");

					$ip_array[] = array("mobile", $ip['mobile'], "not_null", "mobile", "Mobile number is empty.");

					$ip_array[] = array("cust_id", $ip['cust_id'], "not_null", "cust_id", "customer id is empty.");

					$validation_array = $this->validator->validate($ip_array);
					
					
                    if($ip['new_pass'] != $ip['c_pass'])
					 {
				     	$data['message'] = "Password missmatch.";
				     	$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
                     }

					else if ($validation_array !=1) 
					{
					 	$data['message'] = $validation_array;
					 	$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					} 

					else if ($chk_pass=="True") 
					{
					  $change=$this->User_model->c_pass($ip);
						$data['message'] = "Paasword Changed Successfully";
					 	$retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);

					 /*===============Sending Otp==================*/
                         $ch = curl_init();
			               curl_setopt($ch,CURLOPT_URL,  "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
			               curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			               curl_setopt($ch, CURLOPT_POST, 1);
			               curl_setopt($ch, CURLOPT_POSTFIELDS, "user=".$user."&senderID=".$sender."&receipientno=".$number."&msgtxt=".$message."");
			               $buffer = curl_exec($ch);
			   
			               curl_close($ch);
						  /*===============Sending Otp===================*/
					} 
					else  
					{
					  	//$done_otp=$this->update_model->updt_status_with($ip);
					  	$data['message'] = "Paasword Not Correct";
					  	$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
					  	json_decode($retVals1);
					  
					}

     		         	//echo $retVals1 = $this->signup_model->signup($ip, $serviceName);
			          	header("content-type: application/json");
			            echo $retVals1;
			            exit;
	     	}     



 /*End of chng_pass Section*/
/* Update Section*/

public function update_brief_post()
		{
			$six_digit_random_number = mt_rand(100000, 999999);
			$serviceName = 'update_breif';
			//getting posted values
			$ip['user_id']             = trim($this->input->post('user_id'));
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

					$ip_array[] = array("state_fk", $ip['state_fk'], "not_null", "state_fk", "State is empty.");

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
						$data['details']=$this->User_model->update_brief($ip);
					  	$data['message'] = "Profile Details updated ";
					  	$retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
					} 
        
                         //echo $retVals1 = $this->signup_model->signup($ip,  $serviceName);
			             header("content-type: application/json");
			             echo $retVals1;
			             exit;
	     	}
 

            

/*End of Update Section*/
/* Forget password(Recover) Section*/

     public function recover_post()
		{
			$six_digit_random_number = mt_rand(100000, 999999);
			$serviceName = 'Forgot Password';
			
			$ip['mobile']   = trim($this->input->post('mobile'));
			$ipJson = json_encode($ip);
			if (empty($ip['mobile']))
            {    
            	
                $data['message'] = "Mobile number is null....";
				$retVals1 = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
		         //json_decode($retVals1);	
			}
			    else 
			    {    
			    	 $chkmob=$this->User_model->recover($ip);
                     if($chkmob=="true")
		             {
		             	 $six_digit_random_number = mt_rand(10000000, 99999999);
		             	 //echo $six_digit_random_number;exit()
				         $ipJson = json_encode($ip);
			             $data['message'] = "Password sent to number";
					     $retVals1 = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson); 
					     /*==================Sending Otp Again=====================*/ 
                           $user="developer321322@indglobal-consulting.com:indglobal123";

					    $sender="TEST SMS";
					    $number = $ip['mobile'];
					    $message="Your Temporary Password is :".$six_digit_random_number." To change Your Paasword Login with this Please do not share this password with Anyone - Doctorway"; 
					               
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
                					   'user_pass' => md5($six_digit_random_number),
                					   );
                        $user = $this->User_model->updt_pass($ip,$upuser);
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


/*End of Forget (Recover) Section*/
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
			$ip['user_id'] = trim($this->input->post('user_id'));


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
/*Document Section Starts*/



/*End of Document  Section*/
/*Updating Document Section Section Starts*/

	}
?>

