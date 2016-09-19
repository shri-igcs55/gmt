<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class Company_type_dropdown_model extends CI_model
	{ 
  function company_type_dropdown()
  {
  	   //$ipJson = json_encode($input);
  	  $this->db->select('comp_type');
  	  $this->db->from('gmt_company_type'); 
      //$this->db->order by('vehicle_id');
  	  $query = $this->db->get();
  	  //echo $this->db->last_query();
    	$details = $query->result();
      //print_r($details);
			//exit();
  	  return $details;
  }  
	}

?>