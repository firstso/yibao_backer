<?php 		

defined('BASEPATH') OR exit('No direct script access allowed');


/**
* 
*/
class MY_Controller extends CI_Controller
{
	
	protected $sno;
	function __construct()
	{
		# code...
		parent::__construct();

		try
		{


				$jwt = $this->input->post('jwt',true);
				if($jwt == NULL)
				{
					// echo "token is null";
					// redirect('Auth/relogin/');
					throw new Exception('jwt is null');


				}else{
						$this->load->library('JWT');

						$key = "salt:let's encrypt";
						$objJWT = new JWT();
						$decoded = $objJWT->decode($jwt, $key, array('HS256'));

						if($decoded == false)
						{
							throw new Exception('jwt已经失效,请重新登录');
						}else
						{
							$decoded_array = (array) $decoded;
							// print_r($decoded_array);
							$this->sno = $decoded_array['sno'];
							// echo $this->sno;
							
						}
				}

		}
		catch(Exception $e)
		{
			echo_failure(1,$e->getMessage());
			// return;
			exit();
		}
	}




}


class Admin_Controller extends CI_Controller
{

	    function __construct()
	    {
	    	
			parent::__construct();

			if ( ! isset($_SESSION['username']) )
			{
				// redirect(base_url().'admin/Privilege/login');
				show_notice('请先登录',base_url().'admin/Privilege/login',URL_LOCATION);
			}
		}
}



?>