<?php
header("content-type:text/html;charset=utf-8");         //设置编码

defined('BASEPATH') OR exit('No direct script access allowed');
session_start();
/**
* 
*/
class Main extends Admin_Controller
{


	function __construct()
	{
		# code...
		
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Admin_model','admin');

	}


	
	public  function index()
	{


	$this->load->view('admin/index.html');
	}


	public function show_goods()
	{
		$this->load->view('admin/goods.html');
	}

	public function show_wants()
	{
		$this->load->model('Wants_model');
		$data = $this->Wants_model->select_all_wants(1);
		var_dump($data);
		$this->load->view('admin/wants.html');
	}
}