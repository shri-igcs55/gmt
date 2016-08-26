<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
	/**
	*  signup model
	*/
	class Enquiry_form_crain_model extends CI_model
	{
		
		function enquiry_form_crain($input, $serviceName) {
			$ipJson = json_encode($input);
			
			 	$enquiry_data_crain = array(
					    'user_id'                    => $input['user_id'],
					    'u_type_id_fk'               => $input['user_type_id'],
						'from_state'                 => $input['state'],
						'from_city'                  => $input['city'],
						'plc_odr_from_area_location' => $input['location'],
						'plc_odr_from_address'       => $input['address'],
						'plc_odr_weight'             => $input['weight'],
						'plc_odr_descrp_goods'       => $input['desc_of_goods'],
						'plc_odr_schedule_date'      => $input['sechdule_date'],
						'created_datetime'           => Date('Y-m-d h:i:s'),
						'created_ip'                 => $input['created_ip'],
                        'modified_datetime'          => Date('Y-m-d h:i:s'),
                        'modified_ip'                => $input['modified_ip']
						
					);
				$query = $this->db->insert('gmt_place_order', $enquiry_data_crain);

				if ($query == 1) {
					
					$last_id = $this->db->insert_id();
					$this->db->select('user_id,
						from_city,
						plc_odr_to_area_location,
						plc_odr_from_address,	
						plc_odr_schedule_date');
				    $this->db->from('gmt_place_order');
					$this->db->where('plc_odr_id', $last_id );

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