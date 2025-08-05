<?php
$area_str_code = '';
$search = '';
$lang = "";
$street = "";
$place_in = "";
if (isset($_GET['area'])) $area_str_code = $_GET['area'];
if (isset($_GET['search'])) $search = $_GET['search'];
if (isset($_GET['lang'])) $lang = $_GET['lang'];
if (isset($_GET['street'])) $street = $_GET['street'];
if (isset($_GET['place_in'])) $place_in = $_GET['place_in'];

/* tạo đối tượng html */
$Html = $this->load('html');
$Html->load('Form');

/* Tạo đối tượng html table */
$Html->load('Table');


$table_row = '';

/* tạo đối tượng liên kết với bảng place, Đọc DL từ bảng place */
$array_place_data = $this->request_api("place", "all", ["area" => $area_str_code, "search" => $search, "lang" => $lang, "street" => $street, "place_in" => $place_in]);

$array_place = isset($array_place_data["data"]) ? $array_place_data["data"] : null;
$stt = 0;
if ($array_place != null) {
    foreach ($array_place as $row) {
        $stt++;
        $id = $row["id"];
        $uid_place = $row["uid"];

        /*name, code, des*/
        $name = $row['name'];
        $code = $row['code'];


        /*str name*/
        $str_name = $Html->span($name, " id ='place_name_$uid_place'");
        $str_name .= " - " . $code;

        /*parent*/
        $area_str_name = $Html->span($row['area_str_name'], " id ='area_str_name_$uid_place'");
        $area_str_code = $Html->span($row['area_str_code'], " id ='area_str_code_$uid_place' class = 'des2'");
        $str_area = $area_str_name . "<br>" . $area_str_code;

        /*span_status*/
        $status = $row['status'];
        $str_status = "Inactive";
        if ($status == "1") $str_status = "Active";
        $span_status = $Html->span($str_status, " class ='des2'");

        /*span_approved*/
        $approved = $row['approved'];
        $str_approved = "Unapproved";
        if ($approved == "1") $str_approved = "Approved";
        $span_approved = $Html->span($str_approved, " class ='des3'");

        /*str_status*/
        $str_status_full = $span_status . "<br>" . $span_approved;

        $des     = $row['des'];

        $lang = $row['lang'];

        $str_street = $row['street_name'];


        /*detail*/
        $button_view = $Html->Form->button(array("class" => "view", "onclick" => "show_place_info('$uid_place')"), "View");
        $table_row .= $Html->Table->row(array($stt, $lang, $str_name, $str_area, $str_street, $str_status_full, $button_view));
    }
} else {
    $table_row = $Html->Table->row(array(array("No data", "colspan = '6'")));
}




$table_header = $Html->Table->row_header(array("Stt", "Lang", "Name", "In Area", "Street", "Status", "Activate"));
echo $Html->Table->get($table_header . $table_row);
