<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class Book_history_model extends CI_model
	{
    function book_history($input)
    {
    	$ipJson = json_encode($input);

    	$this->db->select('a.plc_odr_id AS order_id,a.user_id,IFNULL(e.vehicle_typ,0) AS vehicle_type,a.plc_odr_item_qty AS item_qty,a.plc_odr_vehicle_qty AS vehicle_qty,a.plc_odr_from_address AS from_address,a.plc_odr_to_address AS to_address,IFNULL((select `sf_type` from `gmt_service_for` where `sf_id` = IFNULL(f.sf_type,0)),0) AS service_type_name,a.plc_odr_by_fname AS first_name,a.plc_odr_by_lname AS last_name,a.plc_odr_by_mob AS mobile,IFNULL(d.mat_type,0) AS material_type,a.plc_odr_weight AS weight,a.plc_odr_feet AS length,a.plc_odr_descrp_goods AS goods_description,a.from_state,IFNULL(b.city,0) AS from_city,a.plc_odr_from_area_location,a.to_state, IFNULL(c.city,0) AS to_city, a.plc_odr_to_area_location, a.plc_odr_pick_points, a.plc_odr_drop_points, a.plc_odr_schedule_date, a.plc_odr_from_address, a.plc_odr_from_floor, a.plc_odr_from_lift, a.plc_odr_to_address, a.plc_odr_to_floor, a.plc_odr_to_lift, IFNULL(f.sf_type,0) AS service_type, IFNULL(g.dw_type,0) AS work_type, i.u_type_name');
    	$this->db->from('gmt_place_order a'); 
      $this->db->join('gmt_indian_city_list b', 'a.from_city=b.id', 'left');
      $this->db->join('gmt_indian_city_list c', 'a.to_city=c.id', 'left');
      $this->db->join('gmt_material d', 'a.mat_id_fk=d.mat_id', 'left');
      $this->db->join('gmt_vehicle e', 'a.vehicle_id_fk=e.vehicle_id', 'left');
      $this->db->join('gmt_service_for f', 'a.sf_id_fk=f.sf_id', 'left');
      $this->db->join('gmt_desc_work g', 'a.dw_id_fk = g.dw_id', 'left');
      // $this->db->join('gmt_transporter_cat h', 'a.trans_cat_id_fk = h.trans_cat_id', 'left');
      $this->db->join('gmt_user_type i', 'a.ord_to_u_type_id_fk = i.u_type_id', 'left');
    	$this->db->where('user_id',$input['user_id']);
      if($input['order_status'] == 3){
        $this->db->where('plc_odr_status_id_fk >=', $input['order_status']);
        $this->db->where('plc_odr_status_id_fk <=', $input['order_status']);
      }else if($input['order_status'] == 9){
        $this->db->where('plc_odr_status_id_fk >=', $input['order_status']);
      }
      
    	$query = $this->db->get();
    	//echo $this->db->last_query();
    	$details = $query->result_array();
      //print_r($details);
			//exit();
    	return $details;
    }  
	}
?>