<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
	/**
	*  signup model
	*/
	class Document_upload_model extends CI_model
	{
		
		function document_upload($input, $serviceName) {
			$ipJson = json_encode($input);
			
			 	$document_upload = array(
					    'user_id'                    => $input['user_id'],
					    'trans_doc_type'             => $input['trans_doc_type'],
						'trans_doc_pic_path'         => $input['trans_doc_pic_path'],
						'created_datetime'           => Date('Y-m-d h:i:s'),
						'created_ip'                 => $input['created_ip'],
                        'modified_datetime'          => Date('Y-m-d h:i:s'),
                        'modified_ip'                 => $input['modified_ip']
						
					);
				$query = $this->db->insert('gmt_transporter_doc', $document_upload);

				if ($query == 1) {
					
					$last_id = $this->db->insert_id();
					$this->db->select('user_id,
						trans_doc_type,
						trans_doc_pic_path');
				    $this->db->from('gmt_transporter_doc');
					$this->db->where('trans_doc_id', $last_id );

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