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
$approved = isset($_GET["approved"]) ? $_GET["approved"] : "";
$approved_options = array(
    "" => "Tất cả trạng thái",
    "1" => "Đã duyệt",
    "0" => "Chưa duyệt"
);
$select_aprroved = $Form->selectbox(array("name" => "approved", "id" => "approved", "onchange" => "list_lang()"), $approved_options, $approved);

// Get input search, button search, button add
$input_search = $Form->textbox(array("name" => "search", "id" => "search", "value" => $search));
$button_search = $Form->button(array("id" => "button_search", "class" => "search", "type" => "button", "onclick" => "list_lang()"), "Search");

$form_content = "Trạng thái" . $select_aprroved . "Tìm kiếm " . $input_search . $button_search;

$url_search = $this->get_link(array("controller" => "lang", "function" => "index"));
$form_search = $Form->get(array("method" => "GET", "action" => $url_search), $form_content);

// Get div
$div_search = $Html->div($form_search);
$div_table = $Html->div("loading", "id='div_table_lang_user'");

echo $div_search . $div_table;

/* thư viện js window */
echo $Html->js($this->template_url . "js/form/window");
?>

<script>
    var url_lang = "<?php echo $this->get_link(array("controller" => "lang", "function" => "user")) ?>";

    const Word = {
        "no_uid": "Không tìm thấy uid",
        "invalid_data": "Lỗi khi lấy dữ liệu",
        "created": "Thêm mới ngôn ngữ thành công",
        "updated": "Cập nhật ngôn ngữ thành công",
        "deleted": "Xoá ngôn ngữ thành công",
        "approved": "Duyệt thành công",
    };

    function show_info_lang(html_result) {
        console.log("html result: ", html_result);
        document.getElementById('div_window_language_content').innerHTML = html_result;
    }

    function view_lang(uid_lang) {
        // show window
        obj_window_language.show();

        // Get link info
        var url_info = url_lang;
        if (!url_info.includes("?")) url_info += "?";
        url_info += "action=info&lang=" + uid_lang;

        return get_page(url_info, null, show_info_lang, "div_msg");
    }

    function list_lang() {
        loading("div_table_lang_user");

        /*Lấy giá trị input_search  */
        var search = document.getElementById('search').value;
        var approved = document.getElementById('approved').value;

        /*lấy url_list_language_api*/
        var url_search = url_lang;
        if (!url_search.includes("?")) url_search += "?";
        url_search += "action=list&search=" + search + "&approved=" + approved;;
        return get_page(url_search, null, show_list, "div_msg");
    }

    function show_list(html_result) {
        /**Đưa dữ liệu html vào thẻ div_lang_list */
        document.getElementById('div_table_lang_user').style.display = "block";
        document.getElementById('div_table_lang_user').innerHTML = html_result;
    }

    function show_approve_lang(obj) {
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

    function approve_lang(uid_lang) {
        if (!confirm("Bạn có chắc chắn muốn duyệt ngôn ngữ này?")) return;

        var url_approve = url_lang;
        if (!url_approve.includes("?")) url_approve += "?";
        url_approve += "action=approve&lang=" + uid_lang;

        return get_data(url_approve, null, show_approve_lang, "div_msg");
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