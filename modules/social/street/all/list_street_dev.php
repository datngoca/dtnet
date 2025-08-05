<?php


$area_str_code = '';
$search = '';
$lang = "";
if (isset($_GET['area'])) $area_str_code = $_GET['area'];
if (isset($_GET['search'])) $search = $_GET['search'];
if (isset($_GET['lang'])) $lang = $_GET['lang'];

/* tạo đối tượng html */
$Html = $this->load('html');

$Form = $Html->load('Form');

/* Tạo đối tượng html table */
$Table = $Html->load('Table');

$str_cross_check = str_replace("/", "\\\\\/", $area_str_code);

/* tạo đối tượng liên kết với bảng user_area, Đọc DL từ bảng user_area */
// $this->loadModel('StreetUser');
// if ($area_str_code != '') $this->StreetUser->search(array("area_str_code" => $area_str_code, "str_cross" => $str_cross_check));
// if ($search != '') $this->StreetUser->search(array("name", "code"), $search);
// if ($lang != '') $this->StreetUser->cond("lang", $lang);
// $this->StreetUser->cond("sent", "1");

// $this->StreetUser->limit = "150";
// $array_user_street = $this->StreetUser->get();

$array_user_street_data = $this->request_api("street", "all", ["search" => $search, "area" => $area_str_code, "lang" => $lang]);
$array_user_street = isset($array_user_street_data["data"]) ? $array_user_street_data["data"] : null;

$stt = 0;
$table_row = '';
if ($array_user_street != null) {
    foreach ($array_user_street as $row) {
        $stt++;
        $id = $row["id"];
        $uid_street_user = $row["uid"];

        $lang = $row['lang'];

        /*name, code, des*/
        $name = $row['name'];
        $code = $row['code'];

        /*str name*/
        $str_name = $Html->span($name, " id ='street_name_$uid_street_user'");
        $str_name .= " - " . $code;

        /*parent*/
        $area_str_name = $Html->span($row['area_str_name'], " id ='area_str_name_$uid_street_user'");
        $area_str_code = $Html->span($row['area_str_code'], " id ='area_str_code_$uid_street_user' class = 'des2'");
        $str_area = $area_str_name . "<br>" . $area_str_code;

        /*span_approve*/
        $status = $row['status'];
        $str_active = "Unactivate";
        if ($status == "1") $str_active = "Actiave";
        $span_status = $Html->span($str_active, " class ='des3'");

        /*str_status*/
        $str_status =  $span_status;

        $des     = $row['des'];

        $lang = $row['lang'];


        /*detail*/
        $button_detail = $Form->button(array("class" => "view", "onclick" => "show_street_info('$uid_street_user')"), "View");


        $table_row .= $Table->row(array($stt, $lang, $str_name, $str_area, $str_status, $button_detail));
    }
} else {
    $table_row = $Table->row(array(array("No data", "colspan = '6'")));
}


$table_header = $Table->row_header(array("Stt", "Lang", "Name", "In Area", "Status", "View"));



echo $Html->heading('User Input');
echo $Table->get($table_header . $table_row);
