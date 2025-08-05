<?php
$uid_street = isset($array_param["street"]) ? $array_param["street"] : "";

$this->loadModel("StreetUser");
if ($uid_street == "") exit(json_encode(array("result" => "false", "msg" => "no_uid")));

$array_street_user = $this->StreetUser->read($uid_street);
if (!$array_street_user) exit(json_encode(array("result" => "false", "msg" => "invalid_data")));

echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_street_user));
