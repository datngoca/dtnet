
<?php
/* kiểm tra post có hợp lệ? */
$uid_post_user = '';
if (isset($_GET['post'])) $uid_post_user = $_GET['post'];
if ($uid_post_user  == '') exit('invalid');

$array_post_user_data =  $this->request_api("post", "info", ["post" => $uid_post_user]);
$array_post_user = isset($array_post_user_data["data"]) ? $array_post_user_data["data"] : null;
if ($array_post_user == null)  exit('invalid_post');

$Html = $this->load('html');
$Form = $Html->load('Form');
$form_row = '';

/* button edit */
$button_activate = $Html->Form->button(array("type" => "button", "class" => "edit", "onclick" => "activate_post('$uid_post_user')"), $array_post_user['status'] == "1" ? "Close" : "Open");

$title_left = $Html->heading('User Input');

$form_row .= $Html->Form->row("Title", $array_post_user['title']);
$form_row .= $Html->Form->row("Type", $array_post_user['type']);
$form_row .= $Html->Form->row("Description", $array_post_user['des']);
$form_row .= $Html->Form->row("Content", $array_post_user['content']);
$form_row .= $Html->Form->row("Language", $array_post_user['lang']);
if (isset($array_post_user['modified'])) {
    $form_row .= $Form->row("Ngày cập nhật", date('d/m/Y H:i:s', strtotime($array_post_user['modified'])));
}

$str_status = "Inactive";
if (isset($array_post_user['status']) && $array_post_user['status'] == "1") $str_status = "Active";
$str_approve = "Not approved yet";
if (isset($array_post_user['approved']) && $array_post_user['approved'] == "1") $str_approve = "Approved";
$form_row .= $Html->Form->row("Status", $str_status . " - " . $str_approve);

$form_row .= $Html->Form->row("", $button_activate);

$form_left = $Html->Form->get(array("method" => "POST", "action" => '', "id" => "form_post"), $form_row);


$div_left = $Html->div($title_left . $form_left, "class='w50 left'");
echo $Html->div($div_left, "class='w100 left'");
/*area, street*/
