<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	*  signup model
	*/
	class Book_history_model extends CI_model
	{		
	    function book_history($input)
	    {	    	
	    	$ipJson = json_encode($input);
		    	
			$arrOrderIds = array();
			$this->db->select('plc_odr_id_fk');
			$this->db->from('gmt_order_quotation');
			$this->db->join('gmt_place_order a','a.plc_odr_id =gmt_order_quotation.plc_odr_id_fk');
			$this->db->where('gmt_order_quotation.user_id =',$input['user_id']);
			$this->db->or_where('a.user_id =',$input['user_id']);
			$query = $this->db->get();	    	
	    	//echo $this->db->last_query($query); exit;
			$arrOrderIds = $query->result_array();
			foreach($arrOrderIds as $arrOrderId):
				$orderId[] = $arrOrderId['plc_odr_id_fk'];
			endforeach;
			
			$today_date = date("Y-m-d");
	    	$this->db->select('a.plc_odr_id AS order_id, a.ord_to_u_type_id_fk AS order_place_for_id, IFNULL(i.u_type_name,0) AS order_place_for, h.sta_name AS order_status, a.user_id, IFNULL(e.vehicle_typ,0) AS vehicle_type, a.other_vehicle, a.plc_odr_item_qty AS item_qty, a.plc_odr_vehicle_qty AS vehicle_qty, a.plc_odr_from_address AS from_address, a.plc_odr_to_address AS to_address, IFNULL((select `sf_type` from `gmt_service_for` where `sf_id` = IFNULL(a.sf_id_fk,0)),0) AS service_type_name, a.other_service_for, a.plc_odr_by_fname AS first_name, a.plc_odr_by_lname AS last_name, a.plc_odr_by_mob AS mobile, IFNULL(d.mat_type,0) AS material_type, a.other_material, a.plc_odr_weight AS weight, a.plc_odr_feet AS length, a.plc_odr_descrp_goods AS pm_goods_description, CONCAT(IFNULL(b.city,0), ", ", IFNULL(b.district,0), ", ", IFNULL(b.state,0)) AS from_city, CONCAT(IFNULL(c.city,0), ", ", IFNULL(c.district,0), ", ", IFNULL(c.state,0)) AS to_city, a.plc_odr_pick_points AS order_pickup_points, a.plc_odr_drop_points AS order_drop_points, a.plc_odr_schedule_date AS order_schedule_date, a.plc_odr_from_floor AS order_from_floor, a.plc_odr_from_lift AS order_from_lift, a.plc_odr_to_floor AS order_to_floor, a.plc_odr_to_lift AS order_to_lift, ol.orl_pickup_location AS pickup_area_location, ol.orl_drop_location AS drop_area_location, IFNULL(g.dw_type,0) AS crane_work_type, a.other_work_desc, a.plc_odr_del_status');
	    	$this->db->from('gmt_place_order a'); 		
			$this->db->join('gmt_order_location ol', 'a.plc_odr_id=ol.plc_odr_id');
			$this->db->join('gmt_indian_city_list b', 'ol.orl_from_city_id=b.id', 'left');
			$this->db->join('gmt_indian_city_list c', 'ol.orl_to_city_id=c.id', 'left');
			$this->db->join('gmt_material d', 'a.mat_id_fk=d.mat_id', 'left');
			$this->db->join('gmt_vehicle e', 'a.vehicle_id_fk=e.vehicle_id', 'left');
			$this->db->join('gmt_service_for f', 'a.sf_id_fk=f.sf_id', 'left');
			$this->db->join('gmt_desc_work g', 'a.dw_id_fk = g.dw_id', 'left');
			$this->db->join('gmt_status h', 'h.sta_id = a.plc_odr_status_id_fk', 'left');			
			$this->db->join('gmt_user_type i', 'a.ord_to_u_type_id_fk = i.u_type_id', 'left');			
			$this->db->where('a.plc_odr_del_status =', 1);

			
			//logged in user is order owner or not			
			/*
			if ($input['user_type_parent_id'] == 2 || $input['user_type_parent_id'] == 2) {
				$this->db->where('a.user_id', $input['user_id']);
			}
			*/
			
			$this->db->group_start();
				$this->db->or_where('a.user_id', $input['user_id']);
				if($input['user_type_parent_id'] == 5 || $input['user_type_parent_id'] == 6){
					$this->db->or_where('a.ord_to_u_type_id_fk =', $input['user_type_parent_id']);
				}			
			
			
			switch ($input['user_type']) {
				case 8:
					$this->db->or_where_in('a.vehicle_id_fk', array('4', '7'));
					$this->db->where('a.ord_to_u_type_id_fk =', $input['user_type_parent_id']);
					break;

				case 9:
					$this->db->or_where('a.vehicle_id_fk =', 2);
					$this->db->where('a.ord_to_u_type_id_fk =', $input['user_type_parent_id']);
					break;
				
				case 10:
					$this->db->or_where('a.vehicle_id_fk =', 2);
					$this->db->where('a.ord_to_u_type_id_fk =', $input['user_type_parent_id']);
					break;
			
				case 11:
					$this->db->or_where_in('a.vehicle_id_fk', array('6', '9'));
					$this->db->where('a.ord_to_u_type_id_fk =', $input['user_type_parent_id']);
					break;

				case 12:
					$this->db->or_where('a.vehicle_id_fk =', 5);
					$this->db->where('a.ord_to_u_type_id_fk =', $input['user_type_parent_id']);
					break;
				
				case 13:
					$this->db->or_where('a.vehicle_id_fk =', 8);
					$this->db->where('a.ord_to_u_type_id_fk =', $input['user_type_parent_id']);
					break;
				
				default:
					
					break;
			}
			
			$this->db->group_end();
			
			
			
			
			if(count($arrOrderIds))	$this->db->where_not_in('a.plc_odr_id',$orderId);
			
			if($input['order_status'] == 3){
				$this->db->where('a.plc_odr_status_id_fk >=', $input['order_status']);
				$this->db->where('a.plc_odr_status_id_fk <=', 9);
			}else if($input['order_status'] == 9){
				$this->db->where('a.plc_odr_status_id_fk >=', $input['order_status']);
			}
			
			
			
			
			$this->db->order_by('a.plc_odr_schedule_date','ASC');
			$details = array();
			$arrOrder_details = array();
	    	$query = $this->db->get();
	    	// echo $this->db->last_query($query);//exit();
	    	$details = $query->result_array();
			
			foreach($details as $order_details):
				if(strtotime($order_details['order_schedule_date']) >= strtotime(date('d-m-Y'))):
					$arrOrder_details[] = $order_details;
				endif;
			endforeach;
			
	    	return $arrOrder_details;
	    } 


		function rated_orders($input)
	    {			
	    	// print_r($input);exit();
	    	$ipJson = json_encode($input);
	    	
	    	//a.plc_odr_from_area_location, a.plc_odr_to_area_location, a.plc_odr_from_address, a.plc_odr_to_address, IFNULL(f.sf_type,0) AS service_type, , ol.orl_from_city_id, ol.orl_to_city_id,

			//oq.odr_qtn_amount,oq.status_id_fk
			
			$arrOrderIds = array();
			$this->db->select('plc_odr_id_fk');
			$this->db->from('gmt_order_quotation');
			$this->db->join('gmt_place_order a','a.plc_odr_id = gmt_order_quotation.plc_odr_id_fk');			
			$this->db->where('gmt_order_quotation.status_id_fk =',9);
			$this->db->where('a.user_id =',$input['user_id']);
			
			$query = $this->db->get();	    	
	    	//echo $this->db->last_query($query); exit;
			$arrOrderIds = $query->result_array();
			foreach($arrOrderIds as $arrOrderId):
				$orderId[] = $arrOrderId['plc_odr_id_fk'];
			endforeach;
			
			$time = date("Y-m-d H:i:s", time() - 35);			

	    	$this->db->select('oq.modified_datetime,oq.odr_amt_basis,oq.odr_qtn_amount,oq.status_id_fk,a.plc_odr_id AS order_id, a.ord_to_u_type_id_fk AS order_place_for_id, IFNULL(i.u_type_name,0) AS order_place_for, h.sta_name AS order_status, a.user_id, IFNULL(e.vehicle_typ,0) AS vehicle_type, a.other_vehicle, a.plc_odr_item_qty AS item_qty, a.plc_odr_vehicle_qty AS vehicle_qty, a.plc_odr_from_address AS from_address, a.plc_odr_to_address AS to_address, IFNULL((select `sf_type` from `gmt_service_for` where `sf_id` = IFNULL(a.sf_id_fk,0)),0) AS service_type_name, a.other_service_for, a.plc_odr_by_fname AS first_name, a.plc_odr_by_lname AS last_name, a.plc_odr_by_mob AS mobile, IFNULL(d.mat_type,0) AS material_type, a.other_material, a.plc_odr_weight AS weight, a.plc_odr_feet AS length, a.plc_odr_descrp_goods AS pm_goods_description, CONCAT(IFNULL(b.city,0), ", ", IFNULL(b.district,0), ", ", IFNULL(b.state,0)) AS from_city, CONCAT(IFNULL(c.city,0), ", ", IFNULL(c.district,0), ", ", IFNULL(c.state,0)) AS to_city, a.plc_odr_pick_points AS order_pickup_points, a.plc_odr_drop_points AS order_drop_points, a.plc_odr_schedule_date AS order_schedule_date, a.plc_odr_from_floor AS order_from_floor, a.plc_odr_from_lift AS order_from_lift, a.plc_odr_to_floor AS order_to_floor, a.plc_odr_to_lift AS order_to_lift, ol.orl_pickup_location AS pickup_area_location, ol.orl_drop_location AS drop_area_location, IFNULL(g.dw_type,0) AS crane_work_type, a.other_work_desc, a.plc_odr_del_status,
			CONCAT("00:",
  MINUTE(TIMEDIFF("'.$time.'",oq.modified_datetime)),":",
  SECOND(TIMEDIFF("'.$time.'",oq.modified_datetime))) as time_left');
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
			$this->db->join('gmt_order_quotation oq', 'a.plc_odr_id = oq.plc_odr_id_fk');
			$this->db->join('gmt_user_type i', 'a.ord_to_u_type_id_fk = i.u_type_id', 'left');			
			$this->db->where('a.plc_odr_del_status =', 1);
			$this->db->where_in('oq.status_id_fk', array('4', '5'));
			$this->db->where('oq.modified_datetime <', $time);
			

			$this->db->group_start();
						
			if ($input['user_type_parent_id'] == 2 || $input['user_type_parent_id'] == 2) {
				$this->db->or_where('a.user_id', $input['user_id']);
			}
			
			if($input['user_type_parent_id'] == 5 || $input['user_type_parent_id'] == 6 || $input['user_type_parent_id'] == 7){
				$this->db->group_start();
				$this->db->or_where('a.ord_to_u_type_id_fk =', $input['user_type_parent_id']);				
				$this->db->where('oq.user_id', $input['user_id']);				
				$this->db->or_where('a.user_id', $input['user_id']);
				$this->db->group_end();
			}
			
			switch ($input['user_type']) {
				case 8:
					$this->db->or_where_in('a.vehicle_id_fk', array('4', '7'));					
					break;

				case 9:
					$this->db->or_where('a.vehicle_id_fk =', 2);					
					break;
				
				case 10:
					$this->db->or_where('a.vehicle_id_fk =', 2);					
					break;
			
				case 11:
					$this->db->or_where_in('a.vehicle_id_fk', array('6', '9'));					
					break;

				case 12:
					$this->db->or_where('a.vehicle_id_fk =', 5);					
					break;
				
				case 13:
					$this->db->or_where('a.vehicle_id_fk =', 8);					
					break;
				
				default:
					
					break;
			}
			
			$this->db->group_end();
			
			
			
			
			
			if(count($arrOrderIds))	$this->db->where_not_in('a.plc_odr_id',$orderId);
			
			if($input['order_status'] == 3){
				$this->db->where('a.plc_odr_status_id_fk >=', $input['order_status']);
				$this->db->where('a.plc_odr_status_id_fk <=', 9);
			}else if($input['order_status'] == 9){
				$this->db->where('a.plc_odr_status_id_fk >=', $input['order_status']);
			}
			
			
			
			
			
			$this->db->order_by('a.plc_odr_schedule_date','ASC');
			$details = array();
			$arrOrder_details = array();
	    	$query = $this->db->get();
	    	// echo $this->db->last_query($query);//exit();
	    	$details = $query->result_array();
	 
			$processing_order = array();
			foreach($details as $order):
				$this->db->select('user_id,odr_amt_basis,odr_qtn_amount as order_amount,plc_odr_id_fk as order_id,status_id_fk as order_status')->from('gmt_order_quotation oq')
			->where('plc_odr_id_fk =',$order['order_id']);
				$query = $this->db->get();
				$processing_order[$order['order_id']][] = $query->result_array();
			endforeach;
			
			return array('order'=>$details,'quotation'=>$processing_order);			
	    	//return $details;
	    } 
		
		function confirm_orders($input)
	    {			
	    	// print_r($input);exit();
	    	$ipJson = json_encode($input);
	    	
	    	//a.plc_odr_from_area_location, a.plc_odr_to_area_location, a.plc_odr_from_address, a.plc_odr_to_address, IFNULL(f.sf_type,0) AS service_type, , ol.orl_from_city_id, ol.orl_to_city_id,

			//oq.odr_qtn_amount,oq.status_id_fk
	

	    	$this->db->select('oq.odr_amt_basis,oq.odr_qtn_amount,oq.status_id_fk,a.plc_odr_id AS order_id, a.ord_to_u_type_id_fk AS order_place_for_id, IFNULL(i.u_type_name,0) AS order_place_for, h.sta_name AS order_status, a.user_id, IFNULL(e.vehicle_typ,0) AS vehicle_type, a.other_vehicle, a.plc_odr_item_qty AS item_qty, a.plc_odr_vehicle_qty AS vehicle_qty, a.plc_odr_from_address AS from_address, a.plc_odr_to_address AS to_address, IFNULL((select `sf_type` from `gmt_service_for` where `sf_id` = IFNULL(a.sf_id_fk,0)),0) AS service_type_name, a.other_service_for, a.plc_odr_by_fname AS first_name, a.plc_odr_by_lname AS last_name, a.plc_odr_by_mob AS mobile, IFNULL(d.mat_type,0) AS material_type, a.other_material, a.plc_odr_weight AS weight, a.plc_odr_feet AS length, a.plc_odr_descrp_goods AS pm_goods_description, CONCAT(IFNULL(b.city,0), ", ", IFNULL(b.district,0), ", ", IFNULL(b.state,0)) AS from_city, CONCAT(IFNULL(c.city,0), ", ", IFNULL(c.district,0), ", ", IFNULL(c.state,0)) AS to_city, a.plc_odr_pick_points AS order_pickup_points, a.plc_odr_drop_points AS order_drop_points, a.plc_odr_schedule_date AS order_schedule_date, a.plc_odr_from_floor AS order_from_floor, a.plc_odr_from_lift AS order_from_lift, a.plc_odr_to_floor AS order_to_floor, a.plc_odr_to_lift AS order_to_lift, ol.orl_pickup_location AS pickup_area_location, ol.orl_drop_location AS drop_area_location, IFNULL(g.dw_type,0) AS crane_work_type, a.other_work_desc, a.plc_odr_del_status,user.user_fname AS first_name, user.user_lname AS last_name, user.user_email AS email, user.user_mob AS mobile');
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
			$this->db->join('gmt_order_quotation oq', 'a.plc_odr_id = oq.plc_odr_id_fk');
			$this->db->join('gmt_user_type i', 'a.ord_to_u_type_id_fk = i.u_type_id', 'left');	
			
			if ($input['user_type_parent_id'] == 2 || $input['user_type_parent_id'] == 2) {
				$this->db->join('gmt_user user', 'user.user_id = oq.user_id', 'left'); // getting Transporter details Conditional Statement here 
			}else{
				$this->db->join('gmt_user user', 'user.user_id = a.user_id', 'left'); // getting Customer details Conditional Statement here 
			}
			
			
			$this->db->where('a.plc_odr_del_status =', 1);
			$this->db->where('oq.status_id_fk =', 9);
			
			$this->db->group_start();
			
			if ($input['user_type_parent_id'] == 2 || $input['user_type_parent_id'] == 2) {
				$this->db->or_where('a.user_id', $input['user_id']);
			}
			
			if($input['user_type_parent_id'] == 5 || $input['user_type_parent_id'] == 6 || $input['user_type_parent_id'] == 7){
				$this->db->group_start();
				$this->db->or_where('a.ord_to_u_type_id_fk =', $input['user_type_parent_id']);				
				$this->db->where('oq.user_id', $input['user_id']);				
				$this->db->or_where('a.user_id', $input['user_id']);
				$this->db->group_end();
			}
			
			switch ($input['user_type']) {
				case 8:
					$this->db->or_where_in('a.vehicle_id_fk', array('4', '7'));					
					break;

				case 9:
					$this->db->or_where('a.vehicle_id_fk =', 2);					
					break;
				
				case 10:
					$this->db->or_where('a.vehicle_id_fk =', 2);					
					break;
			
				case 11:
					$this->db->or_where_in('a.vehicle_id_fk', array('6', '9'));					
					break;

				case 12:
					$this->db->or_where('a.vehicle_id_fk =', 5);					
					break;
				
				case 13:
					$this->db->or_where('a.vehicle_id_fk =', 8);					
					break;
				
				default:
					
					break;
			}
			
			$this->db->group_end();
						
			
			
			
			if($input['order_status'] == 3){
				$this->db->where('a.plc_odr_status_id_fk >=', $input['order_status']);
				$this->db->where('a.plc_odr_status_id_fk <=', 9);
			}else if($input['order_status'] == 9){
				$this->db->where('a.plc_odr_status_id_fk >=', $input['order_status']);
			}
			
			$this->db->order_by('a.plc_odr_schedule_date','ASC');
			$details = array();
			$arrOrder_details = array();
	    	$query = $this->db->get();
	    	//echo $this->db->last_query($query);exit();
	    	$details = $query->result_array();	 
			
			return array('order'=>$details);			
	    	//return $details;
	    } 
		
		
		public function getOrderDetail($order_id)
		{
			$this->db->select('a.plc_odr_id AS order_id, a.ord_to_u_type_id_fk AS order_place_for_id, IFNULL(i.u_type_name,0) AS order_place_for, h.sta_name AS order_status, a.user_id, IFNULL(e.vehicle_typ,0) AS vehicle_type, a.other_vehicle, a.plc_odr_item_qty AS item_qty, a.plc_odr_vehicle_qty AS vehicle_qty, a.plc_odr_from_address AS from_address, a.plc_odr_to_address AS to_address, IFNULL((select `sf_type` from `gmt_service_for` where `sf_id` = IFNULL(a.sf_id_fk,0)),0) AS service_type_name, a.other_service_for, a.plc_odr_by_fname AS first_name, a.plc_odr_by_lname AS last_name, a.plc_odr_by_mob AS mobile, IFNULL(d.mat_type,0) AS material_type, a.other_material, a.plc_odr_weight AS weight, a.plc_odr_feet AS length, a.plc_odr_descrp_goods AS pm_goods_description, CONCAT(IFNULL(b.city,0), ", ", IFNULL(b.district,0), ", ", IFNULL(b.state,0)) AS from_city, CONCAT(IFNULL(c.city,0), ", ", IFNULL(c.district,0), ", ", IFNULL(c.state,0)) AS to_city, a.plc_odr_pick_points AS order_pickup_points, a.plc_odr_drop_points AS order_drop_points, a.plc_odr_schedule_date AS order_schedule_date, a.plc_odr_from_floor AS order_from_floor, a.plc_odr_from_lift AS order_from_lift, a.plc_odr_to_floor AS order_to_floor, a.plc_odr_to_lift AS order_to_lift, ol.orl_pickup_location AS pickup_area_location, ol.orl_drop_location AS drop_area_location, IFNULL(g.dw_type,0) AS crane_work_type, a.other_work_desc, a.plc_odr_del_status');
	    	$this->db->from('gmt_place_order a'); 
			$this->db->where('a.plc_odr_id =', $order_id);
			$query = $this->db->get();	    	
	    	return $details = $query->result_array();
		}
		
		
		
	}
?>