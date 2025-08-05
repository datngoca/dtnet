<?php
$uid_area = isset($array_param["area"]) ? $array_param["area"] : "";
$this->loadModel("AreaUser");
if ($uid_area == "") exit(json_encode(array("result" => "false", "msg" => "not_found")));

$array_area_user = $this->AreaUser->read($uid_area);
$array_area_user['status'] = "3";

$this->AreaUser->save($array_area_user);
echo json_encode(array("result" => "ok", "msg" => "deleted"));
