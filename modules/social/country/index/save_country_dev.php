<?php

function validate($param_check)
{
    if ($param_check == NULL) return array("result" => "false", "msg" => "invalid_data");
    // if (!isset($param_check["uid"])) return array("result" => "false", "msg" => "no_uid");
    if (!isset($param_check["name"]) || ($param_check["name"] == "")) return array("result" => "false", "msg" => "no_name");
    if (!isset($param_check["code"]) || $param_check["code"] == "") return array("result" => "false", "msg" => "no_code");
    if (!isset($param_check["lang"]) || $param_check["lang"] == "") return array("result" => "false", "msg" => "no_lang");
    if (!isset($param_check["des"])) return array("result" => "false", "msg" => "no_des");
    return array("result" => "ok", "msg" => "");
}

$array_country = $_POST["data"];

/*check data*/
$check = validate($array_country);
if ($check["result"] != "ok") return exit(json_encode(array("result" => "false", "msg" => $check["msg"])));

$str_result = $this->request_api("country", "save_my", $array_country, false);

exit($str_result);
