<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class State_dropdown_model extends CI_model
	{
		
	  

 
  function state_dropdown()
  {
  	//$ipJson = json_encode($input);
    $this->db->distinct();
  	$this->db->select('state');
  	$this->db->from('gmt_statelist'); 
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