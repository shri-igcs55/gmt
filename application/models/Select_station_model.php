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
						'created_datetime'       => Date('Y-m-d h:i:s'),
						'created_ip'             => $input['created_ip'],
                        'modified_datetime'      => Date('Y-m-d h:i:s'),
                        'modified_ip'            => $input['modified_ip']
					);
					
					$index = 0;	
					$input['to_city'] = $this->input->post('to_city');
					foreach($this->input->post('from_city') as $form_city):						
						$query =  $this->db->insert('gmt_transporter_station',
							array('source_city_id_fk'=>$form_city,
								'destination_city_id_fk'=>$input['to_city'][$index++],
								'user_id'=>$select_station['user_id'],
								'created_datetime'=>$select_station['created_datetime'],
								'created_ip'=>$select_station['created_ip'],
								'modified_datetime'=>$select_station['modified_datetime'],
								'modified_ip'=>$select_station['modified_ip']
								));
					endforeach;
			
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