<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	*  signup model
	*/
	class View_profile_model extends CI_model
	{
  function view_profile($input)
  {
  	$ipJson = json_encode($input);
  	$this->db->select('a.u_detail_name, a.u_detail_firm_name, a.state_fk, d.city_name, a.u_detail_pin, a.u_detail_pan, a.u_detail_tin, a.u_detail_stax, e.comp_type, a.trans_cat_id_fk, b.user_email, b.user_mob, c.u_type_name');
  	$this->db->from('gmt_user_details a'); 
    $this->db->join('gmt_user b', 'a.user_id = b.user_id', 'left');
    $this->db->join('gmt_user_type c', 'b.u_type_id = c.u_type_id', 'left');
    $this->db->join('gmt_statelist d', 'a.city_fk = d.city_id', 'left');
    $this->db->join('gmt_company_type e', 'a.comp_type_id_fk = e.comp_type_id', 'left');
    $this->db->join('gmt_transporter_cat f', 'a.trans_cat_id_fk = f.trans_cat_id', 'left');
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