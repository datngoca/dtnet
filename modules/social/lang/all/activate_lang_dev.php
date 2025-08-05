<?php
//lấy tham số uid language
$uid_lang = isset($_GET["lang"]) ? $_GET["lang"] : "";

if ($uid_lang == "") return exit(json_encode(array("result" => "false", "msg" => "no_uid")));
$array_result = $this->request_api("language", "activate", ["lang" => $uid_lang], false);

exit($array_result);
