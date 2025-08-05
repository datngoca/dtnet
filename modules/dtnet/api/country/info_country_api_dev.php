<?php
$uid_country = isset($array_param["country"]) ? $array_param["country"] : "";

$this->loadModel("Countries");
if ($uid_country == "") exit(json_encode(array("result" => "false", "msg" => "no_uid")));

$array_country = $this->Countries->read($uid_country);
if (!$array_country) exit(json_encode(array("result" => "false", "msg" => "invalid_data")));

echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_country));
