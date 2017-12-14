<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model
{
	const TBL_ADMIN='admin';
	public function get_admin($username,$password)
	{
		$array=array(
			'username'=> $username,
			'password'=> md5($password."let's encrypt")
		);
		$query = $this->db->get_where(self::TBL_ADMIN,$array);
		// $data=$this->db->get_where('admin',array('username'=> $username))->result_array();

		return $query->num_rows() > 0 ? true : false;
	}

}


?>