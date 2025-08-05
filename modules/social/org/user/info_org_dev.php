<?php
/* kiểm tra tổ chức có hợp lệ? */
$uid_org_user = '';
if (isset($_GET['org'])) $uid_org_user = $_GET['org'];
if ($uid_org_user == '') exit('invalid');

$array_org_user_data = $this->request_api("org", "info_user", ["org" => $uid_org_user]);
$array_org_user = isset($array_org_user_data["data"]) ? $array_org_user_data["data"] : null;
if ($array_org_user == null) exit('invalid_org');

/* tạo đối tượng html */
$Html = $this->load('html');

/*lang, name, code*/
$lang = $array_org_user['lang'];
$name = $array_org_user['name'];
$code = $array_org_user['code'];
$des = $array_org_user['des'];
$phone = $array_org_user['phone'];
$website = $array_org_user['website'];
$email = $array_org_user['email'];
$content = $array_org_user['content'];
$sent = $array_org_user['sent'];
$approved = $array_org_user['approved'];

$area_str_name = $array_org_user['area_str_name'];
$area_str_code = $array_org_user['area_str_code'];

/*street*/
$street_name = $array_org_user['street_name'];
$street_code = $array_org_user['street_code'];
$street_number = $array_org_user['street_number'];
$str_street = '';
if (!empty($street_name) || !empty($street_number)) {
    $str_street = trim($street_number . ' ' . $street_name);
    if (!empty($street_code)) {
        $str_street .= " ($street_code)";
    }
}

/*place*/
$place_name_in = $array_org_user['place_name'];
$place_code_in = $array_org_user['place_code'];
$str_place = '';
if (!empty($place_name_in)) {
    $str_place = $place_name_in;
    if (!empty($place_code_in)) {
        $str_place .= " ($place_code_in)";
    }
}

// /*address*/
// $area_str_name = $array_org_user['area_str_name'];
// $street_name = $array_org_user['street_name'];
// $street_number = $array_org_user['street_number'];
// $place_name = $array_org_user['place_name'];

// /*str_address*/
// $address = '';
// if ($area_str_name != '') $address .= $area_str_name;
// if ($street_number != '' && $street_name != '') $address .= ", " . $street_number . " " . $street_name;
// if ($street_name != '' && $street_number == '') $address .= ", " . $street_name;
// if ($place_name != '' && $place_name != $street_number . " " . $street_name) $address .= ", " . $place_name;

$str_approve = "Unapproved";
if ($approved == "1") $str_approve = "Approved";

$str_sent = "UnSent";
if ($sent == "1") $str_sent = "Sent";

$str_status = $str_sent . " - " . $str_approve;

$Html->load('Form');
$form_row = '';

/* button edit */
$button_approve = $Html->Form->button(array("type" => "button", "class" => "edit", "onclick" => "approve_org('$uid_org_user')"), "Aprrove");

$title_left = $Html->heading('User Input');

$form_row .= $Html->Form->row("Language", $lang);
$form_row .= $Html->Form->row("Name", $name);
$form_row .= $Html->Form->row("Code", $code);
$form_row .= $Html->Form->row("Phone", $phone);
$form_row .= $Html->Form->row("Email", $email);
$form_row .= $Html->Form->row("In Area", $area_str_name . '</br><span class="area_code">' . $area_str_code . '</span>');
$form_row .= $Html->Form->row("Street", $str_street);
$form_row .= $Html->Form->row("In Place", $str_place);
$form_row .= $Html->Form->row("Website", $website);
$form_row .= $Html->Form->row("Description", $des);
$form_row .= $Html->Form->row("Content", $content);
$form_row .= $Html->Form->row("Status", $str_status);
$form_row .= $Html->Form->row("", $button_approve);

$form_left = $Html->Form->get(array("method" => "POST", "action" => '', "id" => "form_org"), $form_row);

/* Phần bên phải */

/*request api:lấy dữ liệu bản chính org */
$uid_org = $array_org_user['uid_org'];

$array_org_data = $this->request_api("org", "info", ["org" => $uid_org]);
$array_org = isset($array_org_data["data"]) ? $array_org_data["data"] : null;

$title_right = $Html->heading('Organization Information API');
$form_row_right = "No information";

if ($array_org != null) {
    /*lang, name, code*/
    $lang = $array_org['lang'];
    $name = $array_org['name'];
    $code = $array_org['code'];
    $des = $array_org['des'];
    $phone = $array_org['phone'];
    $website = $array_org['website'];
    $email = $array_org['email'];
    $content = $array_org['content'];

    // Sửa lỗi: sử dụng $array_org thay vì $array_place_user
    $area_str_name = $array_org['area_str_name'];
    $area_str_code = $array_org['area_str_code'];
    /*street*/
    $street_name = $array_org['street_name'];
    $street_code = $array_org['street_code'];
    $street_number = $array_org['street_number'];
    $str_street_right = '';
    if (!empty($street_name) || !empty($street_number)) {
        $str_street_right = trim($street_number . ' ' . $street_name);
        if (!empty($street_code)) {
            $str_street_right .= " ($street_code)";
        }
    }

    /*place*/
    $place_name_in = $array_org['place_name'];
    $place_code_in = $array_org['place_code'];
    $str_place_right = '';
    if (!empty($place_name_in)) {
        $str_place_right = $place_name_in;
        if (!empty($place_code_in)) {
            $str_place_right .= " ($place_code_in)";
        }
    }

    $approved = $array_org['approved'];
    $status = $array_org['status'];

    $str_status = "Inactive";
    if ($status == "1") $str_status = "Active";

    $str_approve = "Not approved yet";
    if ($approved == "1") $str_approve = "Approved";

    $str_status .= " - " . $str_approve;

    $form_row_right = '';

    $form_row_right .= $Html->Form->row("Language", $lang);
    $form_row_right .= $Html->Form->row("Name", $name);
    $form_row_right .= $Html->Form->row("Code", $code);
    $form_row_right .= $Html->Form->row("Phone", $phone);
    $form_row_right .= $Html->Form->row("Email", $email);
    $form_row_right .= $Html->Form->row("In Area", $area_str_name . '</br><span class="area_code">' . $area_str_code . '</span>');
    $form_row_right .= $Html->Form->row("Street", $str_street_right);
    $form_row_right .= $Html->Form->row("In Place", $str_place_right);
    $form_row_right .= $Html->Form->row("Website", $website);
    $form_row_right .= $Html->Form->row("Description", $des);
    $form_row_right .= $Html->Form->row("Content", $content);
    $form_row_right .= $Html->Form->row("Status", $str_status);
}
/* end: if ($array_org != null) */

$form_right = $Html->Form->get(array("method" => "POST", "action" => '', "id" => "form_org_right"), $form_row_right);

$div_left = $Html->div($title_left . $form_left, "class='w50 left'");
$div_right = $Html->div($title_right . $form_right, "class='w50 right'");
echo $div_org = $Html->div($div_left . $div_right, "class='w100 left'");
