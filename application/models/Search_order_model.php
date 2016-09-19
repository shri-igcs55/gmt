<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class Search_order_model extends CI_model
	{
		
  function search_order($input)
  {
      	$ipJson = json_encode($input);
  	    $this->db->select('c.city_name AS From_city,a.plc_odr_from_area_location,d.city_name AS to_city,a.plc_odr_to_area_location,e.mat_type,a.plc_odr_item_qty,a.plc_odr_weight,a.plc_odr_feet, b.vehicle_typ, a.plc_odr_vehicle_qty,a.plc_odr_pick_points, a.plc_odr_drop_points, a.plc_odr_schedule_date, ');
  	    $this->db->from('gmt_place_order a'); 
  	    $this->db->join('gmt_vehicle b', 'a.vehicle_id_fk = b.vehicle_id', 'left');
  	    $this->db->join('gmt_statelist c', 'a.from_city = c.city_id' , 'left');
  	    $this->db->join('gmt_statelist d', 'a.to_city = d.city_id' , 'left');
  	    $this->db->join('gmt_material e', 'a.mat_id_fk = e.mat_id' , 'left');
  	    $this->db->where('from_city',$input['from_city']);
  	    $this->db->or_where('to_city',$input['to_city']);
  	    $this->db->or_where('plc_odr_weight',$input['weight']);
  	    $this->db->or_where('vehicle_id_fk',$input['vehicle_type']);
  	    $this->db->or_where('plc_odr_schedule_date',$input['sehdule_date']);
  	    $query = $this->db->get();
  	    //echo $this->db->last_query();
  	    $details = $query->result();
        //print_r($details);
			  //exit();
  	    return $details;
  }  









	}
	


?>