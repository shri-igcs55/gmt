<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class Current_order_model extends CI_model
	{
		
	  

 
  function current_order($input)
  {
  	$ipJson = json_encode($input);
  	$this->db->select('*');
  	$this->db->from('gmt_place_order'); 
  	$this->db->where('user_id',$input['user_id']);
    $this->db->where('plc_odr_schedule_date > NOW()', NULL, FALSE);
  	$query = $this->db->get();
  	//echo $this->db->last_query();

  	$details = $query->result();
  //print_r($details);
			//exit();
  	return $details;
  }  









	}
	


?>