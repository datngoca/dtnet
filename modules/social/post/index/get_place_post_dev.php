<?php

/*get params*/

$lang = "";
$area_str_code = '';
$uid_street = '';
$uid_place_in = '';
$search = '';
$data_type = "";
$change_event  = 'change_place_in_input';


if (isset($_GET['lang'])) $lang = $_GET['lang'];
if (isset($_GET['area'])) $area_str_code = $_GET['area'];
if (isset($_GET['street'])) $uid_street = $_GET['street'];
if (isset($_GET['place'])) $uid_place_in = $_GET['place'];
if (isset($_GET['search'])) $search = $_GET['search'];
if (isset($_GET['data_type'])) $data_type = $_GET['data_type'];

if ($data_type == "list") $change_event  = 'change_place_in_list';

$array_param_api = array('lang' => $lang, 'area' => $area_str_code, "street" => $uid_street);

/*get place*/
$array_place_data = $this->request_api("place", "list", $array_param_api);
$array_place = isset($array_place_data["data"]) ? $array_place_data["data"] : null;

if ($array_place != null) array_unshift($array_place, array("uid" => "", "name" => "..."));
else $array_place[] = array("uid" => "", "name" => "...");

/* tạo đối tượng html */
$Html = $this->load('html');
$Html->load('Form');

/* tạo selectbox */
$selectbox_options = array(
    "name" => "data[place_in]",
    "onchange" => "$change_event(this.value)",
    "style" => "width: 100%",
    "class" => "select_place_in_$data_type"
);
echo $Html->Form->selectbox($selectbox_options, $array_place, $uid_place_in);
