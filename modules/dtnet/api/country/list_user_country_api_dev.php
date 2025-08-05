<?php
$search = isset($array_param["search"]) ? $array_param["search"] : "";
$approved = isset($array_param["approved"]) ? $array_param["approved"] : "";
$lang = isset($array_param["lang"]) ? $array_param["lang"] : "";
$this->loadModel("CountryUser");

if ($search != "") $this->CountryUser->search(array("name", "code", "des"), $search);
if ($approved != "") $this->CountryUser->cond("approved", $approved);
if ($lang != "") $this->CountryUser->cond("lang", $lang);

$this->CountryUser->cond("status", "3", array("compare" => "<>"));

$this->CountryUser->order = "modified DESC";
$array_country_user = $this->CountryUser->get();

echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_country_user));
