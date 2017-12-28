<?php
header("content-type:text/html;charset=utf-8");         //设置编码

defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Main extends Admin_Controller
{
	public static $page = 0;


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


	public function show_goods($page)
	{

		$this->load->model('Goods_model');
		$data['goods']=$this->Goods_model->show_goods_by_type('031502212','000000',0);
		$this->load->view('admin/goods.html',$data);
	}

	public function delete_goods()
	{
		$gid = $this->input->post('gid',true);
		$gid = $gid ? intval($gid) :0;
		$this->load->model('Goods_model');
		if($this->Goods_model->delete_all_goods($gid))
		{
			show_notice('删除成功','',BACK_REFRESH);
		}else
		{
			show_notice('删除失败，请重新尝试','',BACK_REFRESH);
		}
	}

	public function show_wants()
	{
		$this->load->model('Wants_model');
		$data['wants'] = array();
		$data['wants'] = $this->Wants_model->select_all_wants(0);
		// var_dump($data['wants']);

		$this->load->view('admin/wants.html',$data);
	}


	public function delete_wants()
	{
		$wid = $this->input->post('wid',true);
		$wid = $wid ? intval($wid) :0;
		// echo 'wid:'.$wid;
		$this->load->model('Wants_model');
		if($this->Wants_model->delete('031502212',$wid,0))
		{
			show_notice('删除成功','',BACK_REFRESH);
		}else
		{
			show_notice('删除失败，请重新尝试','',BACK_REFRESH);
		}
	}
}