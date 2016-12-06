<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Model for contact us
*/
class contact_us_model extends CI_model
{

	public function contact_msg($input, $serviceName){
		$ipJson = json_encode($input);
        
		$contatus_data = array(
		  'full_name'        => $input['full_name'],
		  'user_email'       => $input['user_email'],
		  'user_mob'         => $input['user_mob'],
		  'user_msg'		 => $input['c_msg'],
		  'created_datetime' => $input['created_datetime'],
		  'created_ip'       => $input['created_ip']
		);
		
		$query_contact_data = $this->db->insert('gmt_contact_us', $contatus_data);
		if($query_contact_data){
			$data['message'] = "Contact Message sent Successfully.";
	        $status = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
		}else{
			$data['message'] = 'Something went wrong while storing other details (not basic details). Try Again.';
			$status=$this->seekahoo_lib->return_status('Error', $serviceName, $data, $ipJson);
		}
		return $status;
	}

}