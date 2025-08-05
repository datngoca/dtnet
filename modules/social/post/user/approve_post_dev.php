<?php
//lấy tham số uid country
$uid_post = isset($_GET["post"]) ? $_GET["post"] : "";

if ($uid_post == "") return exit(json_encode(array("result" => "false", "msg" => "no_uid")));

$array_result = $this->request_api("post", "approve_user", ["post" => $uid_post], false);
exit($array_result);
