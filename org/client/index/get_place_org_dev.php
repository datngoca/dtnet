<?php
$Html = $this->load("Html");
$Html->load("Form");

/*area_code, lang */
$str_area_code  = "";
if (isset($_GET["area"])) $str_area_code = $_GET["area"];

$lang = "";
if (isset($_GET["lang"])) $lang = $_GET["lang"];

$parent_str_code = '';
if (isset($_GET["parent"])) $parent_str_code = $_GET["parent"];

$uid_street = "";
if (isset($_GET["street"])) $uid_street = $_GET["street"];

/*uid_place */
$uid_place  = "";
if (isset($_GET["place"])) $uid_place = $_GET["place"];

/**Data_type event */
$data_type = "input";
if (isset($_GET["data_type"])) $data_type = $_GET["data_type"];

if (isset($_GET["debug"]) && ($_GET["debug"] == "api")) exit($this->request_api("place", "list", array("area" => $str_area_code, "parent" => $parent_str_code, "lang" => $lang, "street" => $uid_street), false));

/*lấy thông tin place */
$array_place_result = null;
if ($str_area_code != '') $array_place_result = $this->request_api("place", "list", array("area" => $str_area_code, "parent" => $parent_str_code, "lang" => $lang, "street" => $uid_street));
if ($array_place_result == null) $array_place_result = array('uid' => '', 'name' => '...');
else array_unshift($array_place_result, array('uid' => '', 'name' => '...'));

/*tạo selectbox place */
$selectbox_place = $Html->Form->selectbox(array("name" => "place", "id" => "select_place_$data_type"), $array_place_result, $uid_place);
echo $selectbox_place;
