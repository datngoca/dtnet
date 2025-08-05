<?php
//lấy tham số uid post
$uid_post = isset($array_param["post"]) ? $array_param["post"] : "";

if ($uid_post == "") exit(json_encode(array("result" => "false", "msg" => "missing_uid")));

//lưu thông tin post vào bảng post
$this->loadModel("Post");
$array_post = $this->Post->read($uid_post);

// Kiểm tra record có tồn tại không
if (!$array_post) exit(json_encode(array("result" => "false", "msg" => "not_found")));

// Toggle status: nếu status = 1 thì set = 0, nếu status = 0 thì set = 1
$array_post["status"] = ($array_post["status"] == "1") ? "0" : "1";

$this->Post->save($array_post);
echo json_encode(array("result" => "ok", "msg" => "activated", "data" => array("post" => $uid_post)));
