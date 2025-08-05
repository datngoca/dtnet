<?php
function get_array_area($type = "", $array_area_code = null, $parent_str_code = "", $Area, $lang = "")
{
    $array_empty = array("str_code" => $parent_str_code, "name" => "...");

    /*extension*/
    $ext = "";
    if (isset($_REQUEST["ext"])) $ext = $_REQUEST["ext"];
    if ($ext != "") $ext .= "_";

    /*area root*/
    $Area->fields = "str_code, name, str_code as des, CONCAT(uid,'|||||', str_name, '|||||',str_address,'|||||',name_address) as data";
    $Area->index = "str_code";
    $Area->cond("parent_str_code", $parent_str_code);
    $Area->cond("lang", $lang);
    $Area->cond("approved", '1');
    $Area->cond("status", '1');

    $array_area_root = $Area->get();
    if ($array_area_root == NULL)  $array_area_root = array("0" => $array_empty);
    else array_unshift($array_area_root, $array_empty);

    //echo "view array_area_root: $parent_str_code <br>";
    //print_r($array_area_root);
    //echo "<br>***<br><br>";

    /*data return: first item*/
    $str_id = $ext . "in_" . str_replace("/", "_", $parent_str_code);

    /*data result*/
    $array_data_result = NULL;
    $array_data_result[0]  =  array("area" => $array_area_root, 'parent' => $parent_str_code, "selected" => '', "id" => $str_id, "type" => "array");

    //echo "array_area_code: <br>";
    //print_r($array_area_code);
    //echo "<br>***<br><br>";


    /*array_area_code has no item */
    if ($array_area_code == null) return $array_data_result;

    //echo "<br>no null dataa <br><br>";
    //echo "\n<br> parent_str_code: $parent_str_code\n<br>";


    /*get first area*/
    $first_area = $parent_str_code;
    if (isset($array_area_code[0])) $first_area .= "/" . $array_area_code[0];

    /*update selected first area*/
    $array_data_result[0]['selected']  =  $first_area;

    $num_area = count($array_area_code);
    $str_code_check = $parent_str_code;
    $i = 0;
    for ($i = 0; $i < $num_area; $i++) {
        /*check current area_code & get str_area*/
        $area_code = $array_area_code[$i];
        if ($str_code_check == "") $str_code_check = $area_code;
        else $str_code_check .= "/" . $area_code;

        $GLOBALS["str_debug"] .= "<br>*****-- str_code_check $i: $str_code_check *****-- <br>";

        /*lấy id cho dữ liệu*/
        $str_id = $ext . "in_" . str_replace("/", "_", $str_code_check);

        /*truy vấn dữ liệu nhóm bài viết*/
        $Area->fields = "str_code, name, des_short, CONCAT(uid,'|||||',str_name,'|||||',str_address,'|||||',name_address) as data";
        $Area->cond("parent_str_code", $str_code_check);
        $Area->cond("lang", $lang);
        $Area->cond("approved", '1');
        $Area->cond("status", '1');

        $array_area = $Area->get();
        if ($array_area != NULL) {
            /*chèn phần tử trống vào đầu tiên*/
            array_unshift($array_area, array("str_code" => $str_code_check, "name" => "..."));

            $next_area = "";
            if (isset($array_area_code[$i + 1])) $next_area = $array_area_code[$i + 1];

            $selected_area = "";
            if ($next_area != "") $selected_area = $str_code_check . "/" . $next_area;


            $array_data_result[$i + 1]  =  array("area" => $array_area, "selected" => $selected_area, "id" => $str_id, "type" => "array");
        }
        /*end: if($array_area != NULL)*/
    }
    /*end: foreach($array_area_code as $area_code)*/


    return $array_data_result;
}
/*end: function get_array_area()*/


$has_debug = false;
if (isset($array_params["debug"]) && ($array_params["debug"] == "true")) $has_debug = true;

