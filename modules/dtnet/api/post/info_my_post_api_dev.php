<?php

$array_data = $array_param;

$uid_post = isset($array_data["post"]) ? $array_data["post"] : "";

if ($uid_post == "") exit(json_encode(array("result" => "false", "msg" => "missing_post_id")));

/* Load models */
$this->loadModel('PostUser');

$array_post_user = $this->PostUser->read($uid_post);
echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_post_user));
