<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class View_contact_model extends CI_model
	{
		
	  

 
  function view_contact($input)
  {
  	$ipJson = json_encode($input);
  	$this->db->select('a.cont_group_name, a.reg_id_fk, b.u_detail_name, c.user_mob');
  	$this->db->from('gmt_contact a'); 
    $this->db->join('gmt_user_details b', 'a.reg_id_fk=b.user_id', 'left');
    $this->db->join('gmt_user c', 'a.reg_id_fk=c.user_id', 'left');
  	$this->db->where('a.user_id',$input['user_id']);
  	$query = $this->db->get();
  	//echo $this->db->last_query();

  	$details = $query->result();
  //print_r($details);
			//exit();
  	return $details;
  }  









	}
	


?>