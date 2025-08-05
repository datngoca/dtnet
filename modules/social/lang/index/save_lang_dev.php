<?php
function validate($param_check)
{
    if ($param_check == NULL) return array("result" => "false", "msg" => "no_data");
    if (!isset($param_check["name"]) || ($param_check["name"] == "")) return array("result" => "false", "msg" => "no_name");
    if (!isset($param_check["code"]) || $param_check["code"] == "") return array("result" => "false", "msg" => "no_code");
    if (!isset($param_check["lang"])) return array("result" => "false", "msg" => "no_lang");
    if (!isset($param_check["des"])) return array("result" => "false", "msg" => "no_des");
    return array("result" => "ok", "msg" => "");
}

$array_lang = $_POST["data"];

/*check data*/
$check = validate($array_lang);
// if ($check["result"] != "ok") exit(json_encode(array("result" => "false", "msg" => $check["msg"])));
if ($check["result"] != "ok") return $this->redirect(array("controller" => "lang", "function" => "index", "get" => "msg= " . $check["msg"]));


$array_result = $this->request_api("language", "save_my", array("array_lang_user" => $array_lang), false);
exit($array_result);
