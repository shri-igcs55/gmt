<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class Desc_of_work_dropdown_model extends CI_model
	{
		
	  

 
  function desc_of_work_dropdown()
  {
  	//$ipJson = json_encode($input);
  	$this->db->select('dw_type');
  	$this->db->from('gmt_desc_work'); 
   


  
  	$query = $this->db->get();
  	//echo $this->db->last_query();

  	$details = $query->result();
  //print_r($details);
			//exit();
  	return $details;
  }  









	}
	


?>