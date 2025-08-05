<?php
/* kiểm tra khu vực có hợp lệ? */
$uid_user_place = '';
if (isset($_GET['place'])) $uid_user_place = $_GET['place'];
if ($uid_user_place  == '') exit(json_encode(array("result" => "false", "msg" => "invalid")));

$array_approve = $this->request_api("place", "approve_user", ["place" => $uid_user_place]);

exit($array_approve);
