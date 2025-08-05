<?php
// Lấy thư viện Html, form
$Html = $this->load("Html");
$Form = $Html->load("Form");

$div_msg = $Html->div("", "id='div_msg'");
echo $div_msg;

$div_window = $Html->div("", "id='div_window_language'");
echo $div_window;

echo $Html->heading("Language Management");

// Get search parameter
$search = isset($_GET["search"]) ? $_GET["search"] : "";
$status = isset($_GET["status"]) ? $_GET["status"] : "";
$status_options = array(
    "" => "Tất cả trạng thái",
    "1" => "Hoạt động",
    "0" => "Tạm ngưng"
);
$select_status = $Form->selectbox(array("name" => "status", "id" => "status", "onchange" => "list_lang()"), $status_options, $status);

// Get input search, button search, button add
$input_search = $Form->textbox(array("name" => "search", "id" => "search", "value" => $search));
$button_search = $Form->button(array("id" => "button_search", "class" => "search", "type" => "button", "onclick" => "list_lang()"), "Search");

$form_content = "Trạng thái " . $select_status . "Tìm kiếm " . $input_search . $button_search;

$form_search = $Form->get(array("method" => "GET"), $form_content);

// Get div
$div_search = $Html->div($form_search);
$div_table = $Html->div("loading", "id='div_table_lang_user'");

echo $div_search . $div_table;

/* thư viện js window */
echo $Html->js($this->template_url . "js/form/window");
?>

<script>
    var url_lang = "<?php echo $this->get_link(array("controller" => "lang", "function" => "all")) ?>";

    const Word = {
        "language_exist": "Ngôn ngữ đã tồn tại",
        "null_value": "Lỗi không xác định",
        "update_ok": "Kích hoạt thành công",
        "insert_ok": "Kích hoạt thành công",
        "activated": "Thay đổi trạng thái thành công",
    };

    function show_info_lang(html_result) {
        document.getElementById('div_window_language_content').innerHTML = html_result;
    }

    function view_lang(uid_lang) {
        // show window
        obj_window_language.show();

        // Get link info
        var url_info = url_lang;
        if (!url_info.includes("?")) url_info += "?";
        url_info += "action=info&lang=" + uid_lang;
        console.log("url_info", url_info);
        return get_page(url_info, null, show_info_lang, "div_msg");
    }

    function list_lang() {
        loading("div_table_lang_user");

        /*Lấy giá trị input_search  */
        var search = document.getElementById('search').value;
        var status = document.getElementById('status').value;

        /*lấy url_list_language_api*/
        var url_search = url_lang;
        if (!url_search.includes("?")) url_search += "?";
        url_search += "action=list&search=" + search + "&status=" + status;
        console.log("url", url_search);
        return get_page(url_search, null, show_list, "div_msg");
    }

    function show_list(html_result) {
        /**Đưa dữ liệu html vào thẻ div_lang_list */
        document.getElementById('div_table_lang_user').style.display = "block";
        document.getElementById('div_table_lang_user').innerHTML = html_result;
    }

    function show_activate_lang(obj) {
        if (!obj) return alert("error");

        const result = obj?.result;
        const msg = obj?.msg;
        const data = obj?.data

        const str_msg = Word[msg];

        if (result !== "ok") return alert("Error: " + str_msg);
        alert(str_msg);

        const uid_lang = data?.lang;
        view_lang(uid_lang);
        list_lang();
    }

    function activate_lang(uid_lang) {
        if (!confirm("Bạn có chắc chắn muốn thay đổi trạng thái ngôn ngữ này?")) return;

        var url_activate = url_lang;
        if (!url_activate.includes("?")) url_activate += "?";
        url_activate += "action=activate&lang=" + uid_lang;

        return get_data(url_activate, null, show_activate_lang, "div_msg");
    }

    var obj_window_language;

    $(document).ready(function() {
        list_lang();

        /*window org*/
        obj_window_language = new Window({
            "target": "div_window_language",
            "title": "Language Information"
        });

        /*window_place_content*/
        window_language_content = "<div id='div_window_language_content'>...</div>";
        obj_window_language.set(window_language_content);

    });
    /*end : $(document).ready(function()*/
</script>