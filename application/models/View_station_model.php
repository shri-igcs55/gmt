<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class View_station_model extends CI_model
	{
		
	  

 
  function view_station($input)
  {
  	$ipJson = json_encode($input);
  	$this->db->select('a.source_state_fk, b.city_name AS Source_city, a.destination_state_fk, c.city_name AS Destination_city, trans_stn_datetime');
  	$this->db->from('gmt_transporter_station a'); 
    $this->db->join('gmt_statelist b', 'a.source_city_id_fk=b.city_id', 'left');
    $this->db->join('gmt_statelist c', 'a.destination_city_id_fk=c.city_id', 'left');
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