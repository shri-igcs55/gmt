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
					    'ord_to_u_type_id_fk'        => 6,
				        'plc_odr_by_fname'           => $input['odr_by_fname'],
				        'plc_odr_by_lname'           => $input['odr_by_lname'],
	       				'plc_odr_by_mob'             => $input['contact'],
						'from_state'                 => $input['from_state'],
						//'from_city'                  => $input['from_city'],
						//'plc_odr_from_area_location' => $input['from_location'],
						'plc_odr_from_address'       => $input['from_address'],
						'to_state'                 	 => $input['to_state'],
						//'to_city'                  	 => $input['to_city'],
						//'plc_odr_to_area_location' 	 => $input['to_location'],
						'plc_odr_to_address'       	 => $input['to_address'],
						'plc_odr_weight'             => $input['weight'],
						//'dw_type'				     => $input['desc_of_goods'],
						'dw_id_fk'				     => $input['desc_of_goods'],
						'other_work_desc'			 => $input['other_desc_of_work'],
						'plc_odr_schedule_date'      => Date('d-m-Y', strtotime($input['sechdule_date'])),
						'created_datetime'           => Date('Y-m-d H:i:s'),
						'created_ip'                 => $input['created_ip'],
                        'modified_datetime'          => Date('Y-m-d H:i:s'),
                        'modified_ip'                => $input['modified_ip']
						
					);
				$query = $this->db->insert('gmt_place_order', $enquiry_data_crain);
				if ($query == 1) {
					$last_id = $this->db->insert_id();
					$this->db->insert('gmt_order_location',
							array('plc_odr_id'=>$last_id,
								'orl_from_city_id'=>$input['from_city'],
								'orl_to_city_id'=>$input['to_city'],
								'orl_pickup_location'=>$input['from_location'],
								'orl_drop_location'=>$input['to_location']));	
								
					$this->db->select('plc_odr_id AS order_id, user_id AS uid,
						from_city AS f_city,
						plc_odr_from_area_location AS f_location,
						plc_odr_from_address AS f_address,
						to_city AS t_city,
						plc_odr_to_area_location AS t_location,
						plc_odr_to_address AS t_address,	
						plc_odr_schedule_date AS schedule_date');
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