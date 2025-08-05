<?php
//lấy tham số uid street
$uid_street = isset($_GET["street"]) ? $_GET["street"] : "";

if ($uid_street == "") exit(json_encode(array("result" => "false", "msg" => "no_uid")));

$array_result = $this->request_api("street", "activate", ["street" => $uid_street], false);

exit($array_result);
