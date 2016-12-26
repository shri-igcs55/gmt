<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
	/**
	*  signup model
	*/
	class Delete_document_model extends CI_model
	{
    public function delete_document($input)
    {
	    $ipJson = json_encode($input);

      $doc_del_data = array(
        'del_status' => '2',
        'modified_datetime'  => Date('Y-m-d H:i:s'),
        'modified_ip'        => $_SERVER['REMOTE_ADDR']
      );
	    
      $this->db->where('trans_doc_id',$input['trans_doc_id']);
      $updated_info = $this->db->update('gmt_transporter_doc', $doc_del_data);
      
      return $doc_del_data_last_id = $this->db->affected_rows();
    }

    public function delete_order($input)
    {
      $ipJson = json_encode($input);

      $signup_data = array(
        'plc_odr_del_status' => '2',
        'modified_datetime'  => $input['modified_datetime'],
        'modified_ip'        => $input['modified_ip']
      );
      //print_r($signup_data);exit();

      $this->db->where('user_id', $input['user_id']);
      $this->db->where('plc_odr_id', $input['order_id']);
      $updated_info=$this->db->update('gmt_place_order', $signup_data);
      // echo $this->db->last_query($updated_info);exit();
      return $signup_data_last_id = $this->db->affected_rows();
      // print_r($signup_data_last_id);exit();
    }
	}
?>