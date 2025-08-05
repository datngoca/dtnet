<?php
function validate($param_check)
{
    if ($param_check == NULL) return array("result" => "false", "msg" => "no_data");
    if (!isset($param_check["lang"]) || ($param_check["lang"] == "")) return array("result" => "false", "msg" => "no_lang");
    if (!isset($param_check["parent_str_code"]) || $param_check["parent_str_code"] == "") return array("result" => "false", "msg" => "no_parent_str_code");
    if (!isset($param_check["code"]) || $param_check["code"] == "") return array("result" => "false", "msg" => "no_code");
    return array("result" => "true", "msg" => "");
}

$array_data = $_POST["data"];

/*check data*/
$check = validate($array_data);
if (!$check["result"]) exit(json_encode(array("result" => "false", "msg" => $check["msg"])));

$array_result = $this->request_api("area", "save_my", array("array_data" => $array_data));

exit($array_result);
