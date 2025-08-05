<?php


$lang = "";
$parent_str_code = "";
$area_str_code = '';
$uid_street = '';
$data_type = "";
$change_event  = 'change_street_input';


if (isset($_GET['lang'])) $lang = $_GET['lang'];
if (isset($_GET['area'])) $area_str_code = $_GET['area'];
if (isset($_GET['parent'])) $parent_str_code = $_GET['parent'];
if (isset($_GET['street'])) $uid_street = $_GET['street'];
if (isset($_GET['data_type'])) $data_type = $_GET['data_type'];

if ($data_type == "list") $change_event  = 'change_street_list';

$array_street_data = $this->request_api("street", "list", array("area" => $area_str_code, "parent" => $parent_str_code, "lang" => $lang, "data_type" => $data_type));
$array_street = isset($array_street_data["data"]) ? $array_street_data["data"] : null;
if ($array_street != null) array_unshift($array_street, array("uid" => "", "name" => "..."));
else $array_street[] = array("uid" => "", "name" => "...");


/* tạo đối tượng html */
$Html = $this->load('html');
$Html->load('Form');

/* tạo selectbox với class và onchange phù hợp */
echo $Html->Form->selectbox(array(
    "name" => "data[uid_street]",
    "class" => "select_street_$data_type",
    "onchange" => "$change_event(this.value)",
    "style" => "width:100%"
), $array_street, $uid_street);
