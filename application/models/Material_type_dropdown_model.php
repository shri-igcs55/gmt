<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class Material_type_dropdown_model extends CI_model
	{
		
	  

 
  function material_type_dropdown()
  {
  	//$ipJson = json_encode($input);
  	$this->db->select('mat_type');
  	$this->db->from('gmt_material'); 
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