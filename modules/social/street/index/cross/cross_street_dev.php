<?php

/* tạo đối tượng html */
$Html = $this->load('html');
$Form = $Html->load('Form');

$area_str_code = "";

$edit_cross = '';
$uid_user_street = '';
$area_of_street_selected = '';
$str_cross = '';

if (isset($_GET['street'])) $uid_user_street = $_GET['street'];
if (isset($_GET['area'])) $area_of_street_selected = $_GET['area'];
if (isset($_GET['edit'])) $edit_cross = $_GET['edit'];

/* tạo form input */
echo $Html->div("", "id='div_msg_cross'");

$form_row = "";
$div_select_area_cross = $Html->div("", "id='div_select_area_cross'");
$form_row .= $Form->row("Select Area", $div_select_area_cross);

/* button save */
$button_save = $Form->button(array("type" => "button", "id" => "button_save", 'onclick' => "save_cross()"), "Save");

$hidden_street = $Form->hidden(array("name" => "data2[street]", "value" => $uid_user_street));
$hidden_cross = $Form->hidden(array("name" => "data2[area_cross]", "id" => "str_cross", "value" => $area_of_street_selected));
$hidden_edit = $Form->hidden(array("name" => "data2[edit]", "id" => "edit", "value" => $edit_cross));
$form_row .= $Form->row("", $button_save . $hidden_street . $hidden_cross . $hidden_edit);

$url_save = $this->get_link(array("controller" => "user_street", "function" => "cross"));
echo $Form->get(array("method" => "POST", "action" => $url_save, "id" => "form_cross"), $form_row);

echo $Html->div("", "id='div_list_cross' class= 'w100 left'");

?>

<script>
    var parent_area_str_code = '<?php echo $area_str_code; ?>';
</script>