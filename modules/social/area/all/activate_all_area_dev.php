<?php
//lấy tham số uid language
$uid_area = isset($_GET["area"]) ? $_GET["area"] : "";

if ($uid_area == "") return $this->redirect(array("controller" => "area", "function" => "all", "get" => "msg=no_uid_area"));

$array_result = $this->request_api("area", "activate_all", ["area" => $uid_area]);

exit($array_result);
