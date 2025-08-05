<?php
$search = isset($array_param["search"]) ? $array_param["search"] : "";
$lang = isset($array_param["lang"]) ? $array_param["lang"] : "";

$this->loadModel("Countries");

if ($search != "") $this->Countries->search(array("name", "code", "des"), $search);
if ($lang != "") $this->Countries->cond("lang", $lang);
$this->Country->fields = "code, name, des_short,  uid, des, id,  approved, status, order_number";

if ($lang == "") exit(json_encode(array("result" => "false", "msg" => "no_lang")));
$this->Countries->cond("status", "1");
$this->Countries->cond("approved", "1");

$this->Countries->order = "modified DESC";
$array_country = $this->Countries->get();

echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_country));
