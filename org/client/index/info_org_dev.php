<?php
/*Lấy giá trị tham số org */
$uid_org_user = "";
if (isset($_GET["org"])) $uid_org_user = $_GET["org"];
if ($uid_org_user == "") exit("no_org");

$output = "";
if (isset($_GET["output"])) $output = $_GET["output"];

$lang = "";
$name = "";
$code = "";
$des = "";
$content = "";
$sent = "";
$address = "";
$approved = "";
$area_str_name = "";
$street_name = "";
$place_name = "";
$phone = "";
$website = "";
$email = "";
$this->load('ApiClient');
$str_org = $this->ApiClient->request("org", "info_user", array('org' => $uid_org_user));
if ($output == "") exit($str_org);

$array_org = null;
if ($str_org != '') $array_org_data = json_decode($str_org, true);
if (isset($array_org_data['data'])) $array_org = $array_org_data['data'];

/**Lấy phần tử name, code, des */
$lang = $array_org["lang"];
$name = $array_org["name"];
$code = $array_org["code"];
$des = $array_org["des"];
$phone = $array_org["phone"];
$website = $array_org["website"];
$email = $array_org["email"];
$content = $array_org["content"];
$sent = $array_org["sent"];
$approved = $array_org["approved"];
$area_str_name = $array_org["area_str_name"];
$street_name = $array_org["street_name"];
$street_number = $array_org["street_number"];
$place_name = $array_org["place_name"];

$str_sent = "Unsent";
if ($sent == "1") $str_sent = "Sent";
$str_approved = "Unapproved";
if ($approved == "1") $str_approved = "Approved";
$str_status = $str_sent . " - " . $str_approved;

if ($area_str_name != '') $address .= $area_str_name;
if ($street_number != '' && $street_name != '') $address .= ", " . $street_number . " " . $street_name;
if ($street_name != '' && $street_number == '') $address .= ", " . $street_name;
if ($place_name != '' && $place_name != $street_number . " " . $street_name) $address .= ", " . $place_name;

/**Tạo đối tượng Html  */
$Html = $this->load("Html");
$Form = $Html->load("Form");
$form_content = "";

/*org */
$form_content .= $Form->row("Lang", $lang);
$form_content .= $Form->row("Name", $name);
$form_content .= $Form->row("Code", $code);
$form_content .= $Form->row("Phone", $phone);
$form_content .= $Form->row("Email", $email);
$form_content .= $Form->row("address", $address);
$form_content .= $Form->row("Website", $website);
$form_content .= $Form->row("Description", $des);
$form_content .= $Form->row("Content", $content);
$form_content .= $Form->row("Status", $str_status);

/***Gọi hàm button của đối tượng Form để tạo chuỗi <button> */

$button_edit = $Form->button(array("type" => "button", "onclick" => "input_org('$uid_org_user')"), "Edit");
/**Nút save */
$form_content .= $Form->row("", $button_edit);
// $button_search = "<button type = 'submit'>Search</button>";

/**Tạo chuỗi form_content gồm có Tìm kiếm:, input_search, button_search, link_input  */

/*Gọi hàm get() của đối tượng form để lấy thẻ <form> </form> */
$url_save = $this->get_link(array("controller" => "org", "function" => "index"));
$form_input = $Form->get(array("method" => "POST", "action" => $url_save, "id" => "form_input"), $form_content);
/**$form_search = "<form method = 'GET' action = '/task/index' > </form>"; */
echo $form_input;
