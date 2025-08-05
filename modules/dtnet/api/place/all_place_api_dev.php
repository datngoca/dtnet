<?php
$this->loadModel("Place");

$search = isset($array_param["search"]) ? $array_param["search"] : "";
$area_str_code = isset($array_param["area"]) ? $array_param["area"] : "";
$uid_street = isset($array_param["street"]) ? $array_param["street"] : "";
$lang = isset($array_param["lang"]) ? $array_param["lang"] : "";
$place_in = isset($array_param["place_in"]) ? $array_param["place_in"] : "";

if ($area_str_code != '') {
    $str_cross_check = str_replace("/", "\\\\\/", $area_str_code);
    $this->Place->search(array("area_str_code" => $area_str_code));
}
if ($search != '') $this->Place->search("name", $search);
if ($lang != '') $this->Place->cond("lang", $lang);
if ($uid_street != '') $this->Place->cond("uid_street", $uid_street);
if ($place_in != '') $this->Place->cond("uid_place_in", $place_in);

$array_place = $this->Place->get();

echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_place));
