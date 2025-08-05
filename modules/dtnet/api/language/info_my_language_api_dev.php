<?php
$uid_lang = isset($array_param["lang"]) ? $array_param["lang"] : "";

$this->loadModel("LanguageUser");
if ($uid_lang == "") exit(json_encode(array("result" => "false", "msg" => "no_uid")));

$array_lang = $this->LanguageUser->read($uid_lang);

echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_lang));
