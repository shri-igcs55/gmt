<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
	/**
	*  signup model
	*/
	class Document_upload_model extends CI_model
	{	
		function document_upload($input, $doc, $serviceName) {
			$ipJson = json_encode($input);
			// print_r($input); print_r($doc[0]); exit();
		 	$document_upload = array(
				    'user_id'           	=> $input['user_id'],
				    'trans_doc_name'    	=> $input['doc_name'],
					'trans_doc_path'		=> $doc[0]['profile_org_url'],
					'trans_doc_thumb_url'	=> $doc[0]['profile_thumb_url'],
					'created_datetime'  	=> Date('Y-m-d h:i:s'),
					'created_ip'        	=> $_SERVER['REMOTE_ADDR'],
                    'modified_datetime' 	=> Date('Y-m-d h:i:s'),
                    'modified_ip'       	=> $_SERVER['REMOTE_ADDR']
				);
			$query = $this->db->insert('gmt_transporter_doc', $document_upload);
			if ($query == 1) {
				$last_id = $this->db->insert_id();
				$this->db->select('user_id,
					trans_doc_name,
					trans_doc_path,
					trans_doc_thumb_url');
			    $this->db->from('gmt_transporter_doc');
				$this->db->where('trans_doc_id', $last_id );
			    $detail_last_user = $this->db->get();
			    $status = $detail_last_user->result_array();
				//$data['detail'] = $resultq;
				// $data = $resultq;
				//$data['id'] = $profile_thumb_url;
				// $status = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
			}
			else {
				$data['message'] = 'Something went wrong while signup. Try Again.';
				$status = $this->seekahoo_lib->return_status('Error', $serviceName, $data, $ipJson);
			}
			return $status;
		}

		public function get_uploaded_document($last_id){
			$ipJson = json_encode($last_id);
			// print_r($last_id['user_id']);exit();
			$this->db->select('trans_doc_id,
							user_id,
							trans_doc_name,
							trans_doc_path,
							trans_doc_thumb_url');
		    $this->db->from('gmt_transporter_doc');
			$this->db->where('user_id', $last_id['user_id'] );
			$this->db->where('del_status', 1);
			$this->db->order_by('trans_doc_id', 'desc');
		    $detail_last_user = $this->db->get();
		    $status = $detail_last_user->result_array();
		    return $status;
		}

	}
?>