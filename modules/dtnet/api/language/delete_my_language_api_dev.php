<?php
$uid_lang = isset($array_param["lang"]) ? $array_param["lang"] : "";
$this->loadModel("LanguageUser");
if ($uid_lang == "") exit(json_encode(array("result" => "false", "msg" => "no_uid")));

$array_lang_user = $this->LanguageUser->read($uid_lang);
$array_lang_user['status'] = "3";

$this->LanguageUser->save($array_lang_user);
echo json_encode(array("result" => "ok", "msg" => "deleted"));
