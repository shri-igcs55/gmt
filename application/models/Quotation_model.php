<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
  /**
  *  signup model
  */
  class Quotation_model extends CI_model
  {   
    function quotation($input, $serviceName) {
      $ipJson = json_encode($input);   
      $quotation = array(
          'user_id'                      => $input['user_id'],
          'plc_odr_id_fk'                => $input['plc_odr_id'],
          'odr_qtn_amount'               => $input['odr_qtn_amount'],
          'odr_qtn_delivered_datetime'   => $input['odr_qtn_delivered_datetime'],
          'odr_amt_basis'                => $input['odr_amt_basis'],
          'status_id_fk'                 => $input['status_id_fk'],
          'created_datetime'             => Date('Y-m-d H:i:s'),
          'created_ip'                   => $input['created_ip'],
          'modified_datetime'            => Date('Y-m-d H:i:s'),
          'modified_ip'                 => $input['modified_ip']  
          );
        $query = $this->db->insert('gmt_order_quotation', $quotation);
        if ($query == 1) {
        $last_id = $this->db->insert_id();
        $this->db->select('user_id,
            plc_odr_id_fk,
            odr_qtn_amount,
            odr_amt_basis,
            odr_qtn_delivered_datetime');
        $this->db->from('gmt_order_quotation');
        $this->db->where('odr_qtn_id', $last_id );
        $detail_last_user = $this->db->get();
        $resultq = $detail_last_user->result();    
        //$data['detail'] = $resultq;
        $data = $resultq;
        //$data['id'] = $profile_thumb_url;
        $status = $this->seekahoo_lib->return_status('success', $serviceName, $data, $ipJson);
        }
        else {
        $data['message'] = 'Something went wrong while signup. Try Again.';
        $status = $this->seekahoo_lib->return_status('Error', $serviceName, $data, $ipJson);
        }
        return $status;
    }
	
	public function rate_to_order($order, $serviceName){
		$quotation = array(
          'user_id'                      => $order['user_id'],
          'plc_odr_id_fk'                => $order['order_id'],
          'odr_qtn_amount'               => $order['quoted_rate'],
		  'odr_amt_basis'               => $order['odr_amt_basis'],
          'status_id_fk'                 => 4,
          'created_datetime'             => Date('Y-m-d H:i:s'),
          'created_ip'                   => $order['created_ip'],
          'modified_datetime'            => Date('Y-m-d H:i:s'),		  
          'modified_ip'                 => $order['modified_ip']  
          );
		  
		$this->db->select('user_id');
        $this->db->from('gmt_order_quotation');
        $this->db->where('user_id', $order['user_id']);
		$this->db->where('plc_odr_id_fk', $order['order_id']);
        $resource = $this->db->get();
		if($resource->num_rows()){
			$data['message'] = 'You have already rated to this order.'; 
			return $status = $this->seekahoo_lib->return_status('Error', $serviceName, $data, json_encode($order));
		}
		$query = $this->db->insert('gmt_order_quotation',$quotation);		
        if ($query == 1) {
			$data['message'] = 'Order rate has been successfully posted.'; 
			$status = $this->seekahoo_lib->return_status('success', $serviceName, $data, json_encode($order));
		}
		else {
			$data['message'] = 'Something went wrong while signup. Try Again.';
			$status = $this->seekahoo_lib->return_status('Error', $serviceName, $data, json_encode($order));
        }
        return $status;
	}
	public function acceptorder($order, $serviceName){
		$this->db->where('user_id', $order['transpoter_id']);
		$this->db->where('plc_odr_id_fk',$order['order_id']);
		$this->db->update('gmt_order_quotation',array('status_id_fk'=>5,'modified_datetime'=>Date('Y-m-d H:i:s')));
		$data['message'] = 'Order rate has been sent successfully to the transpoter.'; 
		return $status = $this->seekahoo_lib->return_status('success', $serviceName, $data, json_encode($order));
	}
	
	public function confirmorder($order, $serviceName){
			
			$this->db->select('user_id');
			$this->db->from('gmt_order_quotation');
			$this->db->where('user_id', $order['transpoter_id']);
			$this->db->where('plc_odr_id_fk',$order['order_id']);
			$resource = $this->db->get();
			if($resource->num_rows()){
				
				if($order['order_status']==9){
					$this->db->where('user_id', $order['transpoter_id']);
					$this->db->where('plc_odr_id_fk',$order['order_id']);
					$this->db->update('gmt_order_quotation',array('status_id_fk'=>$order['order_status']));
				}
				else{
					$this->db->where('user_id', $order['transpoter_id']);
					$this->db->where('plc_odr_id_fk',$order['order_id']);
					$this->db->delete('gmt_order_quotation'); 
				}
			}
			else
			{
				return 7;
				
			}
			
		return $order['order_status'];		
	}
	
	public function deleteTimeOutOrder()
	{		
		$currentDateTime = Date('Y-m-d H:i:s');
		$this->db->where('status_id_fk =',5);
		$this->db->where('TIMESTAMPDIFF(MINUTE, modified_datetime, "'.$currentDateTime.'") <',35);		
		$this->db->delete('gmt_order_quotation');
		return true;
	}
	
	
	
	public function reOrder($order_id){
		
			$this->db->select('plc_odr_id_fk');
	    	$this->db->from('gmt_order_quotation'); 
			$this->db->where('plc_odr_id_fk =', $order_id);
			$query = $this->db->get();
			$totalQuotedOrder = $query->num_rows();
			
			$this->db->select('plc_odr_id_fk');
	    	$this->db->from('gmt_order_quotation'); 
			$this->db->where('plc_odr_id_fk =', $order_id);
			$this->db->where('status_id_fk =', 7);//Vehicle not avilable
			$this->db->or_where('status_id_fk =', 8); //Time out
			$query = $this->db->get();
			if($totalQuotedOrder == $query->num_rows())
			{
				$this->db->where('plc_odr_id_fk', $order_id);
				$this->db->delete('gmt_order_quotation'); 
			}
			 
	}

  }
  
?>