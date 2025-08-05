<?php
/* kiểm tra khu vực có hợp lệ? */
$uid_area_user = '';
if (isset($_GET['area'])) $uid_area_user = $_GET['area'];
if ($uid_area_user  == '') exit('invalid');

// $this->loadModel("AreaUser");
// $array_area_user = $this->AreaUser->read($uid_area_user);

$array_area_user_data = $this->request_api("area", "info_my", ["area" => $uid_area_user]);
$array_area_user = isset($array_area_user_data["data"]) ? $array_area_user_data["data"] : [];

if ($array_area_user == null)  exit('invalid_area');

/* tạo đối tượng html */
$Html = $this->load('html');

$id_user_area = $array_area_user['id'];

$lang = $array_area_user['lang'];
$parent_str_code = $array_area_user['parent_str_code'];
$parent_str_name = $array_area_user['parent_str_name'];

/*name, code*/
$name = $array_area_user['name'];
$name_address = $array_area_user['name_address'];
$code = $array_area_user['code'];
$str_code = $array_area_user['str_code'];

/*des, des short*/
$des = $array_area_user['des'];
$des_short = $array_area_user['des_short'];

$approved = $array_area_user['approved'];
$sent = $array_area_user['sent'];
$url_key = $array_area_user['url_key'];


$str_approve = "Unapproved";
if ($approved == "1") $str_approve = "Approved";

$str_sent = "Unsent";
if ($sent == "1") $str_sent = "Sent";


$Html->load('Form');
$form_row = '';


/* button edit */
$button_edit = $Html->Form->button(array("type" => "button", "class" => "edit", "onclick" => "input_area('$uid_area_user')"), "Edit");
$button_delete = $Html->Form->button(array("type" => "button", "class" => "delete", "onclick" => "delete_area('$uid_area_user')"), "Delete");

$title_left = $Html->heading('User Area Information');

$form_row .= $Html->Form->row("Language", $lang);
$form_row .= $Html->Form->row("In", $parent_str_name . '</br>' . $parent_str_code);
$form_row .= $Html->Form->row("Area name", $name . "($code) ");
$form_row .= $Html->Form->row("Name in address",  $name_address);

$form_row .= $Html->Form->row("Code", $str_code);
$form_row .= $Html->Form->row("Url key", $url_key);
$form_row .= $Html->Form->row("Search", $des_short);

$form_row .= $Html->Form->row("Description", $des);
$form_row .= $Html->Form->row("Status ", $str_sent . " - " . $str_approve);

$form_row .= $Html->Form->row("", $button_edit . $button_delete);

$form_left = $Html->Form->get(array("method" => "POST", "action" => '', "id" => "form_area"), $form_row);

/* Phần bên phải */

/*request api:lấy dữ liệu bản chính area */
$uid_area = $array_area_user['uid_area'];

$array_area = $this->request_api("area", "info", array("str_code" => $str_code, "lang" => $lang));
$title_right = $Html->heading('Area Information');
$form_row_right = "No information";

if ($array_area != null) {
    /*name, code*/
    $name = $array_area['name'];
    $name_address = $array_area['name_address'];
    $code = $array_area['code'];
    $str_code = $array_area['str_code'];

    /*description*/
    $des = $array_area['des'];
    $des_short = $array_area['des_short'];


    $img = $array_area['img'];
    $parent_str_code = $array_area['parent_str_code'];
    $parent_str_name = $array_area['parent_str_name'];
    $approved = $array_area['approved'];
    $status = $array_area['status'];
    $url_key = $array_area['url_key'];

    $str_approve = "Unapproved";
    if ($approved == "1") $str_approve = "Approved";

    $str_status = "Inactived";
    if ($status == "1") $str_status = "Actived";

    $form_row_right = '';
    $form_row_right .= $Html->Form->row("Language", $lang);
    $form_row_right .= $Html->Form->row("In", $parent_str_name . '</br>' . $parent_str_code);
    $form_row_right .= $Html->Form->row("Area name", $name . "($code)");
    $form_row_right .= $Html->Form->row("Name in address", $name_address);
    $form_row_right .= $Html->Form->row("Code", $str_code);
    $form_row_right .= $Html->Form->row("Url key", $url_key);

    $form_row_right .= $Html->Form->row("Search", $des_short);
    $form_row_right .= $Html->Form->row("Description", $des);
    $form_row_right .= $Html->Form->row("Status ", $str_approve . " - " . $str_status);
}
/* end: if ($array_post_cat != null) */

$form_right = $Html->Form->get(array("method" => "POST", "action" => '', "id" => "form_area_right"), $form_row_right);

$div_left = $Html->div($title_left . $form_left, "class='w50 left'");
$div_right = $Html->div($title_right . $form_right, "class='w50 right'");
echo $div_area = $Html->div($div_left . $div_right, "class='w100 left'");
