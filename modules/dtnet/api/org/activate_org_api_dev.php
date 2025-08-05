<?php
//lấy tham số uid org
$uid_org = isset($array_param["org"]) ? $array_param["org"] : "";

if ($uid_org == "") exit(json_encode(array("result" => "false", "msg" => "missing_uid")));

//lưu thông tin org vào bảng org
$this->loadModel("Org");
$array_org = $this->Org->read($uid_org);

// Kiểm tra record có tồn tại không
if (!$array_org) exit(json_encode(array("result" => "false", "msg" => "not_found")));

// Toggle status: nếu status = 1 thì set = 0, nếu status = 0 thì set = 1
$array_org["status"] = ($array_org["status"] == "1") ? "0" : "1";

$this->Org->save($array_org);
echo json_encode(array("result" => "ok", "msg" => "activated", "data" => array("org" => $uid_org)));
