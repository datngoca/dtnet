<?php
/* kiểm tra khu vực có hợp lệ? */
$uid_user_street = '';
if (isset($_GET['street'])) $uid_user_street = $_GET['street'];
if ($uid_user_street  == '') exit(json_encode(array("result" => "false", "msg" => "no_uid")));

$array_approve = $this->request_api("street", "approve_user", ["street" => $uid_user_street], false);

exit($array_approve);
