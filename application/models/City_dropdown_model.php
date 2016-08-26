<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class City_dropdown_model extends CI_model
	{
		
	  

 
  function city_dropdown($input)
  {
  	$ipJson = json_encode($input);
  	$this->db->select('city_name');
  	$this->db->from('gmt_statelist'); 


  	$this->db->where('state',$input['state']);
  	$query = $this->db->get();
  	//echo $this->db->last_query();

  	$details = $query->result();
  //print_r($details);
			//exit();
  	return $details;
  }  









	}
	


?>