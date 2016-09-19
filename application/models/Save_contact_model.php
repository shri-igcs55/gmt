<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
	/**
	*  signup model
	*/
	class Save_contact_model extends CI_model
	{		
		function save_contact($input, $serviceName) {
			$ipJson = json_encode($input);		
			$save_contact = array(
				    'user_id'                    => $input['user_id'],
				    'reg_id_fk'                  => $input['reg_id_fk'],
					'cont_group_name'            => $input['cont_group_name'],
					'created_datetime'           => Date('Y-m-d h:i:s'),
					'created_ip'                 => $input['created_ip'],
                    'modified_datetime'          => Date('Y-m-d h:i:s'),
                    'modified_ip'                => $input['modified_ip']	
					);
			$query = $this->db->insert('gmt_contact', $save_contact);
			if ($query == 1) {					
				$last_id = $this->db->insert_id();
				$this->db->select('user_id,
						reg_id_fk,
						cont_group_name');
				$this->db->from('gmt_contact');
				$this->db->where('cont_id', $last_id );
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

	}
	


?>