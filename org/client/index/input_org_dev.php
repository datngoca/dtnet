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

/**Kiểm tra $uid_org có giá trị thì đọc thông tin org_user */
$array_org_user = null;
$str_json_address = json_encode($this->CurrentUser->array_member);
if ($uid_org != "") {
    $array_org_data = $this->request_api("org", "info_user", array('org' => $uid_org));
    if (isset($array_org_data['data'])) $array_org_user = $array_org_data['data'];
    if ($array_org_user != null) {
        $lang = $array_org_user["lang"];
        $name = $array_org_user["name"];
        $code = $array_org_user["code"];
        $address = $array_org_user["address"];
        $str_address = $array_org_user["str_address"];

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

        /*country, area*/
        $array_object_address = array("country_code" => $array_org_user["country_code"], "country_name" => $array_org_user["country_name"]);
        $array_object_address["area_str_code"] = $array_org_user["area_str_code"];
        $array_object_address["area_str_name"] = $array_org_user["area_str_name"];
        $array_object_address["area_str_address"] = $array_org_user["area_str_address"];
        $array_object_address["area_str_name_reverse"] = $array_org_user["area_str_name_reverse"];

        /*street, place*/
        $array_object_address["uid_street"] = $array_org_user["uid_street"];
        $array_object_address["street_name"] = $array_org_user["street_name"];

        $array_object_address["uid_place"] = $array_org_user["uid_place"];
        $array_object_address["place_name"] = $array_org_user["place_name"];
        $array_object_address["street_number"] = $array_org_user["street_number"];
        $array_object_address["uid_place_in"] = $array_org_user["uid_place_in"];
        $array_object_address["place_name_in"] = $array_org_user["place_name_in"];
        $array_object_address["place_info"] = $array_org_user["place_info"];

        $array_object_address["address"] = $array_org_user["address"];
        $array_object_address["str_address"] = $array_org_user["str_address"];

        $str_json_address = json_encode($array_object_address);
    }
}

$Html = $this->load("Html");
echo $Html->heading("Input org");
$Form = $Html->load("Form");

$form_content = "";

/* lang*/
$array_language = null;
$array_language = $this->request_api("language", "list");
if ($array_language == null) $array_language[] = array("code" => "", "name" => "...");
$select_lang = $Form->selectbox(array("name" => "lang", "id" => "select_lang_input", "onchange" => "change_lang_input()"), $array_language, $lang);
$form_content .= $Form->row("Language", $select_lang);

/*org name  */
$input_name = $Form->textbox(array("name" => "name", "value" => $name, "id" => "name", "style" => "width: 100%"));
$form_content .= $Form->row("Name", $input_name);

/**code */
$input_code = $Form->textbox(array("name" => "code", "value" => $code, "id" => "code", "style" => "width: 100%"));
$form_content .= $Form->row("Code", $input_code);


/*Type*/
$array_type = array("gov" => "Government", "ngo" => "None Government", "business" => "Business", "school" => "School", "associations" => "Associations");
$select_type = $Form->selectbox(array("name" => "type", "id" => "select_type_input"), $array_type, $type);
$form_content .= $Form->row("Type", $select_type);

/*Business Activity */
$input_business = $Form->textbox(array("name" => "business_activity", "value" => $business_activity, "id" => "business_activity"));
$form_content .= $Form->row("Business Activity", $input_business);

/**Description */
$input_des = $Form->textbox(array("name" => "des", "value" => $des));
$form_content .= $Form->row("Description", $input_des);

/* email */
$input_email = $Form->textbox(array("name" => "email", "value" => $email, "id" => "email"));
$form_content .= $Form->row("Email", $input_email);

/* phone number */
$input_phone_number = $Form->textbox(array("name" => "phone", "value" => $phone_number, "id" => "phone_number"));
$form_content .= $Form->row("Phone number", $input_phone_number);

/*website */
$input_website = $Form->textbox(array("name" => "website", "value" => $website, "id" => "website"));
$form_content .= $Form->row("Website", $input_website);


/*address */
$div_address         = $Html->div($str_address, "id = 'div_address'");
$hidden_address = $Form->hidden(array("id" => "hidden_address", "name" => "address", "value" => ""));

$div_address_value = $Html->div($str_json_address, "id = 'div_address_value' style = 'display: none' ");

$button_address     = $Form->button(array("type" => "button", "id" => "button_address", "onclick" => "show_address()"), '...');
$form_content .= $Form->row("Address", $div_address . $button_address . $hidden_address . $div_address_value);

/*google map */
$input_google_map = $Form->textbox(array("name" => "google_map", "value" => $google_map, "id" => "google_map"));
$form_content .= $Form->row("Google map", $input_google_map);

$button_select_profile = $Form->button(array("type" => "button", "id" => "button_select_profile_org"), 'select img');
$hidden_img_profile = $Form->hidden(array("id" => "img_profile", "name" => "img_profile", "value" => $img_profile));
$form_content .= $Form->row("", $hidden_img_profile);
$div_img_profile = $Html->div($button_select_profile, "id='div_img_profile'");
$form_content .= $Form->row("Img profile", $div_img_profile);

$button_select_banner = $Form->button(array("type" => "button", "id" => "button_select_banner_org"), 'select banner');
$hidden_img_banner = $Form->hidden(array("id" => "img_banner", "name" => "img_banner", "value" => $img_banner));
$form_content .= $Form->row("", $hidden_img_banner);
$div_img_banner = $Html->div($button_select_banner, "id='div_img_banner'");
$form_content .= $Form->row("Img banner", $div_img_banner);

/*org name  */
$array_status = null;
$array_status[0] = array('status' => '0', 'name' => 'Chưa gởi đề nghị duyệt');
$array_status[1] = array('status' => '1', 'name' => 'Gởi đề nghị duyệt');
$selectbox_status = $Html->Form->selectbox(array("name" => "status", "id" => "select_org_status"), $array_status, $status);
$form_content .= $Form->row("Status", $selectbox_status);

/**Nút save */
$button_save = $Form->button(array("id" => "button_save", "type" => "button", "onclick" => "check()"), "Save");
$hidden_org = $Form->hidden(array("name" => "org", "value" => $uid_org));
$form_content .= $Form->row("", $button_save . $hidden_org);
$url_save = $this->get_link(array("controller" => "org", "function" => "index", 'get' => 'action=save'));
$form_input = $Form->get(array("method" => "POST", "action" => $url_save, "id" => "form_input"), $form_content);
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