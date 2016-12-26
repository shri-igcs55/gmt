<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
/**
* Model for signin
*/
class User_model extends CI_model
{
  
  public function get_user_type(){
    $this->db->select('u_type_id AS uid, u_type_name AS utype');
    $this->db->from('gmt_user_type'); 
    $this->db->where('u_parent_id', '7');
    $query = $this->db->get();
    $details = $query->result_array();
    return $details;
  }

  public function get_login_user_type(){
    $this->db->select('u_type_id AS uid, u_type_name AS utype');
    $this->db->from('gmt_user_type'); 
    $this->db->where('u_type_id NOT IN (1,2,7)');
    $query = $this->db->get();
    $details = $query->result_array();
    return $details;
  }

  public function get_comp_type(){
    $this->db->select('comp_type_id AS cid, comp_type AS ctype, comp_status AS cstatus');
    $this->db->from('gmt_company_type'); 
    $this->db->where('comp_status', '1');
    $this->db->order_by('comp_type', 'ASC');
    $query = $this->db->get();
    $details = $query->result_array();
    return $details;
  }
  
  public function get_vehicle_type(){
    $this->db->select('vehicle_id AS vid, vehicle_typ AS vtype, vehicle_status AS vstatus');
    $this->db->from('gmt_vehicle'); 
    $this->db->where('vehicle_status', '1');
    $this->db->order_by('vehicle_typ', 'ASC');
    $query = $this->db->get();
    $details = $query->result_array();
    return $details;
  }
  
  public function get_work_type(){
    $this->db->select('dw_id AS wdid, dw_type AS wdtype, dw_status AS wdstatus');
    $this->db->from('gmt_desc_work'); 
    $this->db->where('dw_status', '1');
    $this->db->order_by('dw_type', 'ASC');
    $query = $this->db->get();
    $details = $query->result_array();
    return $details;
  }

  public function get_material_type(){
    $this->db->select('mat_id AS mid, mat_type AS mtype, mat_status AS mstatus');
    $this->db->from('gmt_material'); 
    $this->db->where('mat_status', '1');
    $this->db->order_by('mat_type', 'ASC');
    $query = $this->db->get();
    $details = $query->result_array();
    return $details;
  }

  public function get_service_type(){
    $this->db->select('sf_id AS sid, sf_type AS stype, sf_status AS sstatus');
    $this->db->from('gmt_service_for'); 
    $this->db->where('sf_status', '1');
    $this->db->order_by('sf_type', 'ASC');
    $query = $this->db->get();
    $details = $query->result_array();
    return $details;
  }

  public function get_designation_list(){
    $this->db->select('desg_id AS id, desg_type AS designation');
    $this->db->from('gmt_designation');
    $this->db->where('desg_status', '1');
    $this->db->order_by('desg_type', 'ASC');
    $query = $this->db->get();
    $details = $query->result_array();
    return $details;
  }

  public function check_signin($input, $serviceName) {
    $ipJson = json_encode($input);
    
    $this->db->select('u.user_id, u.user_rand_id, u.user_email AS email, u.user_mob AS mobile, u.user_status, u.u_type_id, ut.u_parent_id AS user_type_parent, u.pkg_id AS package, u.user_fname AS first_name, u.user_lname AS last_name');
    $this->db->from('gmt_user u');
    $this->db->join('gmt_user_type ut', 'u.u_type_id = ut.u_type_id', 'LEFT');
    $this->db->where('u.user_pass', md5($input['password']));
	$this->db->group_start();
    $this->db->or_where('u.user_email', $input['email_mob']);
    $this->db->or_where('u.user_mob', $input['email_mob']);
	$this->db->group_end();
    // $this->db->where('u.u_type_id', $input['user_type_id']);
    $query = $this->db->get();
    //echo $this->db->last_query($query);exit();
    $resultRows = $query->num_rows();
    // print_r($resultRows);exit();
    $result_row = $query->row();
    $result = $query->result_array();

    // print_r($result[0]);exit();
    if ($resultRows > 0) {
      //print_r($result[0]->pass);exit();
      $this->session->set_userdata('logged_in_user', 
                            array('user_type'           =>$result_row->u_type_id,
                                  'user_type_parent_id' =>$result_row->user_type_parent,
                                  'user_id'             =>$result_row->user_id,
                                  'user_code'           =>$result_row->user_rand_id,
                                  'first_name'          =>$result_row->first_name,
                                  'last_name'           =>$result_row->last_name,
                                  'email'               =>$result_row->email,
                                  'mobile'              =>$result_row->mobile,
                                  'package'             =>$result_row->package,
                                  'user_status'         =>$result_row->user_status
                                  )
                            );
      // $this->session->set_userdata('logged_in_user', $result[0]);
      
      $data = $result[0];
      $data['message'] = 'Login Successfully';
      return $status = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
    }
    else {
      $data['message'] = 'Email or Mobile and Password does not match';
      return $status = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
    }
    // return $status;
  }

