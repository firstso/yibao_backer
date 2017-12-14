<?php
header("content-type:text/html;charset=utf-8");         //设置编码

defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Privilege extends Admin_Controller
{
	
	function __construct()
	{
		# code...
		
		parent::__construct();
		$this->load->helper('captcha');
		$this->load->library('form_validation');
	}
}