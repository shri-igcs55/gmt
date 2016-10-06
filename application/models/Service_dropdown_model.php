<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class Service_dropdown_model extends CI_model
	{
	
    function service_dropdown()
    {
    	//$ipJson = json_encode($input);
    	$this->db->select('sf_id AS id, sf_type AS service_type');
    	$this->db->from('gmt_service_for'); 
    	$query = $this->db->get();
    	$details = $query->result();
    	return $details;
    }  

    public function avail_service_dropdown(){
      //$ipJson = json_encode($input);
      $this->db->select('sf_id AS id, sf_type AS service_type');
      $this->db->from('gmt_service_for'); 
      $this->db->where('sf_status','1');
      $query = $this->db->get();
      $details = $query->result_array();
      return $details;
    }

  }
?>