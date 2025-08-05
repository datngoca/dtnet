<?php
$this->loadModel("PlaceUser");

$search = isset($array_param["search"]) ? $array_param["search"] : "";
$area_str_code = isset($array_param["area"]) ? $array_param["area"] : "";
$lang = isset($array_param["lang"]) ? $array_param["lang"] : "";
$street = isset($array_param["street"]) ? $array_param["street"] : "";
$place_in = isset($array_param["place_in"]) ? $array_param["place_in"] : "";

if ($area_str_code != '') {
    $str_cross_check = str_replace("/", "\\\\\/", $area_str_code);
    $this->PlaceUser->search(array("area_str_code" => $area_str_code));
}
if ($search != '') $this->PlaceUser->search("name", $search);
if ($lang != '') $this->PlaceUser->cond("lang", $lang);
if ($street != '') $this->PlaceUser->cond("uid_street", $street);
if ($place_in != '') $this->PlaceUser->cond("uid_place_in", $place_in);

$this->PlaceUser->cond("status", "3", array("compare" => "<>"));
$this->PlaceUser->order = "modified DESC";
$array_place_users = $this->PlaceUser->get();

echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_place_users));
