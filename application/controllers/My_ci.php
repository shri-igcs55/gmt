<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class My_ci extends CI_Controller {

	public function index()
	{
		$this->load->view('admin_login');
	}
	public function admin()
	{
		$this->load->view('admin_login');
	}

}