/*country, str_code, parent_str_code*/
$has_country = true;
$str_code = "";
$parent_str_code = "";
$lang = "";
if (isset($array_params["country"]) && ($array_params["country"] == "false")) $has_country = false;
if (isset($array_params["area"])) $str_code = $array_params["area"];
if (isset($array_params["parent"])) $parent_str_code = $array_params["parent"];
if (isset($array_params["lang"])) $lang = $array_params["lang"];
if ($lang == "") $lang = "en";

/*trim "/" */
$str_code = trim($str_code, "/");
$parent_str_code = trim($parent_str_code, "/");
$msg_debug = "<br>debug 1: str_code: $str_code --- parent_str_code: $parent_str_code, , has_country: $has_country, params: " . json_encode($array_params) . " <br>";


$this->loadModel("Area");

/*nếu có parent thì lấy list  title parent*/
$array_country = null;

/*check: client request with parent_str_code*/
$parent_str_name = "";
$country_code = "";
$array_area_code = null;
if ($parent_str_code != "") {

    /*get parent_str_title*/
    $this->Area->fields = "str_name";
    $this->Area->cond("str_code", $parent_str_code);
    $this->Area->cond("lang", $lang);
    $parent_str_name = $this->Area->get_value();

    /*nếu có parent_str_code thì cần phải đảm bảo str_code ít nhất bằng $parent_str_code */
    if (strpos("/$str_code/", "/$parent_str_code/") === false) $str_code = $parent_str_code;

    $str_code = str_replace($parent_str_code, "", $str_code);
    $str_code = trim($str_code, "/");

    $array_area_code = explode("/", $str_code);

    $msg_debug .= "<br>has parent, $str_code <br>";
}/*end: if($str_code_parent != "")*/ else {


    /*explode str_code, get country_code*/
    $array_area_code = explode("/", $str_code);

    if (isset($array_area_code[0])) {

        $country_code = $array_area_code[0];
        $parent_str_code = $country_code;

        array_shift($array_area_code);
        $msg_debug .= "<br> country_code: $country_code <br>";
    }
    $msg_debug .= "<br>no parent,str_code: $str_code, array " . json_encode($array_area_code) . "<br>";
}


$msg_debug .= "<br>debug 2: str_code: $str_code  ---  parent_str_code: $parent_str_code, parent_str_name: $parent_str_name<br>";

/*get all area data*/
$type = "";
$GLOBALS["str_debug"] = "";
$array_area_list = get_array_area($type, $array_area_code, $parent_str_code, $this->Area, $lang);
$msg_debug .= $GLOBALS["str_debug"];

$array_country == null;

/*if user want to get country  */
if ($parent_str_name == "" && $has_country == true) {
    /*$array_country = json_decode($this->Data->read("country", "area"), true);*/

    $msg_debug .= " <br>***check country ***<br>";

    /*get country*/
    $this->loadModel("Country", "countries");
    $this->Country->fields = "code, name, des_short,  CONCAT(uid,'|||||',name) as des, approved, status, order_number";
    $this->Country->order = "status DESC, approved DESC, order_number ASC";

    $this->Country->cond("status", "1");
    $this->Country->cond("approved", "1");
    $this->Country->cond("lang", $lang);
    $array_country = $this->Country->get();

    if ($array_country == null) $array_country[0] = array("code" => "", "name" => "...");
    else  array_unshift($array_country, array("code" => "", "name" => "..."));
} else {
    $msg_debug .= " <br>***no check country ***<br>";
}

if ($array_country != null) {
    $msg_debug .= " have country";

    /*insert country first*/
    if ($array_area_list != null) array_unshift($array_area_list, array("area" => $array_country, "selected" => $country_code, "id" => "country_$country_code"));
    else $array_area_list[] =  array("area" => $array_country, "selected" => $country_code, "id" => "country_$country_code");
} else $msg_debug .= " no country";

if ($has_debug) $parent_str_name = $msg_debug . $parent_str_name;

$array_result = array("result" => "ok", "msg" => "success", "data" => $array_area_list, "parent_str_code" => $parent_str_code, "parent_str_name" => $parent_str_name, "str_code" => $str_code);
//echo "\n<br>***array result<br>\n";
//print_r($array_result);
//echo "<br><br>\n\n";

exit(json_encode($array_result));
