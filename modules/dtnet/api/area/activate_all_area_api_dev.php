<?php
//lấy tham số uid area
$uid_area = isset($array_param["area"]) ? $array_param["area"] : "";

if ($uid_area == "") exit(json_encode(array("result" => "false", "msg" => "missing_uid")));

//Đọc Thông Tin Area
$this->loadModel("Area");
$array_area = $this->Area->read($uid_area);

// Kiểm tra record có tồn tại không
if (!$array_area) exit(json_encode(array("result" => "false", "msg" => "not_found")));

// Toggle status: nếu status = 1 thì set = 0, nếu status = 0 thì set = 1
$array_area["status"] = ($array_area["status"] == 1) ? 0 : 1;

$this->Area->save($array_area);
echo json_encode(array("result" => "ok", "msg" => "success", "area" => $array_area["uid"]));
