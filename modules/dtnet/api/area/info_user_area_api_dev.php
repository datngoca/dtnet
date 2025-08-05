<?php
$uid_area = isset($array_param["area"]) ? $array_param["area"] : "";

$this->loadModel("AreaUser");
if ($uid_area == "") exit(json_encode(array("result" => "false", "msg" => "not_found")));

$array_area_user = $this->AreaUser->read($uid_area);

echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_area_user));
