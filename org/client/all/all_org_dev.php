<?php
$Html = $this->load("Html");

/**Tạo đối tượng Table  */
$Table = $Html->load("Table");

echo $Html->div("", " id ='div_window_org'");
echo $Html->heading("Danh sách tổ chức");

$span_msg =  $Html->span("", " id ='div_msg'");

/**Tạo đối tượng form */
$Form = $Html->load("Form");

/** Gọi hàm input() của đối tượng Form để tạo chuỗi <input> */
$search = '';
$input_search = $Form->textbox(array("name" => "search", "value" => $search, "id" => "input_search", "onkeyup" => "load_all_org()", "autocomplete" => "off"));
$button_search = $Form->button(array("type" => "button", "onclick" => "load_all_org()"), "Search");


/**Tạo chuỗi form_content gồm có Tìm kiếm:, input_search, button_search, link_input  */
$form_content = "Tìm Kiếm" . $input_search . $button_search . $span_msg;

/*form*/
$url_search = $this->get_link(array("controller" => "org", "function" => "all"));
$form_search = $Form->get(array("method" => "GET", "action" => $url_search), $form_content);

echo $form_search;

echo $Html->div("", " id ='div_org_list'");

echo $Html->js($this->template_url . "js/form/window");
?>
<style>
    #div_org_list {
        padding: 20px 10px;
        min-height: 500px;
    }
</style>
<div id="org_item_sample" style="display: none;">

    `<div class="box_talk" onclick="view_org('${uid_org}')">
        <div class="box_talk_header">
            <img src="${str_img_profile}" alt="" />
            <div id="box_talk_header_info" class="box_talk_header_info">
                <a href="javascript:void(0)">${org_name}</a>
                <span>${business_activity}</span>
                <span>${phone}</span>
                <span>${email}</span>
                <span>Address: ${str_address}</span>
                <span>Status: ${str_status}</span>

            </div>
        </div>
    </div>`

