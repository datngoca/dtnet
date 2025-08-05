<?php


/* kiểm tra khu vực có hợp lệ? */
$uid_user_area = '';
if (isset($_GET['area'])) $uid_user_area = $_GET['area'];
if ($uid_user_area  == '') exit(json_encode(array("result" => "false", "msg" => "invalid")));

//request api
// $str_approve = $this->request_api("area", "approve_user", ["area" => $uid_user_area], false);
// echo "str_approve: $str_approve";
// $array_approve = json_decode($str_approve, true);
$array_approve = $this->request_api("area", "approve_user", ["area" => $uid_user_area]);

exit($array_approve);
