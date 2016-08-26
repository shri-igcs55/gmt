<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Model for signin
*/
class User_model extends CI_model
{
  
  public function check_signin($input, $serviceName) {
      $ipJson = json_encode($input);
      
      $this->db->select('user_id,user_rand_id,user_email,user_mob,user_status,u_type_id,trans_cat_id,pkg_id');
      $this->db->from('gmt_user');
      $this->db->where('user_email', $input['email']);
      $this->db->where('user_pass', md5($input['password']));
      $query = $this->db->get();
      $resultRows = $query->num_rows();
      //print_r($resultRows);exit();
      $result = $query->result();
      
      if ($resultRows > 0) {
        //print_r($result[0]->pass);exit();
        $data['details'] = $result;
        $data['message'] = 'Login Successfully';
        $status = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
      }
      else {
        $data['message'] = 'Email address and Password does not match';
        $status = $this->seekahoo_lib->return_status('error', $serviceName, $data, $ipJson);
      }
    return $status;
  }

/*Sign Up*/

  function signup($input, $serviceName) {
      $ipJson = json_encode($input);
      
        $signup_data = array(
                          'user_rand_id'     => $input['user_rand_id'],
                          'user_email'       => $input['user_email'],
                          'user_mob'         => $input['user_mob'],
                          'user_pass'        => md5($input['user_pass']),
                          'user_otp'         => $input['user_otp'],
                          'user_status'      => $input['user_status'],
                          'u_type_id'        => $input['u_type_id'],
                          'trans_cat_id'     => $input['trans_cat_id'] ,
                          'pkg_id'           => $input['pkg_id'],
                          'created_datetime' => $input['created_datetime'],
                          'created_ip'       => $input['created_ip']
                          
                            );

        $query = $this->db->insert('gmt_user', $signup_data);

        if ($query == 1) {
          
            $last_id = $this->db->insert_id();
            $this->db->select('user_email,
            user_mob,
            user_status');
            $this->db->from('gmt_user');
            $this->db->where('user_id', $last_id );

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
    }


/*User Brief detail*/
/*breif Up*/

  /*function user_breif($input, $serviceName) {
      $ipJson = json_encode($input);
      //var_dump($ipJson);exit();
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
                        'created_ip'         => $input['created_ip'],   
                        'modified_datetime'  => $input['modified_datetime'],
                        'modified_ip'        => $input['modified_ip']
                         );

        $query = $this->db->insert('gmt_user_details', $breif_data);

        if ($query == 1) {

            $last_id = $this->db->insert_id();
            $this->db->select('u_detail_name,u_detail_firm_name,
                               state_fk,city_fk,u_detail_pin,
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
      //echo $email;die();
      $this->db->select('*');
      $this->db->from('gmt_user');
      $this->db->where('user_email', $input['user_email']);
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
      //echo $email;die();
      $this->db->select('*');
      $this->db->from('gmt_user');
      $this->db->where('user_mob', $input['user_mob']);
      $query = $this->db->get();
      $details = $query->result(); 
      //echo $this->db->last_query();   
      $result = $query->num_rows();
      if ($result > 0 ){
        return $details;
      }
      return false;
    }

/*Verification Section Starts*/


function check_otp($input) 
    {
      $ipJson = json_encode($input);
      
      $this->db->select('*');
      $this->db->from('gmt_user');
      $this->db->where('user_mob',$input['mobile_num'] );
      $this->db->where('user_otp', $input['v_code']);
      $query = $this->db->get();
      $details = $query->result();
          //echo $this->db->last_query();
      $result = $query->num_rows();
      if ($result > 0 ){
        //print_r($details); die();
        return true;

      }
      return false; 
    }
/*Resend OTP Updating OTP Section */
    function update_status($up_status,$code)
    {
        $this->db->where('user_otp', $code);
          $ins=$this->db->update('gmt_user', $up_status);
          return $ins;
    }
 function check_mob_for_otp($input) 
    {
      //echo $email;die();
      $this->db->select('*');
      $this->db->from('gmt_user');
      $this->db->where('user_mob', $input['user_mob']);
      $query = $this->db->get();
      $details = $query->result(); 
      //echo $this->db->last_query();   
      $result = $query->num_rows();
      if ($result > 0 ){
        return true;
      }
      return false;
    }
/*End Resend OTP Updating OTP Section */  

/*Check mobnum exsist function or not Is also here*/

    function updt_otp ($input,$upuser)
      {
        $this->db->where('user_mob',$input['mobile']);
        $ins=$this->db->update('gmt_user', $upuser);
        //echo $this->db->last_query($ins);
      }

/*End of Otp Section*/
/*Change pass Section Starts*/

  function c_pass($input)
    {
            $ipJson = json_encode($input);
            $this->db->select('*');
            $this->db->from('gmt_user');
            $this->db->where('user_rand_id', $input['cust_id']);
            $ins=$this->db->where('user_pass', md5($input['old_pass']));
            $query = $this->db->get();
            $details = $query->result();    
            $result =  $query->num_rows();
                         
            if ($result > 0 )
          {
            $ipJson = json_encode($input);
            $up_status = array(
                              'user_pass' => md5($input['new_pass']) 
                              );
            $this->db->where('user_rand_id',$input['cust_id']);
            $ins=$this->db->update('gmt_user', $up_status);
               return True;
          }
          else
          {  
            return False;
          }
      
  }

    
     


    /*Mobile number change option*/
    function update_mob($input,$upmob)
    {
       $ipJson = json_encode($input);

       $this->db->where('user_id',$input['user_id']);
       $ins=$this->db->update('gmt_user', $upmob);
       
    }
    /*End of mobile number change*/

/*End of Change pass Section*/
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
          {/*Updating*/
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
        function add_photo($ip) {
            $serviceName = 'add_media';

            $ipJson = json_encode($ip);
            //echo $ipJson;exit();
            if ($ip['flag'] == 'post') {
                $photoArray = array(
                    'media_type' => $uploadPhoto[0]['type'],
                    'media_thumb_url' => $uploadPhoto[0]['thumbnail_url'],
                    'media_org_url' => $uploadPhoto[0]['photo_url'],
                    'media_created_date' => date('Y-m-d H:i:s'),
                    'media_modified_date' => date('Y-m-d H:i:s')
                );
                $photoIns = $this->db->insert('media', $photoArray);
            } else { 
                //print_r($uploadPhoto[0]['thumbnail_url']);
                $photoArray = array(
                    'profile_thumb_url' => $uploadPhoto[0]['thumbnail_url'],
                    'profile_org_url'   => $uploadPhoto[0]['photo_url'],
                    'reg_date_time'     => date('Y-m-d H:i:s')
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



    function updt_pass ($input,$upuser)
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





/*End of View details Section*/
/*Favrourite Submission Section Starts*/








/*End of Favrourite Submission Section*/
/*Top Hospitals Section Starts*/










/*End of Top Hospitals Section*/
/* Section Starts*/


    
    




}

?>
