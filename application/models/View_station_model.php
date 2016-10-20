<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class View_station_model extends CI_model
	{
		
	  

 
  function view_station($input)
  {
  	$ipJson = json_encode($input);
  	$this->db->select('b.state AS from_state,b.city AS from_city,c.state AS to_state,c.city AS to_city');
  	$this->db->from('gmt_transporter_station a'); 
    $this->db->join('gmt_indian_city_list b', 'a.source_city_id_fk=b.id', 'left');
    $this->db->join('gmt_indian_city_list c', 'a.destination_city_id_fk=c.id', 'left');
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