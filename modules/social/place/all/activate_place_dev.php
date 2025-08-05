<?php
/* kiểm tra khu vực có hợp lệ? */
$uid_place = '';
if (isset($_GET['place'])) $uid_place = $_GET['place'];
if ($uid_place  == '') exit(json_encode(array("result" => "false", "msg" => "invalid")));

$array_activate = $this->request_api("place", "activate", ["place" => $uid_place]);

exit($array_activate);
