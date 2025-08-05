<?php
//lấy tham số uid org
$uid_org = isset($_GET["org"]) ? $_GET["org"] : "";

if ($uid_org == "") return exit(json_encode(array("result" => "false", "msg" => "no_uid")));

$array_result = $this->request_api("org", "activate", ["org" => $uid_org], false);
exit($array_result);
