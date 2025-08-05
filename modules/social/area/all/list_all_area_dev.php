<?php
$parent_str_code = '';
$search = '';
$lang = "";
if (isset($_GET['area'])) $parent_str_code = $_GET['area'];
if (isset($_GET['search'])) $search = $_GET['search'];
if (isset($_GET['lang'])) $lang = $_GET['lang'];


/* tạo đối tượng html */
$Html = $this->load('html');
$Html->load('Form');

/* Tạo đối tượng html table */
$Html->load('Table');


$table_row = '';

/* tạo đối tượng liên kết với bảng user_area, Đọc DL từ bảng user_area */
// $this->loadModel('AreaUser');
// if ($parent_str_code != '') $this->AreaUser->cond("parent_str_code", $parent_str_code);
// if ($search != '') $this->AreaUser->search("name", $search);
// if ($lang != '') $this->AreaUser->cond("lang", $lang);
// $this->AreaUser->cond("sent", "1");
// $array_area_users = $this->AreaUser->get();

$array_area_users_data = $this->request_api("area", "list_all", ["search" => $search, "parent" => $parent_str_code, "lang" => $lang]);
$array_area_users = isset($array_area_users_data["data"]) ? $array_area_users_data["data"] : [];

$stt = 0;
if ($array_area_users != null) {
    foreach ($array_area_users as $row) {
        $stt++;
        $id = $row["id"];
        $uid_user_area = $row["uid"];

        /*name, code, des*/
        $name = $row['name'];
        $code = $row['code'];


        /*type*/
        $type_name = $row['type_name'];
        $type_code = $row['type_code'];
        $str_type = $Html->span("$type_name($type_code)", "class = 'des'");


        $str_name = $Html->span($name, " id ='area_name_$uid_user_area'");
        $str_name .= " - " . $code;
        $str_name .= "</br>" . $str_type;

        /*parent*/
        $parent_str_name = $Html->span($row['parent_str_name'], " id ='parent_str_name_$uid_user_area'");
        $parent_str_code = $Html->span($row['parent_str_code'], " id ='parent_str_code_$uid_user_area' class = 'des2'");
        $str_parent = $parent_str_name . "<br>" . $parent_str_code;

        /*span_activate*/
        $status = $row['status'];
        $status_data = $status == "1" ? "Activated" : "Unactivated";
        // if ($status == "1") $str_status = "Activated";
        $span_status = $Html->span($status_data, " class ='des3'");

        /*str_status, des, lang*/
        $str_status = $span_status;
        $des = $row['des'];
        $lang = $row['lang'];

        /*user_fullname*/
        $created = date("H:i d-m-Y", strtotime($row['created']));
        $str_user =  "<span class ='des'>$created</span>";


        /*detail*/
        $button_detail = $Html->Form->button(array("class" => "view", "onclick" => "show_area_info('$uid_user_area')"), "View");
        $table_row .= $Html->Table->row(array($stt, $str_name, $str_parent, $str_status, $lang, $button_detail));
    }
} else {
    $table_row = $Html->Table->row(array(array("No data", "colspan = '7'")));
}

$table_header = $Html->Table->row_header(array("Stt", "Name", "In Area", "Status", "Lang", "View"));
echo $Html->Table->get($table_header . $table_row);
