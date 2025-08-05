<script>
    var url_post = "<?php echo $this->get_link(array("controller" => "post", "function" => "index")) ?>";

    function get_area_list(str_area_code) {
        /*lưu lại str_code_parent_selected */
        str_code_parent_selected = str_area_code;

        let lang = document.getElementById("select_lang_list").value;

        /*lấy select parent_area_code*/
        var url_area = url_post;
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
        list_post();
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
        var url_street = url_post;
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

        list_post();


        // let lang = document.getElementById("select_lang_list").value;
        // let uid_street = $("#uid_street").val() || "";
        // get_place_in_list(area_str_code, lang, uid_street);
    }

    function change_street_list(street_uid) {
        // Không lưu street vào cookie nữa


        let lang = document.getElementById("select_lang_list").value;
        let area_code = document.getElementById("area_str_code").value;
        /* lưu lại street_uid vào biến uid_street */
        $("#uid_street").val(street_uid);
        // Reset place selection khi thay đổi street
        $("#uid_place").val("");

        get_place_in_list(area_code, lang, street_uid);
        list_post();


    }
    /* end: function change_street_list(street_uid) */

    function get_place_in_list(area_code, lang, street) {

        var url_place = url_post;
        if (!url_place.includes("?")) url_place += "?";
        url_place += "action=get_place&data_type=list";
        url_place += "&area=" + area_code + "&lang=" + lang + "&street=" + street;

        return get_page(url_place, null, show_place_in_list, "div_select_place_list");
    }

    function show_place_in_list(result) {
        $("#div_select_place_list").css("display", "block");
        $("#div_select_place_list").html(result);

        /*autocomplete street input*/
        $(".select_place_in_list").autocomplete();
        list_post();
    }

    function change_place_in_list(place_uid) {
        /* lưu lại place_uid vào biến uid_place */
        $("#uid_place").val(place_uid);
        // Reset place selection khi thay đổi street
        $("#uid_org").val("");
        let lang = document.getElementById("select_lang_list").value;
        let street_uid = document.getElementById("uid_street").value;
        let area_code = document.getElementById("area_str_code").value;

        get_org_list(area_code, lang, street_uid, place_uid);
        list_post();
    }
    /* end: function change_place_in_list(place_uid) */

    function get_org_list(area_code, lang, street, place) {

        var url_org = url_post;
        if (!url_org.includes("?")) url_org += "?";
        url_org += "action=get_org&data_type=list";
        url_org += "&area=" + area_code + "&lang=" + lang + "&street=" + street + "&place=" + place;

        return get_page(url_org, null, show_org_list, "div_select_org_list");
    }

    function show_org_list(result) {
        $("#div_select_org_list").css("display", "block");
        $("#div_select_org_list").html(result);

        /*autocomplete street input*/
        $(".select_org_list").autocomplete();
        list_post();
    }

    function change_org_list(org_uid) {
        /* lưu lại org_uid vào biến uid_place */
        $("#uid_org").val(org_uid);

        list_post();
    }
    /* end: function change_org_in_list(org_uid) */


    function list_post() {

        loading("div_post_table");

        var str_search = document.getElementById('search') ? document.getElementById('search').value : '';
        var area_str_code = document.getElementById('area_str_code') ? document.getElementById('area_str_code').value : '';
        var uid_street = document.getElementById('uid_street') ? document.getElementById('uid_street').value : '';
        var lang = document.getElementById('select_lang_list') ? document.getElementById('select_lang_list').value : '';
        var place = document.getElementById('uid_place') ? document.getElementById('uid_place').value : '';
        var org = document.getElementById('uid_org') ? document.getElementById('uid_org').value : '';
        /* request post/index?action=list để lấy danh sách post */
        var url_list = url_post;
        if (!url_list.includes("?")) url_list += "?";
        url_list += "action=list";
        url_list += "&area=" + area_str_code + "&lang=" + lang + "&search=" + str_search + "&street=" + uid_street + "&place=" + place + "&org=" + org;

        return get_page(url_list, null, show_post_list, "div_msg");
    }
    /* end: function list_post() */

    function show_post_list(result) {
        $("#div_post_table").html(result);
        if (uid_post_user_selected != '') show_post_info(uid_post_user_selected);
    }



    function show_post_info(view_uid_p_user) {
        /* backup uid_post_user_selected */
        uid_post_user_selected = view_uid_p_user;

        /* gán uid user area vào url */
        self.location.href = '#' + uid_post_user_selected;

        document.getElementById('div_window_post_content_title').innerHTML = "Infomation Post";
        obj_window_post.show();

        /*show title & tab*/
        $("#div_post_tab").css("display", "block");
        $("#div_window_area_content_title").css("display", "block");

        /*hide area list */
        $("#div_post_form_input").css("display", "none");
        $("#div_post_list").hide();

        /* show tab info default */
        tab_post.click('info');

        $("html, body").animate({
            scrollTop: 0
        }, "fast");
        return;
    }


    function close_window_post() {
        self.location.href = '';
        $("#div_post_list").show();
    }
    /*end : function close_window_post() */


    function view_post_tab(tab_name) {
        if (tab_name == 'info') return view_detail_post();
        document.getElementById('tab_post_content').innerHTML = tab_name;
    }

    function show_detail_post(result) {
        document.getElementById('tab_post_content').innerHTML = result;
    }

    function view_detail_post() {
        //loading('window_post_msg');
        var url_detail = url_post;
        if (!url_detail.includes("?")) url_detail += "?";
        url_detail += "action=info";
        url_detail += "&post=" + uid_post_user_selected;
        console.log(url_detail);

        return get_page(url_detail, null, show_detail_post, "window_post_msg");
    }
    /*end : function view_detail_post(view_uid_user_post) */

    function change_lang() {

        let selected_lang = document.getElementById("select_lang_list").value;

        // Không lưu lang vào cookie nữa
        $("#uid_street").val("");
        // Không lưu street vào cookie nữa

        get_area_list(area_str_code);
    }

    var area_str_code = '';
    var area_setting = '';
    var current_user = '';
    var parent_str_code = '';


    var obj_window_post;
    var uid_post_user_selected = '';



    function input_post(uid_user_post) {
        // Nếu không truyền uid_user_post, sử dụng uid_post_user_selected
        if (!uid_user_post) uid_user_post = uid_post_user_selected;

        obj_window_post.show();

        /*request post/input để lấy form */
        var url_input = url_post;
        if (!url_input.includes("?")) url_input += "?";
        url_input += "action=input";
        url_input += "&post=" + uid_user_post;

        console.log("input_post URL: ", url_input);
        return get_page(url_input, null, show_form_input, "div_msg");
    }
    /*end : function show_form(uid_user_area) */

    function show_form_input(result) {
        console.log("show_form_input called");
        console.log("Current uid_post_user_selected: ", uid_post_user_selected);

        /*đưa form vào thẻ div_window_area_content */
        $("#div_post_form_input").html(result);
        $("#div_post_form_input").css("display", "block");

        /*hide tab info*/
        $("#div_post_tab").css("display", "none");
        $("#div_window_post_content_title").css("display", "none");



        /*autocomplete các input*/
        $("#select_area_parent_input").autocomplete();
        $("#select_lang_input").autocomplete();
        $("#select_category_input").autocomplete();
        $("#select_type_input").autocomplete();
        $("#select_sent").autocomplete();


        /*hide list*/
        $('#div_post_list').hide();

        /*get str_code_parent_selected */
        let area_str_code_input = document.getElementById('area_str_code_input').value;
        console.log("area_str_code_input: ", area_str_code_input);

        /*get_area_parent_input */
        get_area_input(area_str_code_input);

    }
</script>