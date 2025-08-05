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

$uid_street = '';
if (isset($_GET["street"])) $uid_street = $_GET["street"];

/**Data_type event */
$change_event  = 'change_street_input';
$data_type = "";
if (isset($_GET["data_type"])) $data_type = $_GET["data_type"];
if ($data_type == "list") $change_event  = 'change_street_list';

if (isset($_GET["debug"]) && ($_GET["debug"] == "api")) exit($this->request_api("street", "list", array("area" => $str_area_code, "parent" => $parent_str_code, "lang" => $lang), false));

/*lấy dữ liệu street */
$array_street_result = $this->request_api("street", "list", array("area" => $str_area_code, "parent" => $parent_str_code, "lang" => $lang));
if ($array_street_result == null) $array_street_result = array('uid' => '', 'name' => '...');
else array_unshift($array_street_result, array('uid' => '', 'name' => '...'));

/*đưa dữ liệu khu vực thành selectbox*/
$selectbox_street = $Html->Form->selectbox(array("name" => "street", "onchange" => "$change_event(this.value)", "id" => "select_street_$data_type"), $array_street_result, $uid_street);
echo $selectbox_street;
