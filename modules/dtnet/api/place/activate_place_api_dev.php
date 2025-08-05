<?php
//lấy tham số uid place
$uid_place = isset($array_param["place"]) ? $array_param["place"] : "";

if ($uid_place == "") exit(json_encode(array("result" => "false", "msg" => "missing_uid")));

//lưu thông tin place vào bảng place
$this->loadModel("Place");
$array_place = $this->Place->read($uid_place);

// Kiểm tra record có tồn tại không
if (!$array_place) exit(json_encode(array("result" => "false", "msg" => "not_found")));

// Toggle status: nếu status = 1 thì set = 0, nếu status = 0 thì set = 1
$array_place["status"] = ($array_place["status"] == 1) ? 0 : 1;

$this->Place->save($array_place);
echo json_encode(array("result" => "ok", "msg" => "activated", "place" => $array_place["uid"]));
