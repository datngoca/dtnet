<?php
$area_str_code = '';
$search = '';
$lang = "";
$street = "";
$place = "";
<<<<<<< HEAD

=======
$post = '';
>>>>>>> ecb0f9b (updated from huy's computer)
if (isset($_GET['area'])) $area_str_code = $_GET['area'];
if (isset($_GET['search'])) $search = $_GET['search'];
if (isset($_GET['lang'])) $lang = $_GET['lang'];
if (isset($_GET['street'])) $street = $_GET['street'];
if (isset($_GET['place'])) $street = $_GET['place'];
<<<<<<< HEAD



=======
if (isset($_GET['post'])) $post = $_GET['post'];
>>>>>>> ecb0f9b (updated from huy's computer)

/* tạo đối tượng html */
$Html = $this->load('html');
$Html->load('Form');

/* Tạo đối tượng html table */
$Html->load('Table');


$table_row = '';

/* tạo đối tượng liên kết với bảng user_area, Đọc DL từ bảng user_area */

<<<<<<< HEAD

$array_user_post_data = $this->request_api("post", "list_my", ["area" => $area_str_code, "search" => $search, "lang" => $lang, "street" => $street, "place" => $place]);
=======
$array_user_post_data = $this->request_api("post", "list_my", ["area" => $area_str_code, "search" => $search, "lang" => $lang, "street" => $street, "place" => $place, "post"=>$post]);
>>>>>>> ecb0f9b (updated from huy's computer)
$array_user_post = isset($array_user_post_data["data"]) ? $array_user_post_data["data"] : null;

$stt = 0;
if ($array_user_post != null) {
    foreach ($array_user_post as $row) {
        $stt++;
        $id = $row["id"];
        $uid_post_user = $row["uid"];

        /*name, code, des*/
        $title = $row['title'];
        $category = $row['post_cat_title'];
        $type = $row['type'];
        $des = $row['des'];
        $content = $row['des'];

<<<<<<< HEAD



=======
>>>>>>> ecb0f9b (updated from huy's computer)
        /*span_sent*/
        $sent = $row['sent'];
        $str_sent = "Unsent";
        if ($sent == "1") $str_sent = "Sent";
        $span_sent = $Html->span($str_sent, " class ='des2'");

        /*span_approve*/
        $approved = $row['approved'];
        $str_approve = "Unapproved";
        if ($approved == "1") $str_approve = "Approved";
        $span_approve = $Html->span($str_approve, " class ='des3'");

        /*str_status*/
        $str_status = $span_sent . "<br>" . $span_approve;

<<<<<<< HEAD



=======
>>>>>>> ecb0f9b (updated from huy's computer)
        /*detail*/
        $button_detail = $Html->Form->button(array("class" => "view", "onclick" => "show_post_info('$uid_post_user')"), "View");
        $table_row .= $Html->Table->row(array($stt, $title, $type, $category, $str_status, $button_detail));
    }
} else {
    $table_row = $Html->Table->row(array(array("No data", "colspan = '6'")));
}

<<<<<<< HEAD



=======
>>>>>>> ecb0f9b (updated from huy's computer)
$table_header = $Html->Table->row_header(array("Stt", "Title", "Type", "Category", "Status",  "Options"));
echo $Html->Table->get($table_header . $table_row);
