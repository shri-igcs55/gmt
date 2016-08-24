<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Welcome extends CI_Controller {

	function __construct()
	{
	parent::__construct();
		$this->load->model('Model_login');
	}
	public function index()
	{
		$this->load->view('admin_login');
	}
	public function login()
	{


		$email_userid =$this->input->post('email_userid');
		$pass  = $this->input->post('password');
        $ret=$this->Model_login->login($email_userid,$pass);

            if($ret=="true"){
                $data1['user_id_admin']=$this->session->userdata('user_id_admin');
                $data1['content']='';
				$this->load->view('main_admin_page',$data1);

            }elseif($ret=="user") {

			}else{
		
				$this->session->set_flashdata("message", "<div class='alert alert-danger'>Member code or password doesn't match.</div>");
				$err=base64_encode('error');
				redirect(site_url('welcome').'?msg='.$err);
			}

		}

}
