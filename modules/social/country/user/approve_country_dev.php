<?php
//lấy tham số uid country
$uid_country = isset($_GET["country"]) ? $_GET["country"] : "";

if ($uid_country == "") return $this->redirect(array("controller" => "country", "function" => "user", "get" => "msg=no_uid"));

$array_result = $this->request_api("country", "approve_user", ["country" => $uid_country], false);
exit($array_result);
