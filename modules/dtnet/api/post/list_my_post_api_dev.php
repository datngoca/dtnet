<?php
$this->loadModel("PostUser");

$search = isset($array_param["search"]) ? $array_param["search"] : "";
$area_str_code = isset($array_param["area"]) ? $array_param["area"] : "";
$lang = isset($array_param["lang"]) ? $array_param["lang"] : "";
$uid_place = isset($array_param["place"]) ? $array_param["place"] : "";
$type = isset($array_param["type"]) ? $array_param["type"] : "";
$category = isset($array_param["category"]) ? $array_param["category"] : "";

if ($area_str_code != '') {
    $str_cross_check = str_replace("/", "\\\\\/", $area_str_code);
    $this->PostUser->search(array("area_str_code" => $area_str_code));
}
if ($search != '') $this->PostUser->search("title", $search);
if ($lang != '') $this->PostUser->cond("lang", $lang);
if ($uid_place != '') $this->PostUser->cond("uid_place", $uid_place);
if ($type != '') $this->PostUser->cond("type", $type);
if ($category != '') $this->PostUser->cond("category", $category);

$this->PostUser->cond("id_user", $this->CurrentUser->id);
$this->PostUser->cond("status", "3", array("compare" => "<>"));
$this->PostUser->order = "modified DESC";
$array_post_users = $this->PostUser->get();

echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_post_users));
