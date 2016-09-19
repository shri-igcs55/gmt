<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
	/**
	*  signup model
	*/
	class Enquiry_form_model extends CI_model
	{		
		function enquiry_form($input, $serviceName) {
			$ipJson = json_encode($input);		
			 	$enquiry_data = array(
					    'user_id'                    => $input['user_id'],
					    'trans_cat_id_fk'            => $input['trans_cat_id_fk'],
						'from_state'                 => $input['from_state'],
						'from_city'                  => $input['from_city'],
						'plc_odr_from_area_location' => $input['from_location'],
						'to_state'                   => $input['to_state'],
						'to_city'                    => $input['to_city'],
						'plc_odr_to_area_location'   => $input['to_location'],
						'mat_id_fk'                  => $input['material_type'],
						'plc_odr_item_qty'           => $input['no_of_quantity'],
						'plc_odr_weight'             => $input['weight'],
						'plc_odr_feet'               => $input['feet'],
						'vehicle_id_fk'              => $input['vehicle_type'],
						'plc_odr_item_qty'           => $input['no_of_vehicle'],
						'plc_odr_pick_points'        => $input['pickup_points'],
						'plc_odr_drop_points'        => $input['destination_points'],
						'plc_odr_schedule_date'      => $input['sechdule_date'],
						'created_datetime'           => Date('Y-m-d h:i:s'),
						'created_ip'                 => $input['created_ip'],
                        'modified_datetime'          => Date('Y-m-d h:i:s'),
                        'modified_ip'                => $input['modified_ip']
						
					);
				$query = $this->db->insert('gmt_place_order', $enquiry_data);
				if ($query == 1) {
					$last_id = $this->db->insert_id();
					$this->db->select('user_id,
						from_city,
						to_city,
						mat_id_fk,
						vehicle_id_fk,
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