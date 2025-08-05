<?php
$Html = $this->load("Html");
$Form = $Html->load("Form");
$this->loadModel("LanguageUser");

//Kiểm tra tham số có country
$uid_lang = isset($_GET["lang"]) ? $_GET["lang"] : "";

$name = "";
$code = "";
$des =  "";

if ($uid_lang !== "") {
    $array_lang_user_data = $this->request_api("language", "info_my", ["lang" => $uid_lang]);
    $array_language_user = isset($array_lang_user_data["data"]) ? $array_lang_user_data["data"] : [];
    if ($array_language_user !== null) {
        $name = $array_language_user["name"];
        $code = $array_language_user["code"];
        $des = $array_language_user["des"];
    }
}

//lấy các giá trị lang

//tạo nội dung form
$form_row = "";

//Tạo dòng name Language
$input_name = $Form->textbox(array("name" => "data[name]", "id" => "name", "value" => $name));
$lbl_name = $Html->span("", "id='lbl_name'");
$form_row .= $Form->row("Name",  $input_name . $lbl_name);

//Tạo dòng code Language
$input_code = $Form->textbox(array("name" => "data[code]", "id" => "code", "value" => $code));
$form_row .= $Form->row("Code",  $input_code);

//Tạo dòng des Language
$input_des = $Form->textbox(array("name" => "data[des]", "id" => "des", "value" => $des));
$form_row .= $Form->row("Description",  $input_des);

//Tạo dòng Save
$button_save = $Form->button(array("id" => "button_save", "type" => "button", "onclick" => "save_language()"), "Save");
$hidden_lang = $Form->hidden(array("name" => "data[lang]", "value" => "$uid_lang"));
$form_row .= $Form->row("", $button_save . $hidden_lang);


//Get form input
$url_save = $this->get_link(array("controller" => "lang", "function" => "index"));
$form_input = $Form->get(array("id" => "form_lang", "method" => "POST", "action" => $url_save), $form_row);

//Get div input
echo $Html->heading($uid_lang ? "Edit language" : "Add new language");
echo $form_input;
?>
<script>
    function cancel() {
        var url_cancel = "<?php echo $this->get_link(["controller" => "lang", "function" => "index"]); ?>"
        window.location.href = url_cancel;
    }
</script>