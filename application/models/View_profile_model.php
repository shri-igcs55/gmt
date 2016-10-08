<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	*  signup model
	*/
	class View_profile_model extends CI_model
	{
    function view_profile($input)
    {
    	$ipJson = json_encode($input);
    	$this->db->select('b.user_id AS id, b.user_fname AS fname, b.user_lname AS lname, b.user_email AS email, b.user_mob AS mobile, d.id AS c_id, d.city, a.state_fk AS state, d.district AS dstrt, a.address1 AS addr1, a.address2 AS addr2, a.u_detail_pin AS pincode, a.u_detail_pan AS pan_no, a.u_detail_tin AS tin_no, a.u_detail_stax AS stax, e.comp_type_id AS ctype_id, IFNULL(e.comp_type, 0) AS company_type, c.u_type_name AS user_type_name, b.user_firm_name AS firm_name, b.user_designation AS designation_id, f.desg_type AS designation');
    	$this->db->from('gmt_user_details a'); 
      $this->db->join('gmt_user b', 'a.user_id = b.user_id', 'left');
      $this->db->join('gmt_user_type c', 'b.u_type_id = c.u_type_id', 'left');
      $this->db->join('gmt_indian_city_list d', 'a.city = d.id', 'left');
      $this->db->join('gmt_company_type e', 'a.comp_type_id_fk = e.comp_type_id', 'left');
      $this->db->join('gmt_designation f', 'b.user_designation = f.desg_id', 'left');
    	$this->db->where('a.user_id',$input['user_id']);
    	$query = $this->db->get();
    	//echo $this->db->last_query();
    	$details = $query->result_array();
      //print_r($details);
  		//exit();
      // $details = $query->row();
    	return $details;
    }  
	}
?>