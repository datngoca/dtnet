<?php

$this->loadModel("Area");

/*uid*/
$uid_area = "";
if (isset($array_area["area"])) $uid_area = $array_area["area"];
if ($uid_area != "")    exit(json_encode($this->Area->read($uid_area)));

/*request by str code*/
$area_str_code = "";
$lang = "";

if (isset($array_area["str_code"])) $area_str_code = $array_area["str_code"];
if (isset($array_area["lang"])) $lang = $array_area["lang"];

if ($area_str_code == "") exit("no_area");
if ($lang == "") exit("no_lang");

$this->Area->cond("str_code", $area_str_code);
$this->Area->cond("lang", $lang);

$array_area = $this->Area->get();
if (isset($array_area[0])) $array_area = $array_area[0];
exit(json_encode($array_area));
