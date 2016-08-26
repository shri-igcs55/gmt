<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class Vehicle_type_dropdown_model extends CI_model
	{
		
	  

 
  function vehicle_type_dropdown()
  {
  	//$ipJson = json_encode($input);
  	$this->db->select('vehicle_typ');
  	$this->db->from('gmt_vehicle'); 
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