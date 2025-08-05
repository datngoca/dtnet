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

/*name, code, des*/
$name = $array_place_user['name'];
$code = $array_place_user['code'];
$str_code = $array_place_user['str_code'];
$des = $array_place_user['des'];

$approved = $array_place_user['approved'];
$sent = $array_place_user['sent'];
$url_key = $array_place_user['url_key'];

/*street*/
$street_name = $array_place_user['street_name'];
$street_code = $array_place_user['street_code'];

$street_number = $array_place_user['street_number'];

/*place*/
$place_name_in = $array_place_user['place_name_in'];
$place_code_in = $array_place_user['place_code_in'];

/*section*/
$section = $array_place_user['section'];
$floor = $array_place_user['floor'];
$room = $array_place_user['room'];
$str_section = $section;
if ($floor != "")    $str_section .= ", " . $floor;
if ($room != "")    $str_section .= " " . $room;

/*str_place*/
$str_place = $place_name_in . "($place_code_in)";
if ($str_section != "") $str_place = $str_section . ", " . $str_place;


$str_approve = "Unaprroved";
if ($approved == "1") $str_approve = "Aprroved";

$str_sent = "UnSent";
if ($sent == "1") $str_sent = "Sent";

$str_status =  $str_sent . " - " . $str_approve;

$Html->load('Form');
$form_row = '';


/* button edit */
$button_edit = $Html->Form->button(array("type" => "button", "class" => "edit", "onclick" => "input_place('$uid_place_user')"), "Edit");

$title_left = $Html->heading('User Input');

$form_row .= $Html->Form->row("Language", $lang);

$form_row .= $Html->Form->row("Place name", $name . "($code)");
$form_row .= $Html->Form->row("Code", $str_code);
$form_row .= $Html->Form->row("Url key", $url_key);

$form_row .= $Html->Form->row("In Area", $area_str_name . '</br>' . $area_str_code);
$form_row .= $Html->Form->row("Street Name", $street_name);
$form_row .= $Html->Form->row("Street number", $street_number);
$form_row .= $Html->Form->row("In Place", $str_place);

$form_row .= $Html->Form->row("Description", $des);
$form_row .= $Html->Form->row("Status ", $str_status);

$form_row .= $Html->Form->row("", $button_edit);

$form_left = $Html->Form->get(array("method" => "POST", "action" => '', "id" => "form_area"), $form_row);

/* Phần bên phải */

/*request api:lấy dữ liệu bản chính area */
$uid_place = $array_place_user['uid_place'];

$array_place_data = $this->request_api("place", "info", ["place" => $uid_place]);
$array_place = isset($array_place_data["data"]) ? $array_place_data["data"] : null;

$title_right = $Html->heading('Place Information api');
$form_row_right = "No information";

if ($array_place != null) {
    /*lang, name, code, url_key*/
    $lang = $array_place['lang'];
    $name = $array_place['name'];
    $code = $array_place['code'];
    $str_code = $array_place['str_code'];
    $url_key = $array_place['url_key'];
    $des = $array_place['des'];


    /*street*/
    $street_name = $array_place['street_name'];
    $street_code = $array_place['street_code'];

    $street_number = $array_place['street_number'];

    /*place*/
    $place_name_in = $array_place['place_name_in'];
    // $place_code_in = $array_place['place_code_in'];

    /*section*/
    $section = $array_place['section'];
    $floor = $array_place['floor'];
    $room = $array_place['room'];
    $str_section = $section;
    if ($floor != "")    $str_section .= ", " . $floor;
    if ($room != "")    $str_section .= " " . $room;

    /*str_place*/
    $str_place = $place_name_in;
    if ($str_section != "") $str_place = $str_section . ", " . $str_place;

    $approved = $array_place['approved'];
    $status = $array_place['status'];

    $str_status = "In active";
    if ($status == "1") $str_status = "Active";

    $str_approve = "Not approved yet";
    if ($approved == "1") $str_approve = "Approved";

    $form_row_right = '';

    $form_row_right .= $Html->Form->row("Language", $lang);

    $form_row_right .= $Html->Form->row("Place Name", $name . "($code)");
    $form_row_right .= $Html->Form->row("Code", $str_code);
    $form_row_right .= $Html->Form->row("Url key", $url_key);

    $form_row_right .= $Html->Form->row("In Area", $area_str_name . '</br>' . $area_str_code);

    $form_row_right .= $Html->Form->row("Street Name", $street_name);
    $form_row_right .= $Html->Form->row("Street number", $street_number);
    $form_row_right .= $Html->Form->row("In Place", $str_place);

    $form_row_right .= $Html->Form->row("Description", $des);
    $form_row_right .= $Html->Form->row("Status ", $str_status . " - " . $str_approve);
}
/* end: if ($array_post_cat != null) */

$form_right = $Html->Form->get(array("method" => "POST", "action" => '', "id" => "form_area_right"), $form_row_right);

$div_left = $Html->div($title_left . $form_left, "class='w50 left'");
$div_right = $Html->div($title_right . $form_right, "class='w50 right'");
echo $div_area = $Html->div($div_left . $div_right, "class='w100 left'");
