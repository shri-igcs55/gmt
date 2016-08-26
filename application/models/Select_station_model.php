<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
	/**
	*  signup model
	*/
	class Select_station_model extends CI_model
	{
		
		function select_station($input, $serviceName) {
			$ipJson = json_encode($input);
			
			 	$select_station = array(
					    'user_id'                => $input['user_id'],
						'source_state_fk'        => $input['from_state'],
						'source_city_id_fk'      => $input['from_city'],
						'destination_state_fk'   => $input['to_state'],
						'destination_city_id_fk' => $input['to_city'],
						'created_datetime'       => Date('Y-m-d h:i:s'),
						'created_ip'             => $input['created_ip'],
                        'modified_datetime'      => Date('Y-m-d h:i:s'),
                        'modified_ip'            => $input['modified_ip']
						
					);
				$query = $this->db->insert('gmt_transporter_station', $select_station);

				if ($query == 1) {
					
					$last_id = $this->db->insert_id();
					$this->db->select('user_id,
						source_state_fk,
						source_city_id_fk,
						destination_state_fk,
						destination_city_id_fk');
				    $this->db->from('gmt_transporter_station');
					$this->db->where('trans_stn_id', $last_id );

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
				function select_station_sec($input, $serviceName) {
			$ipJson = json_encode($input);
			
			 	$select_station_sec = array(
					    'user_id'                => $input['user_id'],
						'source_state_fk'        => $input['from_state2'],
						'source_city_id_fk'      => $input['from_city2'],
						'destination_state_fk'   => $input['to_state2'],
						'destination_city_id_fk' => $input['to_city2'],
						'created_datetime'       => Date('Y-m-d h:i:s'),
						'created_ip'             => $input['created_ip'],
                        'modified_datetime'      => Date('Y-m-d h:i:s'),
                        'modified_ip'            => $input['modified_ip']
						
					);
				$query = $this->db->insert('gmt_transporter_station', $select_station_sec);


				if ($query == 1) {
					
					$last_id = $this->db->insert_id();
					$this->db->select('user_id,
						source_state_fk,
						source_city_id_fk,
						destination_state_fk,
						destination_city_id_fk');
				    $this->db->from('gmt_transporter_station');
					$this->db->where('trans_stn_id', $last_id );

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


				function select_station_thi($input, $serviceName) {
			$ipJson = json_encode($input);
			
			 	$select_station_thi = array(
					    'user_id'                => $input['user_id'],
						'source_state_fk'        => $input['from_state3'],
						'source_city_id_fk'      => $input['from_city3'],
						'destination_state_fk'   => $input['to_state3'],
						'destination_city_id_fk' => $input['to_city3'],
						'created_datetime'       => Date('Y-m-d h:i:s'),
						'created_ip'             => $input['created_ip'],
                        'modified_datetime'      => Date('Y-m-d h:i:s'),
                        'modified_ip'            => $input['modified_ip']
						
					);
				$query = $this->db->insert('gmt_transporter_station', $select_station_thi);
//echo $this->db->last_query();
				//exit;
				if ($query == 1) {
					
					$last_id = $this->db->insert_id();
					$this->db->select('user_id,
						source_state_fk,
						source_city_id_fk,
						destination_state_fk,
						destination_city_id_fk');
				    $this->db->from('gmt_transporter_station');
					$this->db->where('trans_stn_id', $last_id );

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