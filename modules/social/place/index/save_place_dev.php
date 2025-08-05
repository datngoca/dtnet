<?php

$array_data = $_POST['data'];

if (!isset($array_data["lang"])) exit(json_encode(array("result" => "false", "msg" => "no_lang")));
if (!isset($array_data["area_str_code"])) exit(json_encode(array("result" => "false", "msg" => "no_area_str_code")));
if (!isset($array_data["uid_street"])) exit(json_encode(array("result" => "false", "msg" => "no_street")));
if (!isset($array_data["place_in"])) exit(json_encode(array("result" => "false", "msg" => "no_place_in")));
if (!isset($array_data["place"])) exit(json_encode(array("result" => "false", "msg" => "no_place")));

if (!isset($array_data["name"]) || $array_data["name"] == "") exit(json_encode(array("result" => "false", "msg" => "no_name")));
if (!isset($array_data["code"])) exit(json_encode(array("result" => "false", "msg" => "no_code")));

$array_result = $this->request_api("place", "save_my", $array_data);

exit($array_result);
