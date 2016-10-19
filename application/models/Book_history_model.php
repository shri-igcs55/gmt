<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class Book_history_model extends CI_model
	{
	    function book_history($input)
	    {
	    	// print_r($input);exit();
	    	$ipJson = json_encode($input);
	    	
	    	//a.plc_odr_from_area_location, a.plc_odr_to_area_location, a.plc_odr_from_address, a.plc_odr_to_address, IFNULL(f.sf_type,0) AS service_type, , ol.orl_from_city_id, ol.orl_to_city_id,

	    	$this->db->select('a.plc_odr_id AS order_id, a.ord_to_u_type_id_fk AS order_place_for_id, IFNULL(i.u_type_name,0) AS order_place_for, h.sta_name AS order_status, a.user_id, IFNULL(e.vehicle_typ,0) AS vehicle_type, a.plc_odr_item_qty AS item_qty, a.plc_odr_vehicle_qty AS vehicle_qty, a.plc_odr_from_address AS from_address, a.plc_odr_to_address AS to_address, IFNULL((select `sf_type` from `gmt_service_for` where `sf_id` = IFNULL(f.sf_type,0)),0) AS service_type_name, a.plc_odr_by_fname AS first_name, a.plc_odr_by_lname AS last_name, a.plc_odr_by_mob AS mobile, IFNULL(d.mat_type,0) AS material_type, a.plc_odr_weight AS weight, a.plc_odr_feet AS length, a.plc_odr_descrp_goods AS pm_goods_description, CONCAT(IFNULL(b.city,0), ", ", IFNULL(b.district,0), ", ", IFNULL(b.state,0)) AS from_city, CONCAT(IFNULL(c.city,0), ", ", IFNULL(c.district,0), ", ", IFNULL(c.state,0)) AS to_city, a.plc_odr_pick_points AS order_pickup_points, a.plc_odr_drop_points AS order_drop_points, a.plc_odr_schedule_date AS order_schedule_date, a.plc_odr_from_floor AS order_from_floor, a.plc_odr_from_lift AS order_from_lift, a.plc_odr_to_floor AS order_to_floor, a.plc_odr_to_lift AS order_to_lift, ol.orl_pickup_location AS pickup_area_location, ol.orl_drop_location AS drop_area_location, IFNULL(g.dw_type,0) AS crane_work_type');
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
			if ($input['user_type_parent_id'] == 2 || $input['user_type_parent_id'] == 2) {
				$this->db->where('user_id',$input['user_id']);
			}
			if($input['order_status'] == 3){
				$this->db->where('a.plc_odr_status_id_fk >=', $input['order_status']);
				$this->db->where('a.plc_odr_status_id_fk <=', 9);
			}else if($input['order_status'] == 9){
				$this->db->where('a.plc_odr_status_id_fk >=', $input['order_status']);
			}
			if($input['user_type_parent_id'] == 5 || $input['user_type_parent_id'] == 6 || $input['user_type_parent_id'] == 7){
				$this->db->where('a.ord_to_u_type_id_fk =',$input['user_type_parent_id']);
			}
	      
	    	$query = $this->db->get();
	    	// echo $this->db->last_query();
	    	$details = $query->result_array();		
	    	return $details;
	    }  
	}
?>