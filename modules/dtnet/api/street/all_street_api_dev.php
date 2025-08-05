<?php
$this->loadModel("Street");

$search = isset($array_param["search"]) ? $array_param["search"] : "";
$area_str_code = isset($array_param["area"]) ? $array_param["area"] : "";
$lang = isset($array_param["lang"]) ? $array_param["lang"] : "";

if ($search != '') $this->Street->search("name", $search);
if ($area_str_code != '') {
    $str_cross_check = str_replace("/", "\\\\\/", $area_str_code);
    $this->Street->search(array("area_str_code" => $area_str_code, "str_cross" => $str_cross_check));
}
if ($lang != '') $this->Street->cond("lang", $lang);

$array_street = $this->Street->get();

echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_street));
