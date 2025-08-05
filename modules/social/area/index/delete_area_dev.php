<?php
//lấy tham số uid language
$uid_lang = isset($_GET["area"]) ? $_GET["area"] : "";
if ($uid_lang == "") return $this->redirect(array("controller" => "area", "function" => "index", "get" => "msg=no_uid_area"));

$array_result = $this->request_api("area", "delete_my", ["lang" => $uid_lang]);

$msg = isset($array_result["msg"]) ? $array_result["msg"] : "";

$this->redirect(array("controller" => "area", "function" => "index", "get" => "msg=$msg"));
