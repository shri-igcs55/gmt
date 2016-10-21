<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class Search_transporter_order_model extends CI_model
	{
		
    function search_transporter_order($input)
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

      //$this->db->where("(a.from_city=$input['from_city'] OR a.to_city = $input['to_city'] OR a.plc_odr_weight = $input['weight'] OR a.vehicle_id_fk = $input['vehicle_type'] OR a.plc_odr_schedule_date = $input['sehdule_date'])", NULL, FALSE)
      
      

      $this->db->select('a.plc_odr_id AS order_id, a.ord_to_u_type_id_fk AS order_place_for_id, IFNULL(i.u_type_name,0) AS order_place_for, h.sta_name AS order_status, a.user_id, IFNULL(e.vehicle_typ,0) AS vehicle_type, a.plc_odr_item_qty AS item_qty, a.plc_odr_vehicle_qty AS vehicle_qty, a.plc_odr_from_address AS from_address, a.plc_odr_to_address AS to_address, IFNULL((select `sf_type` from `gmt_service_for` where `sf_id` = IFNULL(a.sf_id_fk,0)),0) AS service_type_name, a.plc_odr_by_fname AS first_name, a.plc_odr_by_lname AS last_name, a.plc_odr_by_mob AS mobile, IFNULL(d.mat_type,0) AS material_type, a.plc_odr_weight AS weight, a.plc_odr_feet AS length, a.plc_odr_descrp_goods AS pm_goods_description, CONCAT(IFNULL(b.city,0), ", ", IFNULL(b.district,0), ", ", IFNULL(b.state,0)) AS from_city, CONCAT(IFNULL(c.city,0), ", ", IFNULL(c.district,0), ", ", IFNULL(c.state,0)) AS to_city, a.plc_odr_pick_points AS order_pickup_points, a.plc_odr_drop_points AS order_drop_points, a.plc_odr_schedule_date AS order_schedule_date, a.plc_odr_from_floor AS order_from_floor, a.plc_odr_from_lift AS order_from_lift, a.plc_odr_to_floor AS order_to_floor, a.plc_odr_to_lift AS order_to_lift, ol.orl_pickup_location AS pickup_area_location, ol.orl_drop_location AS drop_area_location, IFNULL(g.dw_type,0) AS crane_work_type');
      $this->db->from('gmt_place_order a');     
      $this->db->join('gmt_order_location ol', 'a.plc_odr_id=ol.plc_odr_id');
      $this->db->join('gmt_indian_city_list b', 'ol.orl_from_city_id=b.id', 'left');
      $this->db->join('gmt_indian_city_list c', 'ol.orl_to_city_id=c.id', 'left');
      $this->db->join('gmt_material d', 'a.mat_id_fk=d.mat_id', 'left');
      $this->db->join('gmt_vehicle e', 'a.vehicle_id_fk=e.vehicle_id', 'left');
      $this->db->join('gmt_service_for f', 'a.sf_id_fk=f.sf_id', 'left');
      $this->db->join('gmt_desc_work g', 'a.dw_id_fk = g.dw_id', 'left');
      $this->db->join('gmt_status h', 'h.sta_id = a.plc_odr_status_id_fk', 'left');
      // $this->db->join('gmt_transporter_cat h', 'a.trans_cat_id_fk = h.trans_cat_id', 'left');
      $this->db->join('gmt_user_type i', 'a.ord_to_u_type_id_fk = i.u_type_id', 'left');
      
      $this->db->where('a.plc_odr_status_id_fk =', 3);

      if($input['user_type_parent_id'] == 5 || $input['user_type_parent_id'] == 6 || $input['user_type_parent_id'] == 7){
        $this->db->where('a.ord_to_u_type_id_fk =',$input['user_type_parent_id']);
      }

      $this->db->group_start();
      $this->db->where('a.from_city', $input['from_city']);
      $this->db->or_where('a.to_city', $input['to_city']);
      $this->db->or_where('a.plc_odr_weight', $input['weight']);
      $this->db->or_where('a.vehicle_id_fk', $input['vehicle_type']);
      $this->db->or_where('a.plc_odr_schedule_date', $input['sehdule_date']);
      $this->db->group_end();

      $query = $this->db->get();
      // echo $this->db->last_query();
      // exit();
      $details = $query->result_array();
      //print_r($details);
  	  //exit();
      return $details;
    }  

	}
?>