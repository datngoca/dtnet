<?php
//lấy tham số uid language
$uid_lang = isset($array_param["lang"]) ? $array_param["lang"] : "";

if ($uid_lang == "") exit(json_encode(array("result" => "false", "msg" => "no_uid")));

//lưu thông tin language vào bảng language
$this->loadModel("Language");
$array_lang = $this->Language->read($uid_lang);

// Kiểm tra record có tồn tại không
if (!$array_lang) exit(json_encode(array("result" => "false", "msg" => "not_found")));

// Toggle status: nếu status = 1 thì set = 0, nếu status = 0 thì set = 1
$array_lang["status"] = ($array_lang["status"] == 1) ? 0 : 1;

$this->Language->save($array_lang);
echo json_encode(array("result" => "ok", "msg" => "activated", "data" => ["lang" => $uid_lang]));
