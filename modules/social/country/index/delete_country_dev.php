<?php

// Lấy tham số uid_country
$uid_country = isset($_GET["country"]) ? $_GET["country"] : "";

if ($uid_country == "") return exit(json_encode(array("result" => "false", "msg" => "no_uid")));

$array_result = $this->request_api("country", "delete_my", ["country" => $uid_country], false);
exit($array_result);
