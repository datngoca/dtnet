<?php
$uid_lang = isset($array_param["lang"]) ? $array_param["lang"] : "";

$this->loadModel("Language");
if ($uid_lang == "") exit(json_encode(array("result" => "false", "msg" => "no_uid")));
$array_lang = $this->Language->read($uid_lang);

echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_lang));