  /*Sign Up*/
  public function signup($input, $serviceName) {
    $ipJson = json_encode($input);

    /*if($input['other_company_type']){
      $company_type = $input['other_company_type'];
    }else{
      $company_type = $input['company_type'];
    }*/
    // print_r($input);exit();
    

    $signup_data = array(
      'user_rand_id'     => $input['user_rand_id'],
      'user_fname'       => $input['first_name'],
      'user_lname'       => $input['last_name'],
      'user_firm_name'   => $input['firm_name'],
      'user_email'       => $input['user_email'],
      'user_mob'         => $input['user_mob'],
      'user_pass'        => md5($input['user_pass']),
      'user_otp'         => $input['user_otp'],
      'user_status'      => $input['user_status'],
      'u_type_id'        => $input['user_type'],      
      'user_designation' => $input['designation'],
      'other_user_designation'=>$input['other_designation'],
      // 'pkg_id'           => $input['pkg_id'],
      'created_datetime' => $input['created_datetime'],
      'created_ip'       => $input['created_ip'],   
      'modified_datetime'=> $input['modified_datetime'],
      'modified_ip'      => $input['modified_ip']
    );
    //print_r($signup_data);exit();
  
    $query_signup_data = $this->db->insert('gmt_user', $signup_data);
    $signup_data_last_id = $this->db->insert_id();

    if (!empty($signup_data_last_id)) {
      
      $breif_data = array( 
        'user_id'            => $signup_data_last_id,
        'state_fk'           => $input['state'],
        'district_fk'        => $input['district'],
        'city'               => $input['city'],
        'address1'           => $input['address1'],
        'address2'           => $input['address2'],
        'u_detail_pin'       => $input['pin'],
        'u_detail_pan'       => $input['pan'],
        'comp_type_id_fk'    => $input['company_type'],
        'other_company_type' => $input['other_company_type'],
        'created_datetime'   => $input['created_datetime'],
        'created_ip'         => $input['created_ip'],   
        'modified_datetime'  => $input['modified_datetime'],
        'modified_ip'        => $input['modified_ip']
      );
      // print_r($breif_data);exit();
      $query_breif_data = $this->db->insert('gmt_user_details', $breif_data);
      $breif_data_last_id = $this->db->insert_id();

      if(!empty($breif_data_last_id)){
        
        $this->db->select('u.user_id, u.user_rand_id, u.user_fname AS first_name, 
          u.user_lname AS last_name, u.user_email AS email, u.user_mob AS mobile, 
          u.user_firm_name AS firm_name, u.user_status AS status_id, 
          (select `sta_name` from `gmt_status` where `sta_id` = 1) AS status, 
          u.user_otp AS otp, u.u_type_id AS u_type_id, 
          (select `u_type_name` from `gmt_user_type` where `u_type_id` = '.$input['user_type'].') AS user_type_name, 
          ud.state_fk AS state, ud.district_fk AS district, ud.city AS city_id, ud.address1 AS addr1, ud.address2 AS addr2,
          (select `city` from `gmt_indian_city_list` where `id` = '.$input['city'].') AS city, 
          ud.u_detail_pin AS pincode, ud.u_detail_pan AS pan_num, u.other_user_designation, u.user_designation, ud.other_company_type, ud.comp_type_id_fk');
        $this->db->from('gmt_user u');
        $this->db->join('gmt_user_details ud', 'u.user_id = ud.user_id', 'LEFT');
        $this->db->where('u.user_id', $signup_data_last_id );
        // $this->db->where('ud.user_id', $last_id );

        $detail_last_user = $this->db->get();
        // echo $this->db->last_query($detail_last_user);exit();
        $result_data = $detail_last_user->result_array();
        //print_r($result_data[0]);exit();
        $data = $result_data[0];
        $data['message'] = "Registered Successfully.";
        $status = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
      }else{
        $data['message'] = 'Something went wrong while storing other details (not basic details). Try Again.';
        $status=$this->seekahoo_lib->return_status('Error', $serviceName, $data, $ipJson);
      }
    }
    else {
      $data['message'] = 'Something went wrong while storing baisc details (not other details). Try Again.';
      $status = $this->seekahoo_lib->return_status('Error', $serviceName, $data, $ipJson);
    }
    return $status;
  }

  /* update user */
  public function update_user($input, $serviceName){
    $ipJson = json_encode($input);
    
    $signup_data = array(
      'user_fname'       => $input['first_name'],
      'user_lname'       => $input['last_name'],
      'user_firm_name'   => $input['firm_name'],
      'user_designation' => $input['designation'],
      'modified_datetime'=> $input['modified_datetime'],
      'modified_ip'      => $input['modified_ip']
    );
    //print_r($signup_data);exit();

    $this->db->where('user_id', $input['user_id']);
    $this->db->where('u_type_id', $input['user_type']);
    $updated_info=$this->db->update('gmt_user', $signup_data);
    // echo $this->db->last_query($updated_info);exit();
    $signup_data_last_id = $this->db->affected_rows();
    // print_r($signup_data_last_id);exit();

    if (!empty($signup_data_last_id)) {
      
      $breif_data = array( 
        'user_id'            => $input['user_id'],
        'state_fk'           => $input['state'],
        'district_fk'        => $input['district'],
        'city'               => $input['city'],
        'address1'           => $input['address1'],
        'address2'           => $input['address2'],
        'u_detail_pin'       => $input['pin'],
        'u_detail_pan'       => $input['pan'],
        'comp_type_id_fk'    => $input['company_type'],
        'modified_datetime'  => $input['modified_datetime'],
        'modified_ip'        => $input['modified_ip']
      );
      // print_r($breif_data);exit();
      $this->db->where('user_id', $input['user_id']);
      $query_breif_data = $this->db->update('gmt_user_details', $breif_data);
      $breif_data_last_id = $this->db->affected_rows();
      

      if(!empty($breif_data_last_id)){
        if($input['designation']){
          $desig = $input['designation'];
        }else{
          $desig = '0';
        }

        $this->db->select('u.user_id, u.user_rand_id, u.user_fname AS first_name, 
          u.user_lname AS last_name, u.user_email AS email, u.user_mob AS mobile, 
          u.user_firm_name AS firm_name, 
          IFNULL((select  `desg_type` from `gmt_designation` where `desg_id` = '.$desig.' AND `desg_status` = 1), 0) AS designation, u.u_type_id AS user_type_id, 
          (select `u_type_name` from `gmt_user_type` where `u_type_id` = '.$input['user_type'].') AS user_type_name, 
          ud.state_fk AS state, ud.district_fk AS district, ud.city AS city_id, ud.address1 AS addr1, ud.address2 AS addr2,
          (select `city` from `gmt_indian_city_list` where `id` = '.$input['city'].') AS city, 
          ud.u_detail_pin AS pincode, ud.u_detail_pan AS pan_num');
        $this->db->from('gmt_user u');
        $this->db->join('gmt_user_details ud', 'u.user_id = ud.user_id', 'LEFT');
        $this->db->where('u.user_id', $input['user_id'] );
        
        $detail_last_user = $this->db->get();
        // echo $this->db->last_query($detail_last_user);exit();
        $result_data = $detail_last_user->result_array();
        
        $data = $result_data[0];
        $data['message'] = "User detail updated Successfully.";
        $status = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
      }else{
        $data['message'] = 'Something went wrong while storing Contact details (not basic details). Try Again.';
        $status=$this->seekahoo_lib->return_status('Error', $serviceName, $data, $ipJson);
      }
    }
    else {
      $data['message'] = 'Something went wrong while storing basic details (not Contact details). Try Again.';
      $status = $this->seekahoo_lib->return_status('Error', $serviceName, $data, $ipJson);
    }
    return $status;
  }

  // forgot password
  public function new_otp_pass($input, $serviceName){
    $ipJson = json_encode($input);

    $signup_data = array(
      'user_pass'        => md5($input['six_digit_random_number']),
      'modified_datetime'=> Date('Y-m-d H:i:s'),
      'modified_ip'      => $_SERVER['REMOTE_ADDR']
    );
    
    $this->db->where('user_email', $input['email_mob']);
    $this->db->or_where('user_mob', $input['email_mob']);
    $updated_info=$this->db->update('gmt_user', $signup_data);
    // echo $this->db->last_query($updated_info);exit();
    return $signup_data_last_id = $this->db->affected_rows();
  }

  public function resend_new_otp_pass($input, $serviceName){
    $otpcount = $this->db->select('resend_otp_count')
                         ->from('gmt_user')
                         ->where('user_email', $input['email_mob'])
                         ->or_where('user_mob', $input['email_mob'])
                         ->get();
    $list_group=$otpcount->result_array();
    $ipJson = json_encode($input);

    $signup_data = array(
      'user_pass'        => md5($input['six_digit_random_number']),
      'resend_otp_count' => $list_group[0]['resend_otp_count']+1,
      'modified_datetime'=> Date('Y-m-d H:i:s'),
      'modified_ip'      => $_SERVER['REMOTE_ADDR']
    );
    
    $this->db->where('user_email', $input['email_mob']);
    $this->db->or_where('user_mob', $input['email_mob']);
    $updated_info=$this->db->update('gmt_user', $signup_data);
    // echo $this->db->last_query($updated_info);exit();
    return $signup_data_last_id = $this->db->affected_rows();
  }







    /*User Brief detail*/
    /*breif Up*/

      /*function user_breif($input, $serviceName) {
          $ipJson = json_encode($input);
          //var_dump($ipJson);exit();
          $breif_data = array( 
                            'user_id'            => 8,
                            //'u_detail_name'      => $input['u_detail_name'],
                            'state_fk'           => $input['state'],
                            'city_fk'            => $input['city'],
                            'u_detail_pin'       => $input['pin'],
                            'u_detail_pan'       => $input['pan'],
                            //'u_detail_tin'       => $input['u_detail_tin'],
                            //'u_detail_stax'      => $input['u_detail_stax'] ,
                            'comp_type_id_fk'    => $input['company_type'],
                            //'trans_cat_id_fk'    => $input['trans_cat_id_fk'],
                            'created_datetime'   => $input['created_datetime'],
                            'created_ip'         => $input['created_ip'],   
                            'modified_datetime'  => $input['modified_datetime'],
                            'modified_ip'        => $input['modified_ip']
                             );

            $query = $this->db->insert('gmt_user_details', $breif_data);

            if ($query == 1) {

                $last_id = $this->db->insert_id();
                $flag = "post";
            $add_post['user_id'] = "user_image/". $last_id;
            $add_post['flag'] = $flag;
            if(!empty($_FILES['user_image']['name']))
            {
                $target_file = $this->uploader->upload_image($_FILES['user_image'], $flag,$add_post);
            }
            $this->db->where('u_detail_id',$last_id);
            $this->db->update('gmt_user_details', 
                    array( 'u_detail_profile_org_url' => $target_file['profile_org_url'], 'u_detail_profile_thumb_url' => $target_file['profile_thumb_url']));

                $this->db->select('state_fk,city_fk,u_detail_pin,
                                   u_detail_pan,u_detail_tin,
                                   u_detail_stax,comp_type_id_fk,
                                   trans_cat_id_fk,created_datetime,
                                   created_ip');
                $this->db->from('gmt_user_details');
                $this->db->where('u_detail_id', $last_id );


                $detail_last_user = $this->db->get();
                $resultq = $detail_last_user->result();
                
              //$data['detail'] = $resultq;
              $data = $resultq;
              //$data['id'] = $profile_thumb_url;

              $status = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);

            }
            else {
              $data['message'] = 'Something went wrong while signup. Try Again.';
              $status = $this->seekahoo_lib->return_status('Error', $serviceName, $data, $ipJson);
            }
          return $status;
        }*/
    /*End of user Brief*/

    function check_email($input) 
    {
      // print_r($input['email_mob']);exit();
      if(is_array($input)){
        // if($input['email_mob'] && $input['user_type_id']){
        if($input['email_mob']){
          $email = $input['email_mob'];
          // $utype = $input['user_type_id'];
        }else{
          $email = $input['user_email'];
          // $utype = $input['user_type'];
        }
      }else{
        $email = $input;
        // $utype = $input;
      }
      $this->db->select('*');
      $this->db->from('gmt_user');
      $this->db->where('user_email', $email);
      // $this->db->where('u_type_id', $utype);
      $query = $this->db->get();
      $details = $query->result();    
      $result = $query->num_rows();
      if ($result > 0 ){
        //print_r($details); die();
        return $details;
      }
      return false;
    }
 
    function check_mob($input) 
    {
      if(is_array($input)){
        // if($input['email_mob'] && $input['user_type_id']){
        if($input['email_mob']){
          $mob = $input['email_mob'];
          // $utype = $input['user_type_id'];
        }else{
          $mob = $input['user_mob'];
          // $utype = $input['user_type'];
        }
      }else{
        $mob = $input;
        // $utype = $input;
      }
      $this->db->select('*');
      $this->db->from('gmt_user');
      $this->db->where('user_mob', $mob);
      // $this->db->where('u_type_id', $utype);
      $query = $this->db->get();
      $details = $query->result(); 
      //echo $this->db->last_query();   
      $result = $query->num_rows();
      if ($result > 0 ){
        return $details;
      }
      return false;
    }

    function check_email_reg($input) 
    {
      $this->db->select('*');
      $this->db->from('gmt_user');
      $this->db->where('user_email', $input['user_email']);
      $this->db->where('u_type_id', $input['user_type']);
      $query = $this->db->get();
      $details = $query->result();    
      $result = $query->num_rows();
      if ($result > 0 ){
        return $details;
      }
      return false;
    }
 
    function check_mob_reg($input) 
    {
      
      $this->db->select('*');
      $this->db->from('gmt_user');
      $this->db->where('user_mob', $input['user_mob']);
      $this->db->where('u_type_id', $input['user_type']);
      $query = $this->db->get();
      $details = $query->result(); 
      $result = $query->num_rows();
      if ($result > 0 ){
        return $details;
      }
      return false;
    }


    /*Verification Section Starts*/
    function check_otp($input) 
    {
      //print_r($input);
      //exit;
      $ipJson = json_encode($input);
      
      $this->db->select('*');
      $this->db->from('gmt_user');
      $this->db->where('user_id',$input['user_id'] );
      $this->db->where('user_otp', $input['v_code']);
      $query = $this->db->get();
      $details = $query->result();
      if ($details > 0 ){
        return true;
      }
      return false; 
    }
    
    /*Resend OTP Updating OTP Section */
    function update_status($up_status,$code,$input)
    {
      $this->db->where('user_otp', $code);
      $this->db->where('user_id', $input['user_id']);
      $ins=$this->db->update('gmt_user', $up_status);

      $this->session->unset_userdata('logged_in_user');
      $this->db->select('u.user_id, u.user_rand_id, u.user_email AS email, u.user_mob AS mobile, u.user_status, u.u_type_id, ut.u_parent_id AS user_type_parent, u.pkg_id AS package, u.user_fname AS first_name, u.user_lname AS last_name');
      $this->db->from('gmt_user u');
      $this->db->join('gmt_user_type ut', 'u.u_type_id = ut.u_type_id', 'LEFT');
      $this->db->where('u.user_email', $input['email']);
      $this->db->where('u.user_mob', $input['mobile']);
      $this->db->where('u.user_id', $input['user_id']);
      // $this->db->where('u.u_type_id', $input['user_type_id']);
      $query = $this->db->get();
      // echo $this->db->last_query($query); 
      $resultRows = $query->num_rows();
      $result_row = $query->row();
      $result = $query->result_array();

      if ($resultRows > 0) {
        
        $this->session->set_userdata('logged_in_user', 
                              array('user_type'           =>$result_row->u_type_id,
                                    'user_type_parent_id' =>$result_row->user_type_parent,
                                    'user_id'             =>$result_row->user_id,
                                    'user_code'           =>$result_row->user_rand_id,
                                    'first_name'          =>$result_row->first_name,
                                    'last_name'           =>$result_row->last_name,
                                    'email'               =>$result_row->email,
                                    'mobile'              =>$result_row->mobile,
                                    'package'             =>$result_row->package,
                                    'user_status'         =>$result_row->user_status
                                    )
                              );
        // $this->session->set_userdata('logged_in_user', $result[0]);
        
        $data = $result[0];
      }
      return $ins;
      // return $data;
    }

    function check_login_mob_for_otp($input) 
    {
      //echo $email;die();
      $this->db->select('*');
      $this->db->from('gmt_user');
      $this->db->where('user_id', $input['user_id']);
      $this->db->where('user_email', $input['email']);
      $this->db->where('user_mob', $input['mobile']);
      $query = $this->db->get();
      $details = $query->result(); 
      //echo $this->db->last_query();   
      $result = $query->num_rows();
      if ($result > 0 ){
        return true;
      }
      return false;
    }
    
    /*update resended OTP*/
    function updt_login_otp ($input,$six_digit_random_number)
    {
      $otpcount = $this->db->select('login_resend_otp_count')
                         ->from('gmt_user')
                         ->where('user_email', $input['email'])
                         ->or_where('user_mob', $input['mobile'])
                         ->get();
      $list_group=$otpcount->result_array();
      // print_r($list_group[0]['login_resend_otp_count']);exit();
      $upuser = array( 'user_otp' => $six_digit_random_number,
                       'user_status' => 1,
                       'login_resend_otp_count' => $list_group[0]['login_resend_otp_count']+1);
      
      $this->db->where('user_id', $input['user_id']);
      $this->db->where('user_email', $input['email']);
      $this->db->where('user_mob', $input['mobile']);
      $ins=$this->db->update('gmt_user', $upuser);
      //echo $this->db->last_query($ins);
      
      return $ins;
    }
    /*End of Otp Section*/

    /*Change pass Section Starts*/
    function c_pass($input)
    {
      $ipJson = json_encode($input);
      $this->db->select('*');
      $this->db->from('gmt_user');
      $this->db->where('user_id', $input['user_id']);
      $this->db->where('user_pass', md5($input['old_pass']));
      $query = $this->db->get();
      $details = $query->result();    
      if ($details)
      {
        $ipJson = json_encode($input);
        $up_status = array('user_pass' => md5($input['new_pass']));
        $this->db->where('user_id',$input['user_id']);
        $ins=$this->db->update('gmt_user', $up_status);
        return True;
      }
      else
      {  
        return False;
      }
    }
    /*End of Change pass Section*/

    /*Mobile number change option*/
    function update_mob($input,$upmob)
    {
       $ipJson = json_encode($input);

       $this->db->where('user_id',$input['user_id']);
       $ins=$this->db->update('gmt_user', $upmob);
    }
    /*End of mobile number change*/

    /*Update Section Starts.*/
    function update_brief($input)
    {

      $ipJson = json_encode($input);

      $this->db->select('*');
      $this->db->from('gmt_user_details');
      $ins=$this->db->where('user_id', $input['user_id']);
      $query = $this->db->get();
      $details = $query->result();    
      $result =  $query->num_rows();
     
              
      if ($result > 0 )
      { 
        /*Updating*/
        $ipJson = json_encode($input);
        $up_breifly = array( 
                    'user_id'            => $input['user_id'],
                    'u_detail_name'      => $input['u_detail_name'],
                    'u_detail_firm_name' => $input['u_detail_firm_name'],
                    'state_fk'           => $input['state_fk'],
                    'city_fk'            => $input['city_fk'],
                    'u_detail_pin'       => $input['u_detail_pin'],
                    'u_detail_pan'       => $input['u_detail_pan'],
                    'u_detail_tin'       => $input['u_detail_tin'],
                    'u_detail_stax'      => $input['u_detail_stax'] ,
                    'comp_type_id_fk'    => $input['comp_type_id_fk'],
                    'trans_cat_id_fk'    => $input['trans_cat_id_fk'],
                    'modified_datetime'  => $input['modified_datetime'],
                    'modified_ip'        => $input['modified_ip']
                     );

        $this->db->where('user_id',$input['user_id']);
        $ins=$this->db->update('gmt_user_details', $up_breifly);

        return $up_breifly;
      
      }
      else
      {  
       $ipJson = json_encode($input);
       $breif_data = array( 
                    'user_id'            => $input['user_id'],
                    'u_detail_name'      => $input['u_detail_name'],
                    'u_detail_firm_name' => $input['u_detail_firm_name'],
                    'state_fk'           => $input['state_fk'],
                    'city_fk'            => $input['city_fk'],
                    'u_detail_pin'       => $input['u_detail_pin'],
                    'u_detail_pan'       => $input['u_detail_pan'],
                    'u_detail_tin'       => $input['u_detail_tin'],
                    'u_detail_stax'      => $input['u_detail_stax'] ,
                    'comp_type_id_fk'    => $input['comp_type_id_fk'],
                    'trans_cat_id_fk'    => $input['trans_cat_id_fk'],
                    'created_datetime'   => $input['created_datetime'],
                    'created_ip'         => $input['created_ip'] 
                           );

        $query = $this->db->insert('gmt_user_details', $breif_data);
        return $breif_data;

      }     
    }
      
    
    function check_mob_u($input) 
    {
      //echo $email;die();
      $ipJson = json_encode($input);
      //var_dump($input);
      $this->db->select('*');
      $this->db->from('user_reg');
      $this->db->where('phone_number', $input['mobile']);
      $query = $this->db->get();
      $details = $query->result();

      //var_dump($details);  exit();
      $result = $query->num_rows();
      if ($result > 1 )
      {
        //print_r($details); die();
        return $details;
      }
      return false;
    }


    function check_email_u($input) 
    {
      //echo $email;die();
      $ipJson = json_encode($input);
      $this->db->select('*');
      $this->db->from('user_reg');
      $this->db->where('email', $input['email']);
      $query = $this->db->get();
      $details = $query->result();
      $result = $query->num_rows();
      if ($result > 1 )
      {
        //print_r($details); die();
        return $details;
      }
      return false;
    }


    /*$uploadPhoto,*/
    function add_photo($ip){
      $serviceName = 'add_media';

      $ipJson = json_encode($ip);
      //echo $ipJson;exit();
      if ($ip['flag'] == 'post') {
          $photoArray = array(
              'media_type' => $uploadPhoto[0]['type'],
              'media_thumb_url' => $uploadPhoto[0]['thumbnail_url'],
              'media_org_url' => $uploadPhoto[0]['photo_url'],
              'media_created_date' => Date('Y-m-d H:i:s'),
              'media_modified_date' => Date('Y-m-d H:i:s')
          );
          $photoIns = $this->db->insert('media', $photoArray);
      } else { 
          //print_r($uploadPhoto[0]['thumbnail_url']);
          $photoArray = array(
              'profile_thumb_url' => $uploadPhoto[0]['thumbnail_url'],
              'profile_org_url'   => $uploadPhoto[0]['photo_url'],
              'reg_date_time'     => Date('Y-m-d H:i:s')
          );
          $this->db->where('id', $ip['user_id']);
          $photoIns = $this->db->update('signup', $photoArray);
      }
      if ($photoIns) {
          $mediaId = $this->db->insert_id();
          $uploadPhoto[0]['photo_id'] = $mediaId;
      } else {
          return false;
      }
      return $uploadPhoto;
    }
    /*End of Update Section*/

    /* forget(Recover) Section Starts*/
    function recover($input) 
    {
        $ipJson = json_encode($input);
        //var_dump($ipJson);exit();
        $this->db->select('*');
        $this->db->from('gmt_user');
        $this->db->where('user_mob',$input['mobile'] );
        $query = $this->db->get();
        $details = $query->result();
        //echo $this->db->last_query();
        $result = $query->num_rows();
        if ($result > 0 )
        {
          //print_r($details); die();
          return true;
        }
        return false; 
    }

    function updt_pass($input,$upuser)
    {
        $this->db->where('user_mob',$input['mobile']);
        $ins=$this->db->update('gmt_user', $upuser);
        //echo $this->db->last_query($ins);
    }
    /*End of Forget (Recover) Section*/

    /*View details Section Starts*/
    public function view_profile($input)
    {
      $ipJson = json_encode($input);
      $this->db->select('a.u_detail_name, a.u_detail_firm_name, a.state_fk, d.city_name, a.u_detail_pin, a.u_detail_pan, a.u_detail_tin, a.u_detail_stax, e.comp_type, a.trans_cat_id_fk, b.user_email, b.user_mob, c.u_type_name');
      $this->db->from('gmt_user_details a'); 
      $this->db->join('gmt_user b', 'a.user_id = b.user_id', 'left');
      $this->db->join('gmt_user_type c', 'b.u_type_id = c.u_type_id', 'left');
      $this->db->join('gmt_statelist d', 'a.city_fk = d.city_id', 'left');
      $this->db->join('gmt_company_type e', 'a.comp_type_id_fk = e.comp_type_id', 'left');
      $this->db->join('gmt_transporter_cat f', 'a.trans_cat_id_fk = f.trans_cat_id', 'left');
      $this->db->where('a.user_id',$input['user_id']);
      $query = $this->db->get();
      //echo $this->db->last_query();

      $details = $query->result();
      //print_r($details);
        //exit();
      return $details;
    }

  }

?>