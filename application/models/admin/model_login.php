<?php
	//error_reporting = E_ALL ^ E_DEPRECATED;
class Model_login extends CI_Model {
	
	function __construct() {
		parent:: __construct();
	}
	
	

	function login($userid,$password) 
	{
		$md5_pass = md5($password);	
		$rand_code = "admin-123456789";
        $this->db->select('*');
		$this->db->from('gmt_user');
		$this->db->where('user_email',$userid);
		$this->db->where('user_pass',$md5_pass);
		$this->db->where('user_rand_id',$rand_code);
		$query = $this->db->get();
		$resultRows = $query->num_rows();
		$result = $query->result();
		if ($resultRows > 0) {

		//while(list($user_id) =result_array($query)) 
		//{ 
			$user_session_data['user_id_admin'] = $userid;
			$user_session_data['logged_in_admin']	= 'TRUE';
		//}
		
			$this->session->set_userdata($user_session_data); 
			$datas=array('user_status'=>'active');
	        $this->db->where('user_email',$this->session->userdata('user_id_admin'));
	        $this->db->update('gmt_user',$datas);
			return "true";
        }else{
        	return "false";
        }
	}

function check_mail($email)
{
 $query = $this->db->get_where('admin', array('email' => $email));
 		return $query->result_array();
}

function check_logged($user_id)
{
	  $query = $this->db->get_where('registration', array('userid' => $user_id));
 		return $query->result_array();
}

	function getAll() {
	    $result = $this->db->get('master_department');
	    return $result->result_array();
	}

	function del($dept_code){
		$q = $this->db->delete('master_department', array('dept_code' => $dept_code));
		if($q) {
			return true;
		} else {
			return false;
		}
	}

	function getall_state()
	 {
	    $this->db->select('*');
    	$this->db->from('master_state');
    	$result = $this->db->get();
 		return $result->result_array();
	 }

	function getData($limit, $start)	{
		$this->db->limit($limit, $start);
		$query=$this->db->get('master_department');
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
	}

 	function fetchData($dept_code) {
 		$query = $this->db->get_where('master_department', array('dept_code' => $dept_code));
 		return $query->result_array();
 	}
 
 	function record_count() {
        return $this->db->count_all("master_department");
    }

    function update(){
    	extract($_POST);
		$data = array(
			'dept_code'=>$dept_code,
			'dept_name'=>$dept_name,
			'description'=>$description,
			'member_code'=>$this->session->userdata('member_code')
		);
		$this->db->where('dept_code', $dept_code);
		$up = $this->db->update('master_department', $data); 
		if($up) {
			return true;
		} else {
			return false;
		}
    }

	function getMax_dept_code() {
		$this->db->select_max('dept_code');
	    $result = $this->db->get('master_department');
	    $row = $result->result();
	    if($row[0]->dept_code == '') {
	    	return "1000";
	    } else {
	    	return $row[0]->dept_code+1;
	    }
	}
	function update_ajax(){
		$value=$_POST['value'];
        $row_id=$_POST['row_id'];
        $column=$_POST['column'];
        $update_column='';

        switch ($column) {
            case '1':
                $update_column='dept_name';
                break;
            case '2':
                $update_column='address';
                break;
            default:
                # code...
                break;
        }
        $data = array(    
               $update_column => $value
            );
        if(!empty($value)){
        	
        	 	$this->db->where('dept_code', $row_id);
		        $this->db->update('master_department', $data);
		        echo $value;
        }
        else
        {
        	$arr=$this->fetchData($row_id);
        	echo $arr[0][$update_column];
        }
	}
}
