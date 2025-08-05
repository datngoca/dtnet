<?php
//lấy tham số uid street
$uid_street = isset($array_param["street"]) ? $array_param["street"] : "";

if ($uid_street == "") exit(json_encode(array("result" => "false", "msg" => "no_uid")));

//lưu thông tin street vào bảng street
$this->loadModel("Street");
$array_street = $this->Street->read($uid_street);

// Kiểm tra record có tồn tại không
if (!$array_street) exit(json_encode(array("result" => "false", "msg" => "invalid_data")));

// Toggle status: nếu status = 1 thì set = 0, nếu status = 0 thì set = 1
$array_street["status"] = ($array_street["status"] == 1) ? 0 : 1;

$this->Street->save($array_street);
echo json_encode(array("result" => "ok", "msg" => "update_ok", "data" => array("street" => $array_street["uid"])));
