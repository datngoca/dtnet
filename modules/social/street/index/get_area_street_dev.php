<?php
/* lấy các khu vực user được phân quyền */
//$array_area_setting = $this->request_api("area","list_setting", $this->CurrentUser->uid);

/*$array_area_setting = $this->request_api("area","get_parent", null, false);
	echo $array_area_setting;

	if ($array_area_setting == null) exit(json_encode(array("result"=>"false","msg"=> "no_area_setting")));
	$array_area_root = null;
	if (isset($array_area_setting['data'])) $array_area_root =$array_area_setting['data'];
	if ($array_area_root == null) exit(json_encode(array("result"=>"false","msg"=> "no_area_data")));*/

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
if (isset($_GET["parent"])) $parent_str_code = $_GET["parent"];


/*onchange event*/
$change_event  = 'change_area_input';

$source = "";
if (isset($_GET["source"])) $source = $_GET["source"];
if ($source == "list") $change_event  = 'change_area_list';
if ($source == "cross") $change_event  = 'change_area_cross';



if (isset($_GET["debug"]) && ($_GET["debug"] == "api")) exit($this->request_api("area", "get_parent", array("area" => $str_area_code, "parent" => $parent_str_code, "lang" => $lang), false));



//if ($parent_str_code == '') exit(json_encode(array("result"=>"false","msg"=> "no_parent_area")));
//if (!isset($array_area_root[$parent_str_code])) exit(json_encode(array("result"=>"false","msg"=> "invalid_parent")));

/*lấy thông tin khu vực */
$array_area_result = $this->request_api("area", "get_parent", array("area" => $str_area_code, "parent" => $parent_str_code, "lang" => $lang));


if (!isset($array_area_result["data"])) exit(json_encode(array("result" => "false", "msg" => "no_area")));
$array_areas = $array_area_result["data"];

/*đưa dữ liệu khu vực thành selectbox*/
$str_selectbox_area = "";

$str_class = "";
if ($source != "") $str_class = "_" . $source;

if ($array_areas) {
    foreach ($array_areas as $row) {
        $str_selectbox_area .= $Html->Form->selectbox(array("onchange" => "$change_event(this.value)", "class" => "select_area" . $str_class), $row["area"], $row["selected"]);
    }
}

$area_parent = "";
if ($parent_str_code != '')  $area_parent = $array_area_result['parent_str_name'];


echo $area_parent . $str_selectbox_area;
