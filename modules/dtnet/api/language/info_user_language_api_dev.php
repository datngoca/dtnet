<?php
$uid_lang = isset($array_param["lang"]) ? $array_param["lang"] : "";

$this->loadModel("LanguageUser");
if ($uid_lang == "") exit(json_encode(array("result" => "false", "msg" => "no_uid_lang")));

$array_lang = $this->LanguageUser->read($uid_lang);

if (!$array_lang) exit(json_encode(array("result" => "false", "msg" => "not_found")));

echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_lang));
