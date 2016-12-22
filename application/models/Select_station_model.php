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
					// $input['to_city'] = $this->input->post('to_city');
					foreach($input['from_city'] as $form_city):						
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

					$this->db->select('b.state AS from_state, CONCAT(b.city, ", ", b.district) AS from_city, b.id AS from_city_id, c.state AS to_state, CONCAT(c.city, ", ", c.district) AS to_city, c.id AS to_city_id');
				  	$this->db->from('gmt_transporter_station a'); 
				    $this->db->join('gmt_indian_city_list b', 'a.source_city_id_fk=b.id', 'left');
				    $this->db->join('gmt_indian_city_list c', 'a.destination_city_id_fk=c.id', 'left');
				  	$this->db->where('a.user_id',$input['user_id']);
					$this->db->order_by("trans_stn_id", "desc");
            		$this->db->limit(count($input['to_city']));
				  	$query = $this->db->get();
				  	//echo $this->db->last_query();

				  	$data = $query->result();
					
					$status = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);

				}
				else {
					$data['message'] = 'Something went wrong while saving station. Try Again.';
					$status = $this->seekahoo_lib->return_status('Error', $serviceName, $data, $ipJson);
				}
			return $status;
		}
	}
	


?>