<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**

  打印不转义中文的json

  @param [array] $data

 */

function echo_success($data) {

	$json = array(
		'error_code' => 0,
		'data' => $data
	);
    echo json_encode ($json, JSON_UNESCAPED_UNICODE );

}


function echo_failure($error_code,$message) {

	$json = array(
		'error_code' => $error_code,
		'message' => $message
	);
    echo json_encode ( $json, JSON_UNESCAPED_UNICODE );

}



function show_notice($msg,$url="",$mod=HISTORY_BACK){
					$modscript="";
					switch ($mod) {
						case HISTORY_BACK:
						$modscript='window.history.back()';
						break;
						case BACK_REFRESH:
						$modscript="window.location.href=' ".$_SERVER['HTTP_REFERER']."'";
						break;
						case URL_LOCATION:
						$modscript="window.location.href= '".$url."' ";
						break;
					}
						$msg=addslashes($msg);//转义
						$msg=str_replace(PHP_EOL, "", $msg);//讲斜杠替换成"" . PHP_EOL:=windows: \r\n  unix/linux: \n

echo <<<EOF
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>系统提示</title>
</head>
<body>
	<script>
	alert('$msg');
	$modscript
	</script>
</body>
</html>
EOF;
exit;	
}



?>