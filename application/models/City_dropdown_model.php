<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class City_dropdown_model extends CI_model
	{
    
    function city_district($input)
    {
      $this->db->select('id, district, city ');
      $this->db->from('gmt_indian_city_list'); 
      $this->db->where('state', $input['state']);
      $query = $this->db->get();
      $details = $query->result_array();
      return $details;
    } 

    function state_dropdown()
    {
      $this->db->select('DISTINCT(state)');
      $this->db->from('gmt_indian_city_list'); 
      $query = $this->db->get();
      $details = $query->result_array();
      return $details;
    }  
    function district_dropdown($input)
    {
      $ipJson = json_encode($input);
      $this->db->select('DISTINCT(district)');
      $this->db->from('gmt_indian_city_list'); 
      $this->db->where('state',$input['state']);
      $query = $this->db->get();
      $details = $query->result_array();
      return $details;
    }  
    function city_dropdown($input)
    {
    	$ipJson = json_encode($input);
    	$this->db->select('DISTINCT(city),id');
    	$this->db->from('gmt_indian_city_list'); 
    	$this->db->where('district',$input['district']); 
      $this->db->where('state',$input['state']);
    	$query = $this->db->get();
    	$details = $query->result_array();
      return $details;
    }  









	}
	


?>