<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
	date_default_timezone_set('Asia/Kolkata');
	/**
	*  save contact model
	*/
	class Save_contact_model extends CI_model
	{		
		public function save_contact($input, $serviceName){
			$ipJson = json_encode($input);		
			$save_contact = array(
				    'user_id'           => $input['user_id'],
				    'cont_name'			=> ucwords($input['cont_name']),
				    'cont_email'		=> $input['cont_email'],
				    'cont_mob'			=> $input['cont_number'],
				    'reg_id_fk'         => $input['reg_id_fk'],
					'cont_group_id'   	=> $input['cont_group_id'],
					'created_datetime'  => Date('Y-m-d h:i:s'),
					'created_ip'        => $_SERVER['REMOTE_ADDR'],
                    'modified_datetime'	=> Date('Y-m-d h:i:s'),
                    'modified_ip'       => $_SERVER['REMOTE_ADDR']	
				);
			$query = $this->db->insert('gmt_contact', $save_contact);
			$last_id = $this->db->insert_id();
					
			if ($query == 1) {
				$contact_count  = $this->db->select('cont_group_id')
										->from('gmt_contact')
										->where('cont_group_id', $input['cont_group_id'])
										->get();
				$one_group_count = count($contact_count->result_array());
				// print_r(count($cont_count->result_array()));exit();
				$save_cont_count = array(
					'cgrp_cont_count' => $one_group_count
				);
				$this->db->where('cgrp_id', $input['cont_group_id']);
				$update_count = $this->db->update('gmt_contact_group',$save_cont_count);
				if($update_count){
					$this->db->select('gmt_contact.user_id,
										gmt_contact.cont_name,
										gmt_contact.cont_email,
										gmt_contact.cont_mob,
										gmt_contact.reg_id_fk,
										gmt_contact_group.cgrp_group_name AS group_name,
										gmt_contact_group.cgrp_id AS group_id,
										gmt_contact_group.cgrp_cont_count AS grp_contact_count');
					$this->db->from('gmt_contact');
					$this->db->join('gmt_contact_group','gmt_contact.cont_group_id = gmt_contact_group.cgrp_id');
					$this->db->where('cont_id', $last_id );
					$detail_last_user = $this->db->get();
				    // echo $this->db->last_query($detail_last_user);exit();
				    
				    return $data = $detail_last_user->result_array();
				}
			}
			else {
				$data['message'] = 'Something went wrong while signup. Try Again.';
				$status =$this->seekahoo_lib->return_status('Error', $serviceName, $data, $ipJson);
			}
			return $status;
		}

		public function view_contact($input, $serviceName){
			$ipJson = json_encode($input);		
			$this->db->select('gmt_contact.cont_id, gmt_contact.user_id, gmt_contact.cont_name, gmt_contact.cont_email, gmt_contact.cont_mob, gmt_contact.reg_id_fk, gmt_contact_group.cgrp_group_name AS group_name, gmt_contact_group.cgrp_id AS group_id');
			$this->db->from('gmt_contact');
			$this->db->join('gmt_contact_group','gmt_contact_group.cgrp_id = gmt_contact.cont_group_id');
			$this->db->where('gmt_contact.user_id', $input['user_id'] );
			$this->db->where('gmt_contact.del_status', 1);
		    $detail_last_user = $this->db->get();
		    return $data = $detail_last_user->result_array();
		}

		public function delete_contact($value, $serviceName){
			$ipJson = json_encode($value);
			$cont_id = explode(',', $value['contact_id']);
			// print_r($cont_id);
			$doc_del_data = array(
		        'del_status' => '2',
		        'modified_datetime'  => Date('Y-m-d h:i:s'),
		        'modified_ip'        => $_SERVER['REMOTE_ADDR']
		    );
			    
			$this->db->where_in('cont_id', $cont_id);
			$this->db->where('user_id',$value['user_id']);
			$updated_info = $this->db->update('gmt_contact', $doc_del_data);
			// echo $this->db->last_query($updated_info);exit();

			return $doc_del_data_last_id = $this->db->affected_rows();
		}
	
		public function save_group($input, $serviceName){
			$ipJson = json_encode($input);		
			$save_contact = array(
				    'user_id'           => $input['user_id'],
				    'cont_group_name'   => ucwords($input['cont_group_name']),
					'created_datetime'  => Date('Y-m-d h:i:s'),
					'created_ip'        => $_SERVER['REMOTE_ADDR'],
                    'modified_datetime'	=> Date('Y-m-d h:i:s'),
                    'modified_ip'       => $_SERVER['REMOTE_ADDR']	
				);
			$query = $this->db->insert('gmt_contact', $save_contact);
			if ($query == 1) {
				$last_id = $this->db->insert_id();
				$this->db->select('user_id,
									cont_name,
									cont_email,
									cont_mob,
									reg_id_fk,
									cont_group_name');
				$this->db->from('gmt_contact');
				$this->db->where('cont_id', $last_id );
			    $detail_last_user = $this->db->get();
			    
			    return $data = $detail_last_user->result_array();
			}
			else {
				$data['message'] = 'Something went wrong while signup. Try Again.';
				$status =$this->seekahoo_lib->return_status('Error', $serviceName, $data, $ipJson);
			}
			return $status;
		}

		public function view_contact_group($value, $serviceName){
			$ipJson = json_encode($value);

			$view_group  = $this->db->select('user_id, cgrp_group_name AS group_name, cgrp_id AS group_id')
									->from('gmt_contact_group')
									->where('user_id', $value['user_id'])
									->where('cgrp_del_status', 1)
									->get();
			return $list_group =$view_group->result_array();
			// print_r($list_group);exit();
		}

		public function delete_group($value, $serviceName){
			$ipJson = json_encode($value);
			$cont_id = explode(',', $value['group_id']);
			// print_r($cont_id);
			$doc_del_data = array(
		        'cgrp_del_status' 	=> '2',
		        'modified_datetime' => Date('Y-m-d h:i:s'),
		        'modified_ip'       => $_SERVER['REMOTE_ADDR']
		    );
			    
			$this->db->where_in('cgrp_id', $cont_id);
			$this->db->where('user_id',$value['user_id']);
			$updated_info = $this->db->update('gmt_contact_group', $doc_del_data);
			// echo $this->db->last_query($updated_info);exit();

			return $doc_del_data_last_id = $this->db->affected_rows();
		}

		public function edit_contact($value, $serviceName){
			$ipJson = json_encode($value);		
			
			$edit_cont_count = array(
					'cont_group_id' => $value['cont_group_id']
				);
			$this->db->where('user_id', $value['user_id']);
			$this->db->where('cont_id', $value['contact_id']);
			$update_group = $this->db->update('gmt_contact',$edit_cont_count);
			return $afted_rows = $this->db->affected_rows(); // exit();
		}
	}
?>