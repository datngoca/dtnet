<?php
$uid_street = isset($array_param["street"]) ? $array_param["street"] : "";
$this->loadModel("StreetUser");
if ($uid_street == "") exit(json_encode(array("result" => "false", "msg" => "no_uid")));

$array_street_user = $this->StreetUser->read($uid_street);
if (!$array_street_user) exit(json_encode(array("result" => "false", "msg" => "invalid_data")));

$array_street_user['status'] = "3";

$this->StreetUser->save($array_street_user);
echo json_encode(array("result" => "ok", "msg" => "delete_ok"));
