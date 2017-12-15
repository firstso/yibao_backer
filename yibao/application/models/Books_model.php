<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Books_model extends CI_Model
{
	
	function __construct()
	{
		# code...
	}

	function donate_books($data)
	{
		$query= $this->db->insert('books',$data);
		return $query? $this->db->insert_id():flase;
	}

	function donate_books_image($data)
	{
		$query= $this->db->insert('books_image',$data);
		return $query? $this->db->insert_id():flase;
	}

	function show_books_by_bid($bid)
	{
		/*获取图书信息*/
		$query = $this->db->get_where('books',array('bid' => $bid));
		$query = $query->result_array()[0];//只有一行数据

		/*处理数据*/
		//echo $query['deadline'];
		if($query['deadline'] == 0)
		{
			$query['deadline'] = "--:--";
		}
		else
		{
			$query['deadline'] = date("Y-m-d ", $query['deadline']);
		}
		
		/*根据用户名获取昵称，头像路径*/
		$res = $this->db->get_where('user',array('sno' => $query['sno']));
		// print_r($res->result_array());//test
		$res = $res->result_array()[0];
		// print_r($res);

		$query['nickname'] = $res['nickname'];
		$query['avatar_path'] = $res['avatar_path'];
		
		/*获取图书图片*/
		$photo = $this->db->get_where('books_image',array('bid' => $bid));
		$photo = $photo->result_array();
		$photo = array_column($photo, 'path');//仅需要提取路径一列
		$query['photo'] = $photo;
		/*如果没有图片，使用默认图片*/
		if(count($photo) == 0)
		{
			$query['photo'][0] = "public/goods/default.jpg";
		}
		
		//print_r($query);
		return $query;
	}

	/*暂时不做分页，$page虚置*/
	function show_books_by_type($type,$page)
	{

		/*先得到类型范围，如12300，可选范围为12300到12399*/
		$string = (string)$type;
		$range = 1;
		for ($i=strlen($string) - 1; $i > 0 ; $i--) 
		{ 
			if($string[$i] != 0)
			{
				$range--;
				break;
			}
			$range *= 10;
		}
		// echo $range;
		$limit = 10;//每次取10条数据
		$this->db->order_by('status', 'DESC');
		$this->db->where('type >=', $type);
		//$this->db->where('type <=', 21998);//?蜜汁bug $type《= type《=21999就没有查询语句，21998还有(因为自己cache)
		$this->db->where('type <=', $type + $range);
		$query = $this->db->get('books', $limit, $page*$limit)->result_array();

        // $query = $this->db->get('books')->result_array();
		// print_r($query);

		$bids = array_column($query, 'bid');

		if(count($bids) == 0) 
		{
			return null;
		}
		// $res[0] = "暂无信息";
		for ($i=0; $i < count($bids); $i++) 
		{ 
			$res[$i] = $this->Books_model->show_books_by_bid($bids[$i]);
		}
		return $res;

	}

	function show_books_by_content($content,$page,$type)
	{
		/*调用分词接口，将content划分为多个关键词*/
		$words = $this->Books_model->get_json_decode($content);
		if ($words == false) 
		{
			return -1;
		} 
		//print_r($words);

		/*先得到类型范围，如12300，可选范围为12300到12399*/
		$string = (string)$type;
		$range = 1;
		for ($i=strlen($string) - 1; $i > 0 ; $i--) 
		{ 
			if($string[$i] != 0)
			{
				$range--;
				break;
			}
			$range *= 10;
		}
		
		$limit = 10;//每次取10条数据
		/*根据图书名模糊查询*/
        $this->db->distinct();
		$this->db->select('bid');
		$this->db->where('type >=', $type);
		$this->db->where('type <=', $type + $range);
		$newtype = $type+$range;
		foreach ($words as $key => $value) 
		{
			$this->db->like('books_name',$value,'both');
		}		
		$this->db->order_by('bid', 'DESC');
		$query = $this->db->get('books', $limit, $page*$limit)->result_array();
		// echo $this->db->last_query();
		$bids = array_column($query, 'bid');
		// print_r($gids);

		if(count($bids) == 0) 
		{
			return null;
		}
		for ($i=0; $i < count($bids); $i++) 
		{ 
			$res[$i] = $this->Books_model->show_books_by_bid($bids[$i]);
		}
		//print_r($res);

		return $res;
		
	}

	public function rent_books($bid,$days,$sno)
	{
		$res = $this->db->get_where('books', array('bid' => $bid));
		$res = $res->result_array()[0];
		//print_r($res);

		if($res['status'] == 0)
		{
			return 0;
		}
		/*修改租借次数，到期时间，租借状态*/
		$rent_times = $res['rent_times']+1;
		$deadline = time() + $days*86400;
		
		$this->db->where('bid', $bid);
		$this->db->set('rent_sno',$sno);//暂时无法测试，注释
		$this->db->set('status', 0);
		$this->db->set('rent_times', $rent_times);
		$this->db->set('deadline', $deadline);

		$query = $this->db->update('books');
		if($query == false)
		{
			return 1;
		}

		return 2;
	}


	public function return_books($bid, $sno)
	{
		$res = $this->db->get_where('books', array('bid' => $bid));
		$res = $res->result_array()[0];

		//非借书人操作
		if($res['rent_sno'] != $sno) {
			return 0;
		}

		//如果当前有人预约，修改当前预约人为借书人，预约状态为可预约
		$this->db->where('bid', $bid);
		$this->db->where('rent_sno', $sno);
		if($res['wait_status'] == 0) {
			$this->db->set('rent_sno', $res['wait_sno']);
			$this->db->set('wait_sno',"");
			$this->db->set('wait_status',1);
			$deadline = time() + 30*86400;//?
			
		}
		else {
			$this->db->set('rent_sno',"");
			$this->db->set('status', 1);
			$deadline = 0;
		}
		$this->db->set('deadline', $deadline);
		
		
		$query = $this->db->update('books');
		if($query == false)
		{
			return 1;
		}

		return 2;
	}

	public function order_books($bid,$sno)
	{
		$res = $this->db->get_where('books', array('bid' => $bid));
		$res = $res->result_array()[0];
		//print_r($res);

		if($res['wait_status'] == 0)
		{
			return 0;
		}
		/*修改预约状态，预约人*/		
		$this->db->where('bid', $bid);
		$this->db->set('wait_sno',$sno);
		$this->db->set('wait_status', 0);

		$query = $this->db->update('books');
		if($query == false)
		{
			return 1;
		}

		return 2;
	}



	public function bid_is_exist($bid)
	{
		$query = $this->db->get_where('books',array('bid' => $bid));
		$res = $query->num_rows();
		return $res;
	}

	/*将content分词*/
	function get_json_decode($content)
	{
	    // 初始化curl
	    $ch = curl_init();
	    //SCWS(简易中文分词)基于HTTP/POST的分词API
	    $url = "http://www.xunsearch.com/scws/api.php";

	    // 设置URL参数 
	    curl_setopt($ch, CURLOPT_URL, $url);
	    // 设置CURL允许执行的最长秒数
	    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	    // 要求CURL返回数据
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    //设置参数
	    $post_data = array (
	        'data' => $content,
	        'respond' => 'json',// 响应结果格式为json
	        'ignore' => 'yes'//忽略标点符号
	    );
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

	    // 执行请求
	    $result = curl_exec( $ch );
	    // 获取http状态
	    $http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );

	    if ($http_code != 200) 
	    {
	        return false;
	    }
	    //取得返回的结果转换成对象,json_decode($result);
	    //取得返回的结果,转换成数组
	    $data = json_decode( $result,true);
	    $data = $data['words'];

	    //提取word一列
	    $words = array_column($data, 'word');
	    // 关闭CURL
	    curl_close ( $ch );
	    return $words;
	}
}
?>