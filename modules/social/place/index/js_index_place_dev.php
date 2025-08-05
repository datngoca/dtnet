<script>
    var url_place = "<?php echo $this->get_link(array("controller" => "place", "function" => "index")) ?>";

    function get_area_list(str_area_code) {
        /*lưu lại str_code_parent_selected */
        str_code_parent_selected = str_area_code;

        let lang = document.getElementById("select_lang_list").value;

        /*lấy select parent_area_code*/
        var url_area = url_place;
        if (!url_area.includes("?")) url_area += "?";
        url_area += "action=get_area&data_type=list";
        url_area += "&area=" + str_area_code + "&lang=" + lang;

        console.log(url_area);
        return get_page(url_area, null, show_area_list, "div_select_area_list");
    }

    function show_area_list(result) {
        /* đưa selectbox vào div_area_parent_input */
        $("#div_select_area_list").css("display", "block");
        $("#div_select_area_list").html(result);

        /*autocomplete các input*/
        $(".select_area_list").autocomplete();

        // let lang = document.getElementById("select_lang_list").value;
        // let uid_street = $("#uid_street").val() || "";

        // get_street_list(area_str_code, lang);
        list_place();
    }


    function change_area_list(area_code) {
        // Không lưu area vào cookie nữa

        /* lưu lại area_code vào biến area_str_code */
        $("#area_str_code").val(area_code);
        // Reset street selection khi thay đổi area
        $("#uid_street").val("");
        // Reset place selection khi thay đổi area
        $("#uid_place").val("");
        // Không lưu street vào cookie nữa

        get_area_list(area_code);
        let lang = document.getElementById("select_lang_list").value;

        // Thêm dòng này để load street list khi area thay đổi
        get_street_list(area_code, lang);
    }
    /* end: function change_area_parent(area_code) */


    function get_street_list(area_code, lang) {
        var url_street = url_place;
        var parent_code = "";
        if (!url_street.includes("?")) url_street += "?";
        url_street += "action=get_street&data_type=list";
        url_street += "&area=" + area_code + "&parent=" + parent_code + "&lang=" + lang;

        return get_page(url_street, null, show_street_list, "div_select_street_list");
    }

    function show_street_list(result) {
        $("#div_select_street_list").css("display", "block");
        $("#div_select_street_list").html(result);

        /*autocomplete street input*/
        $(".select_street_list").autocomplete();

        list_place();


        // let lang = document.getElementById("select_lang_list").value;
        // let uid_street = $("#uid_street").val() || "";
        // get_place_in_list(area_str_code, lang, uid_street);
    }

    function change_street_list(street_uid) {
        let lang = document.getElementById("select_lang_list").value;
        let area_code = document.getElementById('area_str_code').value;

        /* lưu lại street_uid vào biến uid_street */
        $("#uid_street").val(street_uid);
        // Reset place selection khi thay đổi street
        $("#uid_place").val("");

        get_place_in_list(area_code, lang, street_uid);
        list_place();
    }
    /* end: function change_street_list(street_uid) */

    function get_place_in_list(area_code, lang, street) {

        var url_place_in = url_place;
        var parent_code = "";
        if (!url_place_in.includes("?")) url_place_in += "?";
        url_place_in += "action=get_place&data_type=list";
        url_place_in += "&area=" + area_code + "&parent=" + parent_code + "&lang=" + lang + "&street=" + street;

        return get_page(url_place_in, null, show_place_in_list, "div_select_place_list");
    }

    function show_place_in_list(result) {
        $("#div_select_place_list").css("display", "block");
        $("#div_select_place_list").html(result);

        /*autocomplete street input*/
        $(".select_place_in_list").autocomplete();
        list_place();
    }

    function change_place_in_list(place_uid) {
        /* lưu lại place_uid vào biến uid_place */
        $("#uid_place").val(place_uid);

        list_place();
    }
    /* end: function change_place_in_list(place_uid) */

    function list_place() {
        loading("div_place_table");

        var str_search = document.getElementById('search').value;
        var area_str_code = document.getElementById('area_str_code').value;
        var uid_street = document.getElementById('uid_street').value;
        var lang = document.getElementById('select_lang_list').value;
        var uid_place = document.getElementById('uid_place').value;

        /* request place/user?action=list để lấy danh sách place */
        var url_list = url_place;
        if (!url_list.includes("?")) url_list += "?";
        url_list += "action=list";
        url_list += "&area=" + area_str_code + "&lang=" + lang + "&search=" + str_search + "&street=" + uid_street + "&place_in=" + uid_place;


        return get_page(url_list, null, show_place_list, "div_msg");
    }
    /* end: function list_place() */

    function show_place_list(result) {
        $("#div_place_table").html(result);
        console.log("check result my: ", result)
        if (uid_place_user_selected != '') show_place_info(uid_place_user_selected);
    }



    function show_place_info(view_uid_place_user) {
        /* backup uid_place_user_selected */
        uid_place_user_selected = view_uid_place_user;

        /* gán uid user area vào url */
        self.location.href = '#' + uid_place_user_selected;


        /* show area name & parent*/
        var str_place_name = "";
        if ($("#place_name_" + view_uid_place_user).length) str_place_name = $("#place_name_" + view_uid_place_user).html();
        if ($("#area_str_name_" + view_uid_place_user).length) str_place_name += " - " + $("#area_str_name_" + view_uid_place_user).html();

        document.getElementById('div_window_place_content_title').innerHTML = str_place_name;
        obj_window_place.show();

        /*show title & tab*/
        $("#div_place_tab").css("display", "block");
        $("#div_window_area_content_title").css("display", "block");

        /*hide area list */
        $("#div_place_form_input").css("display", "none");
        $("#div_place_list").hide();

        /* show tab info default */
        tab_place.click('info');

        $("html, body").animate({
            scrollTop: 0
        }, "fast");
        return;
    }


    function close_window_place() {
        self.location.href = '';
        $("#div_place_list").show();
    }
    /*end : function close_window_place() */


    function view_place_tab(tab_name) {
        if (tab_name == 'info') return view_detail_place();
        document.getElementById('tab_place_content').innerHTML = tab_name;
    }

    function show_detail_place(result) {
        document.getElementById('tab_place_content').innerHTML = result;
    }

    function view_detail_place() {
        //loading('window_place_msg');
        var url_detail = url_place;
        if (!url_detail.includes("?")) url_detail += "?";
        url_detail += "action=info";
        url_detail += "&place=" + uid_place_user_selected;
        console.log(url_detail);

        return get_page(url_detail, null, show_detail_place, "window_place_msg");
    }
    /*end : function view_detail_place(view_uid_user_area) */

    function change_lang() {

        let selected_lang = document.getElementById("select_lang_list").value;

        /*keep selected lang in cookie*/
        $("#uid_street").val("");

        get_area_list(area_str_code);
    }

    var area_str_code = '';
    var area_setting = '';
    var current_user = '';
    var parent_str_code = '';


    var obj_window_place;
    var uid_place_user_selected = '';



    function input_place(uid_user_place) {
        // Nếu không truyền uid_user_place, sử dụng uid_place_user_selected
        if (!uid_user_place) uid_user_place = uid_place_user_selected;

        obj_window_place.show();

        /*request place/input để lấy form */
        var url_input = url_place;
        if (!url_input.includes("?")) url_input += "?";
        url_input += "action=input";
        url_input += "&place=" + uid_user_place;

        console.log("input_place URL: ", url_input);
        return get_page(url_input, null, show_form_input, "div_msg");
    }
    /*end : function show_form(uid_user_area) */

    function show_form_input(result) {
        console.log("show_form_input called");
        console.log("Current uid_place_user_selected: ", uid_place_user_selected);

        /*đưa form vào thẻ div_window_area_content */
        $("#div_place_form_input").html(result);
        $("#div_place_form_input").css("display", "block");

        /*hide tab info*/
        $("#div_place_tab").css("display", "none");
        $("#div_window_place_content_title").css("display", "none");



        /*autocomplete các input*/
        $("#select_area_parent_input").autocomplete();
        $("#select_lang_input").autocomplete();
        $("#select_sent").autocomplete();


        /*hide list*/
        $('#div_place_list').hide();

        /*get str_code_parent_selected */
        let area_str_code_input = document.getElementById('area_str_code_input').value;
        console.log("area_str_code_input: ", area_str_code_input);

        /*get_area_parent_input */
        get_area_input(area_str_code_input);

    }
</script>