<?php
/*Lấy giá trị tham số org */
$uid_org = "";
if (isset($_GET["org"])) $uid_org = $_GET["org"];

/**Các biến Lang, area, street, place */
$lang = "";
$area_str_code = "";
$uid_street = "";
$uid_place = "";
$type = "";

/**các biến name, code, des */
$name = "";
$code = "";
$des_short = "";
$des = "";
$content = "";
$website = "";
$email = "";
$phone_number = "";
$address = "";
$str_address = "";

$img_banner = "";
$img_profile = "";
$business_activity = "";
$google_map = "";
$status = "";
$sent = "";

/**Kiểm tra $uid_org có giá trị thì đọc thông tin org_user */
$array_org_user = null;
if ($uid_org != "") {
    $array_org_data = $this->request_api("org", "info_my", array('org' => $uid_org));
    if (isset($array_org_data['data'])) $array_org_user = $array_org_data['data'];
    if ($array_org_user != null) {
        $lang = $array_org_user["lang"];
        $area_str_code = $array_org_user['area_str_code'];

        /*street, place*/
        $uid_street = $array_org_user['uid_street'];
        $uid_place = $array_org_user['uid_place'];

        $name = $array_org_user["name"];
        $code = $array_org_user["code"];
        $address = $array_org_user["address"];
        $str_address = $array_org_user["str_address"];

        $des_short = $array_org_user["des_short"];
        $des = $array_org_user["des"];
        $content = $array_org_user["content"];
        $phone_number = $array_org_user["phone"];
        $email = $array_org_user["email"];
        $website = $array_org_user["website"];


        $type = $array_org_user["org_type_name"];
        $img_banner = $array_org_user["img_banner"];
        $img_profile = $array_org_user["img_profile"];
        $status = $array_org_user["status"];
        $business_activity = $array_org_user["business_activity"];
        $google_map = $array_org_user["google_map"];
        $sent = $array_org_user["sent"];
    }
}

$Html = $this->load("Html");
echo $Html->heading("Input org");
$Form = $Html->load("Form");

$form_content = "";

/*select lang */
$array_lang_data = $this->request_api("language", "list");
$array_lang = isset($array_lang_data["data"]) ? $array_lang_data["data"] : null;
if ($array_lang != null) array_unshift($array_lang, array("code" => "", "name" => "..."));
else $array_lang[] = array("code" => "", "name" => "...");
$select_lang = $Html->Form->selectbox(array("name" => "data[lang]", "id" => "select_lang_input", "onchange" => "change_lang_input()"), $array_lang, $lang);
$form_content .= $Form->row("Lang", $select_lang);

/* tạo input chọn khu vực */
$str_selectbox_area_parent = "";
$span_area_parent = $Html->span($str_selectbox_area_parent, "id='span_area_parent_input'");
$span_list_select_area =  $Html->span("", "id='span_list_select_area_input'");
$div_selectbox_area = $Html->div($span_area_parent . $span_list_select_area, "");

$hidden_str_code_parent = $Form->hidden(array("name" => "data[area_str_code]", "id" => "area_str_code_input", "value" => $area_str_code));

$form_content .= $Form->row("In Area", $div_selectbox_area . $hidden_str_code_parent);

/*input street */
$div_street_input = $Html->div("", "id = 'div_street_input' style = 'float: left; width: 100%'");
$hidden_street = $Form->hidden(array("id" => "hidden_street", "value" => $uid_street));
$hidden_street_data = $Form->hidden(array("name" => "data[uid_street]", "id" => "hidden_street_data", "value" => $uid_street));
$form_content .= $Form->row("Street", $div_street_input . $hidden_street);

/*input place_in */
$div_input_place_in = $Html->div("", "id = 'div_input_place_in' style = 'float: left; width: 100%'");
$hidden_place_in = $Form->hidden(array("id" => "hidden_place_in", "value" => $uid_place));
$hidden_place_in_data = $Form->hidden(array("name" => "data[place_in]", "id" => "hidden_place_in_data", "value" => $uid_place));

$form_content .= $Form->row("In Place", $div_input_place_in . $hidden_place_in);

/*org name  */
$input_name = $Form->textbox(array("name" => "data[name]", "value" => $name, "id" => "name", "style" => "width: 100%"));
$form_content .= $Form->row("Name", $input_name);

/**code */
$input_code = $Form->textbox(array("name" => "data[code]", "value" => $code, "id" => "code", "style" => "width: 100%"));
$form_content .= $Form->row("Code", $input_code);


