<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class Search_order_model extends CI_model
	{
		
    function search_order($input)
    {
    	$ipJson = json_encode($input);
      // $cond = array('a.from_city'=>$input['from_city'], 'ord_to_u_type_id_fk'=>$input['user_type']);
      // if(empty($input['from_city']))
      // {
      //   $input['from_city'] = 0;
      // }
      // if(empty($input['to_city']))
      // {
      //   $input['to_city'] = 0;
      // }
      // if(empty($input['weight']))
      // {
      //   $input['weight'] = 0;
      // }
      // if(empty($input['vehicle_type']))
      // {
      //   $input['vehicle_type'] = 0;
      // }
      // if(empty($input['sehdule_date']))
      // {
      //   $input['sehdule_date'] = 0;
      // }

      $this->db->select('IFNULL(c.city, 0) AS From_city, a.plc_odr_from_area_location AS from_location, IFNULL(d.city, 0) AS to_city, a.plc_odr_to_area_location AS to_location, IFNULL(e.mat_type, 0) AS material_type, a.plc_odr_item_qty AS item_qty, a.plc_odr_weight AS weight, a.plc_odr_feet AS length, IFNULL(b.vehicle_typ, 0) AS vehicle_type, a.plc_odr_vehicle_qty AS vehicle_qty, IFNULL(a.plc_odr_pick_points, 0) AS pickup_points, IFNULL(a.plc_odr_drop_points, 0) AS drop_points, a.plc_odr_schedule_date AS schedule_date');
      $this->db->from('gmt_place_order a'); 
      $this->db->join('gmt_vehicle b', 'a.vehicle_id_fk = b.vehicle_id', 'left');
      $this->db->join('gmt_indian_city_list c', 'a.from_city = c.id', 'left');
      $this->db->join('gmt_indian_city_list d', 'a.to_city = d.id', 'left');
      $this->db->join('gmt_material e', 'a.mat_id_fk = e.mat_id', 'left');
      $this->db->where('a.ord_to_u_type_id_fk', $input['user_type']);
      //$this->db->where("(a.from_city=$input['from_city'] OR a.to_city = $input['to_city'] OR a.plc_odr_weight = $input['weight'] OR a.vehicle_id_fk = $input['vehicle_type'] OR a.plc_odr_schedule_date = $input['sehdule_date'])", NULL, FALSE)
      $this->db->group_start();
      $this->db->where('a.from_city', $input['from_city']);
      $this->db->or_where('a.to_city', $input['to_city']);
      $this->db->or_where('a.plc_odr_weight', $input['weight']);
      $this->db->or_where('a.vehicle_id_fk', $input['vehicle_type']);
      $this->db->or_where('a.plc_odr_schedule_date', $input['sehdule_date']);
      $this->db->group_end();
      $query = $this->db->get();
      echo $this->db->last_query();
      exit();
      $details = $query->result();
      //print_r($details);
  	  //exit();
      return $details;
    }  

	}
?>