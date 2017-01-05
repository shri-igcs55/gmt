<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Model for Notification Module
*/
class Notification
{
	 protected $CI;

    public function __construct(){
        $this->CI =& get_instance();
    }
	public function add($user_id,$message,$link){
		$this->CI->db->insert('notification', array('user_id'=>$user_id,'notification_message'=>$message,'link'=>$link));
		//$data['message'] = "Notificaton add successfully.";
        //return $this->seekahoo_lib->return_status('success','Notification Add', $data, json_encode(array('user_id'=>$user_id,'notification_message'=>$message)));
	}
	public function read($id){		
		$this->CI->db->where('id',$id);
		$updated_info = $this->CI->db->update('notification', array('status'=>1));
		//$data['message'] = "Notificaton read successfully.";
        //return $this->seekahoo_lib->return_status('success','Notification Add', $data, json_encode(array('status'=>1)));
	}
	public function del($id){		
		$this->CI->db->where('id',$id);		
		$this->CI->db->delete('notification');
	}
	public function get($user_id){
		$this->CI->db->select('*');
        $this->CI->db->from('notification');
        $this->CI->db->where('user_id', $user_id );		
		$this->CI->db->order_by('id','DESC');
        $detail_last_user = $this->CI->db->get();
        return $detail_last_user->result();
		//$data['message'] = "Notificaton get successfully.";
        //return $this->seekahoo_lib->return_status('success','Notification Add', $data, json_encode(array('user_id'=>$user_id)));
	}
}
?>