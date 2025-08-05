<script>
    function get_area_list(str_area_code) {
        /*lưu lại str_code_parent_selected */
        str_code_parent_selected = str_area_code;

        let lang = document.getElementById("select_lang_list").value;

        /*lấy select parent_area_code*/
        var url_area_list = "<?php echo $this->get_link(array("controller" => "street", "function" => "index", "get" => "action=get_area&source=list")) ?>";
        url_area_list += "&area=" + str_area_code + "&parent=&lang=" + lang;

        console.log(url_area_list);
        return get_page(url_area_list, null, show_area_list, "div_select_area_list");

    }

    function show_area_list(result) {
        /* đưa selectbox vào div_area_parent_input */
        $("#div_select_area_list").css("display", "block");
        $("#div_select_area_list").html(result);


        /*autocomplete các input*/
        $(".select_area_list").autocomplete();

        list_street();
    }


    function change_area_list(area_code) {
        /*keep selected area in cookie*/
        setCookie("area_index", area_code);

        /* lưu lại area_code vào biến area_str_code */
        $("#area_str_code").val(area_code);

        get_area_list(area_code);
    }
    /* end: function change_area_parent(area_code) */


    function show_list_street(result) {
        $("#div_street_table").html(result);
    }

    function list_street() {

        loading("div_street_table");

        var str_search = document.getElementById('search').value;
        var area_str_code = document.getElementById('area_str_code').value;
        var lang = document.getElementById('select_lang_list').value;
        if (lang == "") area_str_code = "";

        /* request user_area/input?action=get_area để lấy area */
        var url_street = "<?php echo $this->get_link(array("controller" => "street", "function" => "index", "get" => "action=list")) ?>";
        url_street += "&area=" + area_str_code + "&lang=" + lang + "&search=" + str_search;


        return get_page(url_street, null, show_list_street, "div_msg");

    }
    /* end: function list_street() */



    function show_street_info(view_uid_street_user) {
        /* backup uid_street_user_selected */
        uid_street_user_selected = view_uid_street_user;

        /* gán uid user area vào url */
        self.location.href = '#' + uid_street_user_selected;


        obj_window_street.show();

        /*show title & tab*/
        $("#div_street_tab").css("display", "block");
        $("#div_window_area_content_title").css("display", "block");

        /*hide area list */
        $("#div_street_form_input").css("display", "none");
        $("#div_street_list").hide();

        /* show tab info default */
        tab_street.click('info');

        $("html, body").animate({
            scrollTop: 0
        }, "fast");
        return;
    }


    function close_window_street() {
        self.location.href = '';
        $("#div_street_list").show();
    }
    /*end : function close_window_street() */


    function view_street_tab(tab_name) {
        if (tab_name == 'info') return view_detail_street();
        if (tab_name == 'cross') return view_cross_street_tab();

        document.getElementById('tab_street_content').innerHTML = tab_name;
    }



    function show_street_cross_tab(html_content) {
        document.getElementById('tab_street_content').innerHTML = html_content;

        /*get  selectbox area cross*/
        get_selectbox_area_street_cross();

        /*function in js_cross_street*/
        get_list_area_street_cross();
    }

    /* hàm được gọi khi click vào tab cross ở trong window street*/
    function view_cross_street_tab() {

        var url_street_cross = "<?php echo $this->get_link(array("controller" => "street", "function" => "index", "get" => "action=cross")) ?>";
        url_street_cross += "&street=" + uid_street_user_selected;

        return get_page(url_street_cross, null, show_street_cross_tab, "window_street_msg");
    }
    /*end : function area_cross() */


    function show_detail_street(result) {
        document.getElementById('tab_street_content').innerHTML = result;


        /*save street_lang, street_area_str_code*/
        street_lang = document.getElementById('span_street_lang').innerHTML;
        street_area_str_code = document.getElementById('span_street_area_code').innerHTML;
        area_str_code_cross = street_area_str_code;

        /* show title*/
        str_street_title = $("#span_street_name").html();
        str_street_title += " - " + $("#span_area_name").html();

        document.getElementById('div_window_street_content_title').innerHTML = str_street_title;
    }

    function view_detail_street() {
        //loading('window_street_msg');
        var url_street_detail = "<?php echo $this->get_link(array("controller" => "street", "function" => "index", "get" => "action=info")) ?>";
        url_street_detail += "&street=" + uid_street_user_selected;
        console.log(url_street_detail);

        return get_page(url_street_detail, null, show_detail_street, "window_street_msg");

    }
    /*end : function view_detail_street(view_uid_user_area) */

    function change_lang() {
        selected_lang = document.getElementById("select_lang_list").value;
        setCookie("lang_index", selected_lang);

        get_area_list(area_str_code);
    }

    var selected_lang = "";
    var area_str_code = '';
    var area_setting = '';
    var current_user = '';
    var parent_str_code = '';
    var str_code_parent_selected = '';

    var obj_window_street;
    var uid_street_user_selected = '';

    /*lang, area, area_street for cross*/
    var street_lang = "vn";
    var area_str_code_cross = "";
    var street_area_str_code = "";

    function input_street(uid_user_street) {
        obj_window_street.show();

        /*request street/input để lấy form */
        var url_street_input = "<?php echo $this->get_link(array("controller" => "street", "function" => "index", "get" => "action=input")); ?>";
        url_street_input += "&street=" + uid_user_street;
        return get_page(url_street_input, null, show_form_input, "div_msg");


    }
    /*end : function show_form(uid_user_area) */

    function delete_street(uid_user_street) {
        if (!confirm("Bạn có chắc chắn muốn xóa đường phố này?")) return;

        /*request street/delete để xóa */
        var url_street_delete = "<?php echo $this->get_link(array("controller" => "street", "function" => "index", "get" => "action=delete")); ?>";
        url_street_delete += "&street=" + uid_user_street;

        return get_data(url_street_delete, null, show_delete_street, "div_msg");
    }
    /*end : function delete_street(uid_user_area) */

    function show_delete_street(obj) {
        if (!obj) return alert("error");

        const result = obj?.result;
        const msg = obj?.msg;
        const str_msg = Word[msg] || msg;

        if (result !== "ok") return alert("Error: " + str_msg);
        alert(str_msg);

        list_street();
    }

    function show_form_input(result) {
        /*đưa form vào thẻ div_window_area_content */
        $("#div_street_form_input").html(result);
        $("#div_street_form_input").css("display", "block");

        /*hide tab info*/
        $("#div_street_tab").css("display", "none");
        $("#div_window_street_content_title").css("display", "none");

        /*autocomplete các input*/
        $("#select_area_parent_input").autocomplete();
        $("#select_lang_input").autocomplete();
        $("#select_sent").autocomplete();

        /*hide list*/
        $('#div_street_list').hide();

        /*get str_code_parent_selected */
        let area_str_code_input = document.getElementById('area_str_code_input').value;

        /*get_area_parent_input */
        get_area_input(area_str_code_input);
    }
</script>