</div>
<style>
    :root {
        --cl-primary: #050505;
        --cl-text: var(--cl-primary);
        --cl-text-second: #65676B;
        --btn-primary: #3498db;
        --btn-second: #ff7675;
        --post-bg: #EBEDF0;
        --header-bg: #0d7252;
        --header-border: #30aa83;
        --cl-border: #CCD0D5;
        --cl-title: #2980b9;
        --cl-border-form: #2699b0;
        --bg-primary: #f5f6fa;
        --text-btn-primary: #fff;
        --cl-border-input: #2f83b7;
    }

    /*begin: box_talk */
    .box_talk_footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .box_talk_footer_left {
        display: flex;
        align-items: center;
    }

    .box_talk_footer_right {
        color: var(--cl-text-second);
        cursor: pointer;
    }

    .box_talk {
        width: 100%;
        height: auto;
        margin-bottom: 10px;
        padding: 5px 0px 1px 0px;
        background-color: var(--post-bg);
        border: 1px solid var(--cl-border);
        border-radius: 10px;
        overflow-x: hidden;
        position: relative;
    }

    .box_talk_header {
        position: relative;
        margin: 0px 0px;
        width: 100%;
        height: auto;
        border: solid 0px;
        padding: 3px 5px;
        display: table;
    }

    .box_talk_header .post_time {
        color: #4A4A4A;
        font-size: 12px;
    }

    .box_talk_header img {
        border-radius: 50%;
        width: 45px;
        height: 45px;
        display: block;
        float: left;
    }

    .box_talk_header_info {
        width: calc(100% - 80px);
        float: left;
        line-height: 20px;
        padding: 0px 5px;
    }

    .box_talk_header_info a,
    a:visited {
        font-weight: bold;
        color: var(--cl-text);
        text-decoration: none;
        font-size: 14px
    }

    .box_talk_header_info span {
        font-size: 14px;
        color: var(--cl-text);
        display: block;
    }

    .box_talk_header_setting {
        width: 29px;
        height: 29px;
        float: right;
        text-align: center;
        cursor: pointer;
        border-radius: 50%;
        border: 1px solid var(--cl-border);
        font-size: 16px;
    }

    .box_talk_content {
        font-size: 15px;
        color: var(--cl-text);
        width: 100%;
        margin: 0px;
        background-color: white;
        padding: 10px;
        line-height: 20px;
        min-height: 50px;
    }

    .box_talk_content .price {
        color: #e74c3c;
        opacity: 0.9;
        background-color: transparent !important;
    }

    .box_talk_content .des {
        color: #050505;
        opacity: 0.8;
        margin: 4px 0px;
    }

    .box_talk_content .content {
        display: -webkit-box;
        -webkit-line-clamp: 5;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-top: 10px;
        font-weight: 500;
        opacity: 0.8;
    }

    .box_talk_address {
        line-height: 18px;
        font-size: 14px;
        background-color: white;
        padding: 5px 10px 10px 10px;
        width: 100%;
        float: left;
        color: var(--cl-text-second);
    }

    .box_talk_address span {
        font-weight: bold;
        color: var(--cl-text);
        font-size: 13px;
    }

    .box_talk_address_location {
        background-image: url(../../../images/icon/area.png);
        background-repeat: no-repeat;
        background-size: 18px;
        width: 18px;
        height: 18px;
        margin-right: 5px;
        display: inline-block;
    }

    .box_talk_info {
        width: 100%;
        height: auto;
        display: table;
        padding: 20px 10px 10px 10px;
        border-radius: 0px 0px 10px 10px;
        background-color: white;
        position: relative;
        border-top: 1px solid #EBEDF0;
    }

    .box_talk_info .icon {
        margin: -3px 0px 0px 0px
    }

    .box_talk_num_liked {
        cursor: pointer;
        font-size: 15px;
        color: var(--cl-text-second);
        padding: 0px 0px;
    }

    .box_talk_num_comment {
        cursor: pointer;
        font-size: 15px;
        color: var(--cl-text-second);
        padding: 0px 5px 0px 30px;
        background-size: 21px;
        background-repeat: no-repeat;
    }

    .box_talk_button_like {
        background-repeat: no-repeat;
        font-size: 15px;
        font-weight: bold;
        color: var(--cl-text-second);
        background-color: white;
        margin: 10px;
        padding: 10px 0px 10px 15px;
        border-radius: 5px;
        border: 1px solid #CCD0D5;
        width: 100px;
        cursor: pointer;
    }

    .box_talk_button_like:hover,
    .send-comment:hover,
    .comment-react:hover {
        background-color: #1877F2;
        color: white;
    }
