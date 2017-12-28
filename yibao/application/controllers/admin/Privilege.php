<?php
header("content-type:text/html;charset=utf-8");         //设置编码

defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Privilege extends CI_Controller
{
	
	function __construct()
	{
		# code...
		
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Admin_model','admin');

	}



	public function login()
	{

		$this->load->view('admin/login.html');
	}


	public function signin()
	{	
			try
			{



					$this->form_validation->set_rules('username','用户名','required');
					$this->form_validation->set_rules('password','密码','required');
					if($this->form_validation->run()==false)
					{
						throw new Exception( validation_errors());
						

					}else
					{



								$username=$this->input->post('username',true);
								$password=$this->input->post('password',true);

								// echo md5($password."let's encrypt");

								if($this->admin->get_admin($username,$password) )
								{ #保存session

									$_SESSION['username'] = $username;
									redirect(base_url().'admin/main/index');

								}else {
									throw new Exception("用户名或密码错误，请重新填写", 1);
									
								}


					}


		}

		catch(Exception $e)
			{
				show_notice($e->getMessage(),'',HISTORY_BACK);

			}

	}



	public function  logout()
	{
		unset($_SESSION['username']);
		redirect(base_url().'admin/Privilege/login');
	}




}






