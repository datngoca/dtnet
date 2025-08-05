<?php
$uid_area = isset($array_param["area"]) ? $array_param["area"] : "";

$this->loadModel("Area");
if ($uid_area == "") exit(json_encode(array("result" => "false", "msg" => "not_found")));

$array_area = $this->Area->read($uid_area);

echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_area));
