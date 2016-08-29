<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class Service_dropdown_model extends CI_model
	{
		
	  

 
  function service_dropdown()
  {
  	//$ipJson = json_encode($input);
  	$this->db->select('sf_type');
  	$this->db->from('gmt_service_for'); 
  


  
  	$query = $this->db->get();
  	//echo $this->db->last_query();

  	$details = $query->result();
  //print_r($details);
			//exit();
  	return $details;
  }  









	}
	


?>