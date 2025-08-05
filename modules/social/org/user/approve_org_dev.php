<?php
/* kiểm tra khu vực có hợp lệ? */
$uid_user_place = '';
if (isset($_GET['org'])) $uid_user_org = $_GET['org'];
if ($uid_user_org  == '') exit(json_encode(array("result" => "false", "msg" => "invalid")));

$array_approve = $this->request_api("org", "approve_user", ["org" => $uid_user_org], false);
exit($array_approve);
