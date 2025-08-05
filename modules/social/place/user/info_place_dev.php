<?php
/* kiểm tra khu vực có hợp lệ? */
$uid_place_user = '';
if (isset($_GET['place'])) $uid_place_user = $_GET['place'];
if ($uid_place_user  == '') exit('invalid');

$array_place_user_data =  $this->request_api("place", "info_my", ["place" => $uid_place_user]);
$array_place_user = isset($array_place_user_data["data"]) ? $array_place_user_data["data"] : null;
if ($array_place_user == null)  exit('invalid_area');

/* tạo đối tượng html */
$Html = $this->load('html');

/*lang, area*/
$lang = $array_place_user['lang'];
$area_str_code = $array_place_user['area_str_code'];
$area_str_name = $array_place_user['area_str_name'];

$street_name = $array_place_user['street_name'];
$street_number = $array_place_user['street_number'];

$place_name_in  = $array_place_user['place_name_in'];

/*name, code, des*/
$name = $array_place_user['name'];
$code = $array_place_user['code'];
$str_code = $array_place_user['str_code'];
$des = $array_place_user['des'];

$approved = $array_place_user['approved'];
$sent = $array_place_user['sent'];
$url_key = $array_place_user['url_key'];


$str_approve = "Unaprroved";
if ($approved == "1") $str_approve = "Aprroved";

$str_sent = "UnSent";
if ($sent == "1") $str_sent = "Sent";


$Html->load('Form');
$form_row = '';


/* button edit */
$button_approve = $Html->Form->button(array("type" => "button", "class" => "edit", "onclick" => "approve_place('$uid_place_user')"), "Approve");

$title_left = $Html->heading('User Input');

$form_row .= $Html->Form->row("Language", $lang);
$form_row .= $Html->Form->row("Place name", $name);
$form_row .= $Html->Form->row("Code", $str_code);
$form_row .= $Html->Form->row("Url key", $url_key);
$form_row .= $Html->Form->row("Street Name", $street_name);
$form_row .= $Html->Form->row("In Area", $area_str_name . '</br>' . $area_str_code);

$form_row .= $Html->Form->row("Street number", $street_number);

$form_row .= $Html->Form->row("In Place", $place_name_in);

$form_row .= $Html->Form->row("Description", $des);
$form_row .= $Html->Form->row("Status ", $str_approve);

if ($approved !== "1") $form_row .= $Html->Form->row("", $button_approve);

$form_left = $Html->Form->get(array("method" => "POST", "action" => '', "id" => "form_area"), $form_row);

/* Phần bên phải */

/*request api:lấy dữ liệu bản chính area */
$uid_place = $array_place_user['uid_place'];

$array_place_data = $this->request_api("place", "info",  ["place" => $uid_place]);
$array_place = isset($array_place_data["data"]) ? $array_place_data["data"] : null;

$title_right = $Html->heading("Place Information Api");
$form_row_right = "No information";

if ($array_place != null) {
    /*lang*/
    $lang = $array_place['lang'];

    /*area*/
    $area_str_code = $array_place['area_str_code'];
    $area_str_name = $array_place['area_str_name'];

    $street_name = $array_place['street_name'];
    $street_number = $array_place['street_number'];


    $place_name_in  = $array_place['place_name_in'];


    /*name, code, des, url_key*/
    $name = $array_place['name'];
    $des = $array_place['des'];
    $code = $array_place['code'];
    $str_code = $array_place['str_code'];
    $url_key = $array_place['url_key'];


    $img = $array_place['img'];

    /*status, approved*/
    $status = $array_place['status'];

    $approved = $array_place['approved'];

    $str_approve = "Not approved yet";
    if ($approved == "1") $str_approve = "Approved";

    $str_status = "In active";
    if ($status == "1") $str_status = "Active";

    $form_row_right = '';
    $form_row_right .= $Html->Form->row("Lang", $lang);
    $form_row_right .= $Html->Form->row("Place name", $name);
    $form_row_right .= $Html->Form->row("Code", $str_code);
    $form_row_right .= $Html->Form->row("Url key", $url_key);
    $form_row_right .= $Html->Form->row("Street Name", $street_name);

    $form_row_right .= $Html->Form->row("In Area", $area_str_name . '</br>' . $area_str_code);
    $form_row_right .= $Html->Form->row("Street number", $street_number);

    $form_row_right .= $Html->Form->row("In Place", $place_name_in);


    $form_row_right .= $Html->Form->row("Description", $des);
    $form_row_right .= $Html->Form->row("Status ", $str_status . " - " . $str_approve);
}
/* end: if ($array_post_cat != null) */

$form_right = $Html->Form->get(array("method" => "POST", "action" => '', "id" => "form_area_right"), $form_row_right);

$div_left = $Html->div($title_left . $form_left, "class='w50 left'");
$div_right = $Html->div($title_right . $form_right, "class='w50 right'");
echo $div_area = $Html->div($div_left . $div_right, "class='w100 left'");
