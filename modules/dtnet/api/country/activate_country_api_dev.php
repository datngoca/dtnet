<?php
//lấy tham số uid country
$uid_country = isset($array_param["country"]) ? $array_param["country"] : "";

if ($uid_country == "") exit(json_encode(array("result" => "false", "msg" => "no_uid")));

//lưu thông tin country vào bảng country
$this->loadModel("Countries");
$array_country = $this->Countries->read($uid_country);

// Kiểm tra record có tồn tại không
if (!$array_country) exit(json_encode(array("result" => "false", "msg" => "invalid_data")));

// Toggle status: nếu status = 1 thì set = 0, nếu status = 0 thì set = 1
$array_country["status"] = ($array_country["status"] == 1) ? 0 : 1;

$this->Countries->save($array_country);
echo json_encode(array("result" => "ok", "msg" => "update_ok", "data" => array("country" => $array_country["uid"])));
