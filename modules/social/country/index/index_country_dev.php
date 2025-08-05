<?php

/*get word in module */
$lang = $this->CurrentUser->lang;
$WordCountry = $this->load("Word");
$WordCountry->load("country|index", $lang);

/*get label info person*/
$label_title = $WordCountry->get("List of countries");

// Lấy thư viện Html, Table, Form
$Html = $this->load("Html");
$Table = $Html->load("Table");
$Form = $Html->load("Form");

//Gọi hàm loadModel của controller để tạo đối tượng CountryUser liên kết với bảng country_users  
$this->loadModel("CountryUser");

// Hiển thị form tạo, sửa
$div_msg = $Html->div("", "id='div_msg'");
echo $div_msg;

$div_window = $Html->div("", "id='div_window_country'");
echo $div_window;

// Hiển thị chi tiết thông tin country

// echo "<h1>Danh sách quốc gia</h1>";
echo $Html->heading($label_title);

// Lấy giá trị tham số search
$search = isset($_GET["search"]) ? $_GET["search"] : "";
$lang = isset($_GET["lang"]) ? $_GET["lang"] : "";

// Get language options
$array_lang_data = $this->request_api("language", "list");
$array_lang = isset($array_lang_data["data"]) ? $array_lang_data["data"] : [];
if (!empty($array_lang)) {
    array_unshift($array_lang, array("code" => "", "name" => "Tất cả ngôn ngữ"));
} else {
    $array_lang[] = array("code" => "", "name" => "Tất cả ngôn ngữ");
}
$select_lang = $Form->selectbox(array("name" => "lang", "id" => "lang", "onchange" => "list_country()"), $array_lang, $lang);

// get input_search, button_search, button_add
$input_search = $Form->textbox(array("name" => "search", "id" => "search", "value" => $search));
$button_search = $Form->button(array("id" => "button_search", "type" => "button", "class" => "search"), "Search");
$button_add = $Form->button(array("type" => "button", "class" => "right add", "onclick" => "input_country('')"), "Add");
$form_content = "Ngôn ngữ " . $select_lang . " " . $input_search . $button_search . $button_add;

// get form
$url_search = $this->get_link(array("controller" => "country", "function" => "index"));
$form_search = $Form->get(array("method" => "GET", "action" => $url_search), $form_content);

// get div
$div_search = $Html->div($form_search);
$div_table = $Html->div("loading", "id='div_table_country_user'");

echo $div_search . $div_table;

/* thư viện js window */
echo $Html->js($this->template_url . "js/form/window");
?>
<script>
    var obj_window_country;
    var url_country = "<?php echo $this->get_link(array("controller" => "country", "function" => "index")) ?>";

    const Word = {
        "country_exist": "Quốc gia đã tồn tại",
        "invalid_data": "Dữ liệu không hợp lệ",
        "no_uid": "Thiếu UID",
        "no_name": "Thiếu tên quốc gia",
        "no_code": "Thiếu mã quốc gia",
        "no_lang": "Thiếu ngôn ngữ",
        "no_des": "Thiếu mô tả",
        "update_ok": "Lưu thành công",
        "insert_ok": "Lưu thành công",
        "delete_ok": "Xóa thành công",
        "success": "Thành công",
    };

    function delete_country(uid_country) {
        if (!confirm("Bạn có chắc chắn muốn xóa quốc gia này?")) return;

        var url_delete = url_country;
        if (!url_delete.includes("?")) url_delete += "?";
        url_delete += "action=delete&country=" + uid_country;

        return get_data(url_delete, null, show_delete_country, "div_msg");
    }

    function show_delete_country(obj) {
        if (!obj) return alert("error");

        const result = obj?.result;
        const msg = obj?.msg;
        const str_msg = Word[msg];

        if (result !== "ok") return alert("Error: " + str_msg);
        alert(str_msg);

        list_country();
    }

    function show_info_country(html_result) {
        document.getElementById('div_window_country_content').innerHTML = html_result;
    }

    function view_country(uid_country) {
        if (uid_country === "") return alert("Error: no country!");

        obj_window_country.show();

        var url_view = url_country;
        if (!url_view.includes("?")) url_view += "?";
        url_view += `&action=info&country=${uid_country}`;
        console.log("url_show_view", url_view);

        return get_page(url_view, null, show_info_country, "div_msg");
    }


    function show_form_input(html_result) {
        // console.log("html_result", html_result);
        // document.getElementById('div_window_country_content').style.display = "block";
        document.getElementById('div_window_country_content').innerHTML = html_result;

        /*autocomplete các input*/
        $("#select_lang_input").autocomplete();
    }

    function input_country(uid_country) {
        // show window
        obj_window_country.show();

        // Get form input
        var url_input_form = "<?php echo $this->get_link(array("controller" => "country", "function" => "index", "get" => "action=input")); ?>";
        if (uid_country !== "") url_input_form += "&country=" + uid_country;

        console.log("url_input", url_input_form);
        return get_page(url_input_form, null, show_form_input, "div_msg");
    }

    // show table
    function list_country() {
        /*Lấy giá trị input_search  */
        var search = document.getElementById('search').value;
        var lang = document.getElementById('lang').value;
        /*lấy url_list_language_api*/
        var url_search = url_country;
        if (!url_search.includes("?")) url_search += "?";
        url_search += "action=list&search=" + search + "&lang=" + lang;
        return get_page(url_search, null, show_list, "div_table_country_user");
    }

    function show_list(html_result) {
        /**Đưa dữ liệu html vào thẻ div_lang_list */
        document.getElementById('div_table_country_user').style.display = "block";
        document.getElementById('div_table_country_user').innerHTML = html_result;
    }

    function show_save_country(obj) {
        document.getElementById("button_save").disabled = false;

        if (!obj) return alert("error");

        const result = obj?.result;
        const msg = obj?.msg;
        const data = obj?.data

        const str_msg = Word[msg];

        if (result !== "ok") return alert("Error: " + str_msg);
        alert(str_msg);

        const uid_country = data?.country;
        if (uid_country) view_country(uid_country);

        list_country();
    }

    function save_country() {
        document.getElementById("button_save").disabled = true;
        document.getElementById('lbl_name').innerHTML = "";

        /*kiểm tra input name có dữ liệu không? */
        if (document.getElementById('name').value == "") {
            document.getElementById('lbl_name').innerHTML = "Please input area name";
            document.getElementById('name').focus();
            document.getElementById("button_save").disabled = false;
            return;
        }

        /*data*/
        const formData = $('#form_input_country').serialize();

        return request_data(url_country, formData, show_save_country, "div_msg");
    }

    function change_lang_input() {
        // Hàm này được gọi khi user thay đổi ngôn ngữ trong form input
        // Với module country không cần xử lý gì đặc biệt vì country không phụ thuộc vào area
        console.log("Language changed");

        // Có thể thêm logic khác nếu cần, ví dụ:
        // - Validate dữ liệu theo ngôn ngữ
        // - Cập nhật placeholder text
        // - Reset form nếu cần
    }

    $(document).ready(
        function() {
            list_country();

            /*window org*/
            obj_window_country = new Window({
                "target": "div_window_country",
                "title": "Country Information"
            });

            /*window_place_content*/
            window_country_content = "...";
            obj_window_country.set(window_country_content);
        }
    );
</script>