</style>
<script>
    var uploader1;
    var uploader2;
    var area_str_code_selected = "";
    var is_busy = false;
    var token_list = false;
    var page = 1;
    var flag_get_data = true;
    var url_all_org = "<?php echo $this->get_link(array("controller" => "org", "function" => "all")) ?>";
    var page_mode = "list";

    function load_all_org() {
        page = 0;
        token_list = create_UUID();
        $('#div_org_list').html("");

        get_all_org();
        is_busy = false;
        flag_get_data = true;
    }

    function get_all_org() {
        if (is_busy == true) return;
        if (flag_get_data == false) return;

        page++;
        var search = document.getElementById('input_search').value;
        var url_all_org_list = url_all_org;
        if (url_all_org_list.indexOf("?") === -1) url_all_org_list += "?";
        url_all_org_list += "&action=list&search=" + search + "&page=" + page + "&token_list=" + encodeURIComponent(token_list);
        console.log(url_all_org_list);
        return get_page(url_all_org_list, null, show_org_user, "div_msg");
    }

    function show_org_user(html_result) {
        /*no busy*/
        is_busy = false;

        /*parse data*/
        obj_user_org_list = null;
        try {
            obj_user_org_list = JSON.parse(html_result);
        } catch (err) {};
        if (obj_user_org_list == null) {
            flag_get_data = false;
            $('#div_msg').html("No data");

            return;
        }

        let array_org = null;
        if (obj_user_org_list.hasOwnProperty("data_list")) array_org = obj_user_org_list.data_list;
        if (obj_user_org_list.hasOwnProperty("token_list")) token_list = obj_user_org_list.token_list;

        if (array_org == null) {
            $('#div_msg').html("No data");
            flag_get_data = false;
            return;
        }

        let num_org = array_org.length;
        if (num_org < 1) {
            $('#div_msg').html("No data");
            flag_get_data = false;
            return;
        }

        let str_org = "";
        for (let i = 0; i < num_org; i++) {
            uid_org = array_org[i].uid;

            uid_user = array_org[i].uid_user;
            user_fullname = array_org[i].user_fullname;
            img_profile = array_org[i].img_profile;
            org_name = array_org[i].name;
            uid_org_user = array_org[i].uid;
            business_activity = array_org[i].business_activity;
            phone = array_org[i].phone;
            email = array_org[i].email;
            str_address = array_org[i].str_address;

            status = array_org[i].status;
            str_status = "In active";
            if (status == "1") str_status = "Active";
            str_img_profile = template_url + "images/pages/profile/profile_h.png";
            if (img_profile != "") str_img_profile = file_url + img_profile;

            str_org += eval(document.getElementById("org_item_sample").innerHTML);

        }


        /* Đưa dữ liệu html vào thẻ div_org_list */
        $('#div_org_list').append(str_org);
    }

    function show_list_org(html_result) {
        /**Đưa dữ liệu html vào thẻ div_org_list */
        document.getElementById('div_org_list').style.display = "block";
        document.getElementById('div_org_list').innerHTML = html_result;
    }

    function show_org_info(html_result) {
        document.getElementById('div_org_form_input').style.display = "block";
        document.getElementById('div_org_form_input').innerHTML = html_result;
        document.getElementById('div_org_list').style.display = "none";
    }

    function change_lang_input() {
        area_str_code_selected = '';
        get_area_input('');
    }

    function change_street_input() {
        get_place_org()
    }

    function get_street_input() {
        let lang = document.getElementById("select_lang_input").value;
        let uid_street = document.getElementById("hidden_street_input").value;

        /*lấy select street*/
        var url_street_input = "<?php echo $this->get_link(array("controller" => "org", "function" => "index", "get" => "action=get_street&data_type=input")) ?>";
        url_street_input += "&area=" + area_str_code_selected + "&parent=&lang=" + lang + '&street=' + uid_street;
        return get_page(url_street_input, null, show_street_input, "div_street_input");
    }

    function show_street_input(html_result) {
        document.getElementById('div_street_input').style.display = "block";
        document.getElementById('div_street_input').innerHTML = html_result;
        $("#select_street_input").autocomplete();
        get_place_org();
    }

    function get_place_org() {
        let lang = document.getElementById("select_lang_input").value;
        let street = document.getElementById("select_street_input").value;
        let uid_place = document.getElementById("hidden_place_input").value;

        /*lấy select place*/
        var url_place_input = "<?php echo $this->get_link(array("controller" => "org", "function" => "index", "get" => "action=get_place&data_type=input")) ?>";
        url_place_input += "&area=" + area_str_code_selected + "&parent=&lang=" + lang;
        url_place_input += "&street=" + street + "&place=" + uid_place;
        return get_page(url_place_input, null, show_place_input, "div_place_input");
    }

    function show_place_input(html_result) {

        document.getElementById('div_place_input').style.display = "block";
        document.getElementById('div_place_input').innerHTML = html_result;
        $("#select_place_input").autocomplete();
    }

    function get_area_input(str_area_code) {
        let lang = document.getElementById("select_lang_input").value;
        let url_area_input = "<?php echo $this->get_link(array("controller" => "org", "function" => "index", "get" => "action=get_area&data_type=input")) ?>";
        url_area_input += "&area=" + str_area_code + "&parent=&lang=" + lang;
        return get_page(url_area_input, null, show_area_input, "div_area_input");
    }

    function show_area_input(html_result) {
        document.getElementById('div_area_input').style.display = "block";
        document.getElementById('div_area_input').innerHTML = html_result;
        $(".select_area_input").autocomplete();
        get_street_input();
    }

    function change_area_input(area_code) {
        /*lưu lại area_str_code_selected */
        area_str_code_selected = area_code;
        document.getElementById('hidden_area_input').value = area_code;
        get_area_input(area_code);
        get_street_input();
    }

    function show_org_result(str_result) {
        console.log(str_result);
        document.getElementById("button_save").disabled = false;

        let obj_result;
        try {
            obj_result = JSON.parse(str_result)
        } catch (error) {}
        if (obj_result == null) return alert("Error");

        let result = "";
        if (obj_result.hasOwnProperty("result")) result = obj_result.result;

        if (result === 'ok') alert("save sucessfull");


        obj_window_org.close();
        document.getElementById('div_org_list').style.display = "block";
        load_all_org();
    }

    function check() {

        /**Lấy giá trị input name */
        if (document.getElementById("name").value == "") {
            alert("Please input name ");
            return document.getElementById("name").focus();

        }

        /**Lấy giá trị input code */
        if (document.getElementById("code").value == "") {
            alert("Please input code ");
            return document.getElementById("code").focus();

        }
        /* check upload file img_profile */
        if (uploader1.num_selected > 0) return uploader1.start();
        if (uploader2.num_selected > 0) return uploader2.start();

        save_org();

    }

    function save_org() {
        document.getElementById("button_save").disabled = true;

        $("#hidden_address").val($("#div_address_value").html());

        var url_save_org = "<?php echo $this->get_link(array("controller" => "org", "function" => "index", "get" => "action=save")) ?>";
        const form_data = new FormData(document.getElementById('form_input'));
        submit_form(url_save_org, form_data, show_org_result, 'div_msg', false);
    }

    var uid_org_selected = "";

    function view_org(uid_org = "") {
        uid_org_selected = uid_org;

        obj_window_org.show();
        var url_info = "<?php echo $this->get_link(array("controller" => "org", "function" => "all", "get" => "action=view")) ?>";
        url_info += "&org=" + uid_org;

        console.log(url_info);
        return get_page(url_info, null, show_view_org, "div_org_form_input");
    }

    function active_org(uid_org) {
        var url_active = "<?php echo $this->get_link(array("controller" => "org", "function" => "all", "get" => "action=active")) ?>";
        url_active += "&org=" + uid_org;

        console.log(url_active);
        return get_page(url_active, null, show_active_result, "div_org_form_input");
    }

    function show_active_result() {
        view_org(uid_org_selected);
    }

    function show_view_org(html_result) {
        page_mode = "view";
        let anchor = uid_org_selected;
        if (anchor == "") anchor = "input";
        window.history.pushState({}, "Input Organization", url_all_org + "#" + anchor);

        document.getElementById('div_org_form_input').style.display = "block";
        document.getElementById('div_org_form_input').innerHTML = html_result;
        document.getElementById('div_org_list').style.display = "none";

        /*Làm select_lang_input auto complete */
        /*$("#select_lang_input" ).autocomplete();	
        $("#select_type_input" ).autocomplete();
        $("#select_org_status" ).autocomplete();
        create_uploader_view_org();

        let str_img_profile = document.getElementById('img_profile').value;
        let str_img_banner = document.getElementById('img_banner').value;
        if(str_img_profile != "")uploader1.show(str_img_profile);
        if(str_img_banner != "") uploader2.show(str_img_banner);*/

        //get_org_address();
    }

    function get_org_address() {
        let str_org_address = $("#div_address_value").html();

        let obj_org_address = null;
        try {
            obj_org_address = JSON.parse(str_org_address);
        } catch (err) {};

        if (obj_org_address == null) obj_org_address = {};

        obj_org_address.callback = get_address;
        Address.load(obj_org_address);
    }

    function close_window_org() {
        page_mode = "list";
        document.getElementById('div_org_list').style.display = "block";
    }

    function load_address(obj_data) {
        console.log(obj_data);

        if (obj_data == null) return;
        if (!obj_data.hasOwnProperty("member_info")) return;
        let member_info = obj_data.member_info;

        /*country code, area*/
        let data_address = {};
        data_address.country_code = member_info.country_code;
        data_address.country_name = member_info.country_name;
        data_address.area_str_code = member_info.area_str_code;
        data_address.area_str_name = member_info.area_str_name;
        data_address.area_str_address = member_info.area_str_address;

        data_address.area_str_name_reverse = member_info.area_str_name_reverse;
        data_address.sub_area_name = member_info.sub_area_name;

        /*street, place*/
        data_address.uid_street = member_info.uid_street;
        data_address.street_name = member_info.street_name;

        data_address.uid_place = member_info.uid_place;
        data_address.place_name = member_info.place_name;

        data_address.street_number = member_info.street_number;

        data_address.uid_place_in = member_info.uid_place_in;
        data_address.place_name_in = member_info.place_name_in;

        data_address.place_info = member_info.place_info;

        data_address.address = member_info.address;
        data_address.str_address = member_info.str_address;

        /*set callback function*/
        data_address.callback = get_address;

        Address.load(data_address);
    }

    function show_address() {
        Address.show();
    }

    function get_address() {
        let str_address = Address.str_address;
        if (Address.place_info != "") str_address += "&nbsp; <span class='place_info'>(" + Address.place_info + ")</span>";

        $("#div_address").html(str_address);

        /*get address data*/
        let obj_address = Address.get();

        $("#div_address_value").html(JSON.stringify(obj_address));

        console.log(obj_address);
    }

    function create_uploader_view_org() {
        param_upload = {
            "target": "#button_select_profile_org",
            "value": "img_profile",
            "done": "upload_done_img_profile",
            "ext": "jpg,png,jpeg",
            "show_file_name": false,
            "show_result": false,
        };
        param_upload2 = {
            "target": "#button_select_banner_org",
            "value": "img_banner",
            "done": "upload_done_img_banner",
            "ext": "jpg,png,jpeg",
            "show_file_name": false,
            "show_result": false,
        };
        try {
            uploader1 = new Uploader(param_upload);
            uploader2 = new Uploader(param_upload2);
        } catch (error) {
            console.log("error:" + error);
        }
    }


    // function setting_img_banner(){
    //    if(uploader1.num_selected > 0) return uploader.start();

    // }
    /*end: function setting_img_banner() */

    function upload_done_img_profile(params) {
        if (uploader2.num_selected > 0) return uploader2.start();
        save_org();
    }

    function upload_done_img_banner(params) {
        save_org();
    }


    function scroll_load_org() {

        if (flag_get_data == false) return;
        if (page_mode != "list") return;


        let sroll_position = $(window).height() - $(window).scrollTop();
        if (sroll_position <= 120 && flag_get_data == true) return get_all_org();



    }
    /*end: function scroll_load_post *
	 
   var obj_window_org;

   /**Hàm được gọi sau khi client tải hết javascript  */
    $(document).ready(function() {

        /*tạo đối tượng window org*/
        obj_window_org = new Window({
            "target": "div_window_org",
            "close": close_window_org,
            "title": "org Information"
        });

        /*window_area_content*/
        window_org_content = "<div id = 'div_org_form_input'>...</div>";
        obj_window_org.set(window_org_content);

        load_all_org();

        let anchor = window.location.hash;
        let str_anchor = "";
        if (anchor) str_anchor = anchor.substring(1);
        if (str_anchor != "") view_org(str_anchor);

        $(window).on('scroll', scroll_load_org);

    })
</script>