/*Type*/
$array_type = array("gov" => "Government", "ngo" => "None Government", "business" => "Business", "school" => "School", "associations" => "Associations");
$select_type = $Form->selectbox(array("name" => "data[type]", "id" => "select_type_input"), $array_type, $type);
$form_content .= $Form->row("Type", $select_type);

/*Business Activity */
$input_business = $Form->textbox(array("name" => "data[business_activity]", "value" => $business_activity, "id" => "business_activity"));
$form_content .= $Form->row("Business Activity", $input_business);

/**Description */
/* input des */
$input_des_short = $Form->textarea(array("name" => "data[des_short]", "style" => "width: 100%; height: 100px;"), $des_short);
$form_content .= $Form->row("Search Description", $input_des_short);

/* input des */
$input_des = $Form->textarea(array("name" => "data[des]", "style" => "width: 100%; height: 100px;"), $des);
$form_content .= $Form->row("Description", $input_des);

/* email */
$input_email = $Form->textbox(array("name" => "data[email]", "value" => $email, "id" => "email"));
$form_content .= $Form->row("Email", $input_email);

/* phone number */
$input_phone_number = $Form->textbox(array("name" => "data[phone]", "value" => $phone_number, "id" => "phone_number"));
$form_content .= $Form->row("Phone number", $input_phone_number);

/*website */
$input_website = $Form->textbox(array("name" => "data[website]", "value" => $website, "id" => "website"));
$form_content .= $Form->row("Website", $input_website);


/*address */
/*
$div_address         = $Html->div($str_address, "id = 'div_address'");
$hidden_address = $Form->hidden(array("id" => "hidden_address", "name" => "address", "value" => ""));

$div_address_value = $Html->div($str_json_address, "id = 'div_address_value' style = 'display: none' ");

$button_address     = $Form->button(array("type" => "button", "id" => "button_address", "onclick" => "show_address()"), '...');
$form_content .= $Form->row("Address", $div_address . $button_address . $hidden_address . $div_address_value);
*/

/*google map */
/*
$input_google_map = $Form->textbox(array("name" => "google_map", "value" => $google_map, "id" => "google_map"));
$form_content .= $Form->row("Google map", $input_google_map);
*/

$button_select_profile = $Form->button(array("type" => "button", "id" => "button_select_profile_org"), 'select img');
$hidden_img_profile = $Form->hidden(array("id" => "img_profile", "name" => "data[img_profile]", "value" => $img_profile));
$form_content .= $Form->row("", $hidden_img_profile);
$div_img_profile = $Html->div($button_select_profile, "id='div_img_profile'");
$form_content .= $Form->row("Img profile", $div_img_profile);

$button_select_banner = $Form->button(array("type" => "button", "id" => "button_select_banner_org"), 'select banner');
$hidden_img_banner = $Form->hidden(array("id" => "img_banner", "name" => "data[img_banner]", "value" => $img_banner));
$form_content .= $Form->row("", $hidden_img_banner);
$div_img_banner = $Html->div($button_select_banner, "id='div_img_banner'");
$form_content .= $Form->row("Img banner", $div_img_banner);

/*org name  */
$array_sent = array("0" => "...", "1" => "Send");
$select_sent = $Html->Form->selectbox(array("name" => "data[sent]", "id" => "select_sent"), $array_sent, $sent);
$form_content .= $Form->row("Status", $select_sent);

/**Nút save */
$button_save = $Form->button(array("id" => "button_save", "type" => "button", "onclick" => "save_org()"), "Save");
$hidden_org = $Form->hidden(array("name" => "data[org]", "value" => $uid_org));
$form_content .= $Form->row("", $button_save . $hidden_org);
$url_save = $this->get_link(array("controller" => "org", "function" => "index", 'get' => 'action=save'));
$form_input = $Form->get(array("method" => "POST", "action" => $url_save, "id" => "form_org"), $form_content);
echo $form_input;
?>
<style>
    #div_address {
        background-color: #98a3a1;
        padding: 5px 50px 5px 10px;
        width: calc(100% - 20px);
        margin: 0px;
        border-radius: 10px;
        float: left;
        height: 70px;
        line-height: 20px;
        display: table;
    }

    #button_address {
        margin: 0px 3px 0px -48px;
        padding: 5px 15px;
        height: 70px;

    }
</style>