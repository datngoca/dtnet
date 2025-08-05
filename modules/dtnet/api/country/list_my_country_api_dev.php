<?php
$search = isset($array_param["search"]) ? $array_param["search"] : "";
$lang = isset($array_param["lang"]) ? $array_param["lang"] : "";

$this->loadModel("CountryUser");

if ($search != "") $this->CountryUser->search(array("name", "code", "des"), $search);
if ($lang != "") $this->CountryUser->cond("lang", $lang);

$this->CountryUser->cond("id_user", $this->CurrentUser->id);
$this->CountryUser->cond("status", "3", array("compare" => "<>"));

$this->CountryUser->order = "modified DESC";
$array_country_user = $this->CountryUser->get();

echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_country_user));
