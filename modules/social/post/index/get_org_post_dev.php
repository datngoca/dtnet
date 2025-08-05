<?php
$lang = "";
$parent_str_code = "";
$area_str_code = '';
$uid_street = '';
$uid_org = "";
$data_type = "";
$change_event  = 'change_org_input';


if (isset($_GET['lang'])) $lang = $_GET['lang'];
if (isset($_GET['area'])) $area_str_code = $_GET['area'];
if (isset($_GET['street'])) $uid_street = $_GET['street'];
if (isset($_GET['place'])) $uid_place = $_GET['place'];
if (isset($_GET['org'])) $uid_org = $_GET['org'];
if (isset($_GET['data_type'])) $data_type = $_GET['data_type'];

if ($data_type == "list") $change_event  = 'change_org_list';

$array_org_data = $this->request_api("org", "list", array("lang" => $lang, "area" => $area_str_code, "street" => $uid_street, "place" => $uid_place));
$array_org = isset($array_org_data["data"]) ? $array_org_data["data"] : null;
if ($array_org != null) array_unshift($array_org, array("uid" => "", "name" => "..."));
else $array_org[] = array("uid" => "", "name" => "...");


/* tạo đối tượng html */
$Html = $this->load('html');
$Html->load('Form');

/* tạo selectbox với class và onchange phù hợp */
echo $Html->Form->selectbox(array(
    "name" => "data[uid_org]",
    "class" => "select_org_$data_type",
    "onchange" => "$change_event(this.value)",
    "style" => "width:100%"
), $array_org, $uid_org);
