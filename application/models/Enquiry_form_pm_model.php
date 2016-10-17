<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
	/**
	*  signup model
	*/
	class Enquiry_form_pm_model extends CI_model
	{	
		function enquiry_form_pm($input, $serviceName) {
		$ipJson = json_encode($input);		
		// $input['user_type_id']
		$enquiry_data_pm = array(
			
			    'user_id'                    => $input['user_id'],
			    'ord_to_u_type_id_fk'        => 3,
		        'plc_odr_by_fname'           => $input['odr_by_fname'],
		        'plc_odr_by_lname'           => $input['odr_by_lname'],
   				'plc_odr_by_mob'             => $input['odr_by_mob'],
				'from_state'                 => $input['from_state'],
				//'from_city'                  => $input['from_city'],
				//'plc_odr_from_area_location' => $input['from_location'],
				'to_state'                   => $input['to_state'],
				//'to_city'                    => $input['to_city'],
				//'plc_odr_to_area_location'   => $input['to_location'],
				'plc_odr_from_address'       => $input['detailed_from_address'],
				'plc_odr_from_floor'         => $input['shift_floor_from'],
				'plc_odr_from_lift'          => $input['from_lift_facility'],
				'plc_odr_to_address'         => $input['detailed_to_address'],
				'plc_odr_to_floor'           => $input['shift_floor_to'],
				'plc_odr_to_lift'            => $input['to_lift_facility'],
				'sf_id_fk'                   => $input['service_for'],
				'plc_odr_descrp_goods'       => nl2br($input['desc_of_goods']),
				'plc_odr_schedule_date'      => Date('d-m-Y', strtotime($input['sechdule_date'])),
				'created_datetime'           => Date('Y-m-d h:i:s'),
				'created_ip'                 => $input['created_ip'],
                'modified_datetime'          => Date('Y-m-d h:i:s'),
                'modified_ip'                => $input['modified_ip']
						
					);
		$query = $this->db->insert('gmt_place_order', $enquiry_data_pm);
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
						to_city AS t_city,
						mat_id_fk AS material_id,
						vehicle_id_fk AS vehicle_id,
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