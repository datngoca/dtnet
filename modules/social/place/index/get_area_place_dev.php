<?php


$Html = $this->load("Html");
$Html->load("Form");

/*area_code, lang */
$str_area_code  = "";
if (isset($_GET["area"])) $str_area_code = $_GET["area"];
if ($str_area_code == 'undefined') $str_area_code = "vietnam";

$lang = "";
if (isset($_GET["lang"])) $lang = $_GET["lang"];
if ($lang == '') $str_area_code = "";

/*save area to cookie*/
$this->Cookie->set('area', $str_area_code);


$parent_str_code = '';
$change_event  = 'change_area_input';
$data_type = "";

if (isset($_GET["parent"])) $parent_str_code = $_GET["parent"];
if (isset($_GET["data_type"])) $data_type = $_GET["data_type"];

if ($data_type == "list") $change_event  = 'change_area_list';


if (isset($_GET["debug"]) && ($_GET["debug"] == "api")) exit($this->request_api("area", "get_parent", array("area" => $str_area_code, "parent" => $parent_str_code, "lang" => $lang), false));


/*lấy thông tin khu vực */
$array_area_result = $this->request_api("area", "get_parent", array("area" => $str_area_code, "parent" => $parent_str_code, "lang" => $lang));


if (!isset($array_area_result["data"])) exit(json_encode(array("result" => "false", "msg" => "no_area")));
$array_areas = $array_area_result["data"];

/*đưa dữ liệu khu vực thành selectbox*/
$str_selectbox_area = "";
if ($array_areas) {
    foreach ($array_areas as $row) {
        $str_selectbox_area .= $Html->Form->selectbox(array("onchange" => "$change_event(this.value)", "class" => "select_area_$data_type"), $row["area"], $row["selected"]);
    }
}

$area_parent = "";
if ($parent_str_code != '')  $area_parent = $array_area_result['parent_str_name'];

echo $area_parent . $str_selectbox_area;
