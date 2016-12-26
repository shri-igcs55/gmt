<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
	/**
	*  signup model
	*/
	class Rating_model extends CI_model
	{
		function rating($input, $serviceName) {
			$ipJson = json_encode($input);
			 	$rating = array(
					    'user_id'                    => $input['user_id'],
					    'to_user_id'                 => $input['to_user_id'],
						'rt_subject'                 => $input['subject'],
						'rt_feadback'                => $input['feadback'],
						'created_datetime'           => Date('Y-m-d H:i:s'),
						'created_ip'                 => $input['created_ip'],
                        'modified_datetime'          => Date('Y-m-d H:i:s'),
                        'modified_ip'                => $input['modified_ip']	
					);
				$query = $this->db->insert('gmt_rating', $rating);
				if ($query == 1) {	
					$last_id = $this->db->insert_id();
					$this->db->select('user_id,
						to_user_id,
						rt_subject,
						rt_feadback');
				    $this->db->from('gmt_rating');
					$this->db->where('rt_id', $last_id );
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