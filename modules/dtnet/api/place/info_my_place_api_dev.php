<?php
$uid_place = isset($array_param["place"]) ? $array_param["place"] : "";

$this->loadModel("PlaceUser");
if ($uid_place == "") exit(json_encode(array("result" => "false", "msg" => "not_found")));

$array_place_user = $this->PlaceUser->read($uid_place);

echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_place_user));
