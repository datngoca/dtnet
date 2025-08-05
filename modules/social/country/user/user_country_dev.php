<?php
// Lấy thư viện Html, form
$Html = $this->load("Html");
$Form = $Html->load("Form");

$div_msg = $Html->div("", "id='div_msg'");
echo $div_msg;

$div_window = $Html->div("", "id='div_window_country'");
echo $div_window;

echo $Html->heading("Country Management");

// Get search parameter
$search = isset($_GET["search"]) ? $_GET["search"] : "";
$approved = isset($_GET["approved"]) ? $_GET["approved"] : "";
$lang = isset($_GET["lang"]) ? $_GET["lang"] : "";
$lang = isset($_GET["lang"]) ? $_GET["lang"] : "";
$approved_options = array(
    "" => "Tất cả trạng thái",
    "1" => "Đã duyệt",
    "0" => "Chưa duyệt"
);
$select_aprroved = $Form->selectbox(array("name" => "approved", "id" => "approved", "onchange" => "list_country()"), $approved_options, $approved);

// Get language options
$array_lang_data = $this->request_api("language", "list");
$array_lang = isset($array_lang_data["data"]) ? $array_lang_data["data"] : [];
if (!empty($array_lang)) {
    array_unshift($array_lang, array("code" => "", "name" => "Tất cả ngôn ngữ"));
} else {
    $array_lang[] = array("code" => "", "name" => "Tất cả ngôn ngữ");
}
$select_lang = $Form->selectbox(array("name" => "lang", "id" => "lang", "onchange" => "list_country()"), $array_lang, $lang);

$input_search = $Form->textbox(array("name" => "search", "id" => "search", "value" => $search));
$button_search = $Form->button(array("id" => "button_search", "class" => "search", "type" => "button", "onclick" => "list_country()"), "Search");

$form_content = "Trạng thái " . $select_aprroved . " Ngôn ngữ " . $select_lang . " Tìm kiếm " . $input_search . $button_search;

$url_search = $this->get_link(array("controller" => "country", "function" => "user"));
$form_search = $Form->get(array("method" => "GET", "action" => $url_search), $form_content);

// Get div
$div_search = $Html->div($form_search);
$div_table = $Html->div("loading", "id='div_table_country_user'");

echo $div_search . $div_table;

/* thư viện js window */
echo $Html->js($this->template_url . "js/form/window");
?>

<script>
    var url_country = "<?php echo $this->get_link(array("controller" => "country", "function" => "user")) ?>";

    const Word = {
        "country_exist": "Quốc gia đã tồn tại",
        "invalid_data": "Dữ liệu không hợp lệ",
        "no_uid": "Thiếu UID",
        "update_ok": "Duyệt thành công",
        "insert_ok": "Duyệt thành công",
        "success": "Thành công",
    };

    function show_info_country(html_result) {
        // console.log("html result: ", html_result);
        document.getElementById('div_window_country_content').innerHTML = html_result;
    }

    function view_country(uid_country) {
        // show window
        obj_window_country.show();

        // Get link info
        var url_info = url_country;
        if (!url_info.includes("?")) url_info += "?";
        url_info += "action=info&country=" + uid_country;

        return get_page(url_info, null, show_info_country, "div_msg");
    }

    function list_country() {
        loading("div_table_country_user");

        /*Lấy giá trị input_search  */
        var search = document.getElementById('search').value;
        var approved = document.getElementById('approved').value;
        var lang = document.getElementById('lang').value;

        /*lấy url_list_country_api*/
        var url_search = url_country;
        if (!url_search.includes("?")) url_search += "?";
        url_search += "action=list&search=" + search + "&approved=" + approved + "&lang=" + lang;
        return get_page(url_search, null, show_list, "div_msg");
    }

    function show_list(html_result) {
        /**Đưa dữ liệu html vào thẻ div_country_list */
        document.getElementById('div_table_country_user').style.display = "block";
        document.getElementById('div_table_country_user').innerHTML = html_result;
    }

    function show_approve_country(obj) {
        if (!obj) return alert("error");

        const result = obj?.result;
        const msg = obj?.msg;
        const data = obj?.data

        const str_msg = Word[msg];

        if (result !== "ok") return alert("Error: " + str_msg);
        alert(str_msg);

        const uid_country = data?.country;
        view_country(uid_country);
        list_country();
    }

    function approve_country(uid_country) {
        if (!confirm("Bạn có chắc chắn muốn duyệt ngôn ngữ này?")) return;

        var url_approve = url_country;
        if (!url_approve.includes("?")) url_approve += "?";
        url_approve += "action=approve&country=" + uid_country;

        return get_data(url_approve, null, show_approve_country, "div_msg");
    }

    var obj_window_country;

    $(document).ready(function() {
        list_country();

        /*window org*/
        obj_window_country = new Window({
            "target": "div_window_country",
            "title": "Country Information"
        });

        /*window_place_content*/
        window_country_content = "<div id='div_window_country_content'>...</div>";
        obj_window_country.set(window_country_content);

    });
    /*end : $(document).ready(function()*/
</script>