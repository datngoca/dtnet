<?php
//lấy tham số uid language
$uid_lang = isset($_GET["lang"]) ? $_GET["lang"] : "";
if ($uid_lang == "") return $this->redirect(array("controller" => "lang", "function" => "index", "get" => "msg=no_uid_lang"));

$array_result = $this->request_api("language", "delete_my", ["lang" => $uid_lang], false);

exit($array_result);
