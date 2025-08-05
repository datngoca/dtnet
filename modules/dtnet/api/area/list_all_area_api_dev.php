<?php
$this->loadModel("Area");

$search = isset($array_param["search"]) ? $array_param["search"] : "";
$parent = isset($array_param["parent"]) ? $array_param["parent"] : "";
$lang = isset($array_param["lang"]) ? $array_param["lang"] : "";

if ($search != '') $this->Area->search("name", $search);
if ($parent != '') $this->Area->cond("parent_str_code", $parent);
if ($lang != '') $this->Area->cond("lang", $lang);

$this->Area->cond("status", "3", array("compare" => "<>"));
$this->Area->order = "modified DESC";
$array_area = $this->Area->get();

echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_area));
