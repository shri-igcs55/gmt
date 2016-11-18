<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class Delete_document_model extends CI_model
	{
    function delete_document($input)
    {
	    $ipJson = json_encode($input);
	    //$this->db->from('gmt_transporter_doc'); 
	    $this->db->where('trans_doc_id',$input['trans_doc_id']);
      $this->db->delete('gmt_transporter_doc');
	    //$query = $this->db->get();
	    //echo $this->db->last_query();
	    //$details = $query->result();
      //print_r($details);
		  //exit();
	    //return $details;
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