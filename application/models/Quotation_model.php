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
            'created_datetime'             => Date('Y-m-d h:i:s'),
            'created_ip'                   => $input['created_ip'],
            'modified_datetime'            => Date('Y-m-d h:i:s'),
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

  
      







  }
  


?>