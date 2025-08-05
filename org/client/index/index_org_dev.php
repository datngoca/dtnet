<?php
$Html = $this->load("Html");

/**Tạo đối tượng Table  */
$Table = $Html->load("Table");
echo $Html->div("", " id ='div_msg'");
echo $Html->div("", " id ='div_window_org'");
echo $Html->heading("Danh sách tổ chức");

/**Tạo đối tượng form */
$Form = $Html->load("Form");

/** Gọi hàm input() của đối tượng Form để tạo chuỗi <input> */
$search = '';
$input_search = $Form->textbox(array("name" => "search", "value" => $search, "id" => "input_search", "onkeyup" => "load_org_user()"));
/* $input_search = "<input type = 'text' name = 'search' 'value' = '$search'>";**/

/***Gọi hàm button của đối tượng Form để tạo chuỗi <button> */
$button_search = $Form->button(array("type" => "button", "onclick" => "load_org_user()"), "Search");
// $button_search = "<button type = 'button' onclick = "get_org_user()" >Search</button>";

/**Gọi hàm link() của đối tượng $Html để tạo chuỗi <a> </a> */
$url_input = $this->get_link(array("controller" => "org", "function" => "index", "get" => "action=input"));
$button_input = $Form->button(array("type" => "button", "onclick" => "input_org('')"), "Thêm mới");
// $link_input = "<a href='$url_input' class = 'button add right'>Thêm mới</a>";

/**Tạo chuỗi form_content gồm có Tìm kiếm:, input_search, button_search, link_input  */
$form_content = "Tìm Kiếm" . $input_search . $button_search . $button_input;

/*Gọi hàm get() của đối tượng form để lấy thẻ <form> </form> */
$url_search = $this->get_link(array("controller" => "org", "function" => "index"));
$form_search = $Form->get(array("method" => "GET", "action" => $url_search), $form_content);
/**$form_search = "<form method = 'GET' action = '/task/index' > </form>"; */

echo $form_search;

echo $Html->div("", " id ='div_org_list'");
/*<div id = 'div_org_list'> Danh sách ngôn ngữ </div> */

echo $Html->js($this->template_url . "js/form/window");
?>
<style>
    #div_org_list {
        padding: 20px 10px;
    }
</style>
<div id="org_user_item_sample" style="display: none;">

    `<div class="box_talk" onclick="input_org('${uid_org_user}')">
        <div class="box_talk_header">
            <img src="${str_img_profile}" alt="" />
            <div id="box_talk_header_info" class="box_talk_header_info">
                <a href="javascript:void(0)">${org_name}</a>
                <span>${business_activity}</span>
                <span>${phone}</span>
                <span>${email}</span>
                <span>Address: ${str_address}</span>
            </div>
        </div>
    </div>`

</div>
<script>
    var uploader1;
    var uploader2;
    var area_str_code_selected = "";
    var is_busy = false;
    var token_list = false;
    var page = 1;
    var flag_get_data = true;
    var url_org_user = "<?php echo $this->get_link(array("controller" => "org", "function" => "index")) ?>";
    var page_mode = "list";

    function load_org_user() {
        page = 0;
        token_list = create_UUID();
        get_org_user();
        is_busy = false;
        flag_get_data = true;
        $('#div_org_list').html("");
    }

    function get_org_user() {
        if (is_busy == true) return;
        if (flag_get_data == false) return;

        page++;
        var search = document.getElementById('input_search').value;
        var url_org_user_list = url_org_user;
        if (url_org_user_list.indexOf("?") === -1) url_org_user_list += "?";
        url_org_user_list += "&action=my&search=" + search + "&page=" + page + "&token_list=" + encodeURIComponent(token_list);
        console.log(url_org_user_list);
        return get_page(url_org_user_list, null, show_org_user, "div_msg");
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
            uid_user = array_org[i].uid_user;
            user_fullname = array_org[i].user_fullname;
            img_profile = array_org[i].img_profile;
            org_name = array_org[i].name;
            uid_org_user = array_org[i].uid;
            business_activity = array_org[i].business_activity;
            phone = array_org[i].phone;
            email = array_org[i].email;
            str_address = array_org[i].str_address;

            str_img_profile = template_url + "images/pages/profile/profile_h.png";
            if (img_profile != "") str_img_profile = file_url + img_profile;

            str_org += eval(document.getElementById("org_user_item_sample").innerHTML);

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
        get_org_user();
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

    var uid_org_user_selected = "";

    function input_org(uid_org_user = "") {
        uid_org_user_selected = uid_org_user;

        /**Show window org */
        obj_window_org.show();
        var url_input = "<?php echo $this->get_link(array("controller" => "org", "function" => "index", "get" => "action=input")) ?>";
        url_input += "&org=" + uid_org_user;
        return get_page(url_input, null, show_input_org, "div_org_form_input");
    }

    function show_input_org(html_result) {
        page_mode = "input";
        let anchor = uid_org_user_selected;
        if (anchor == "") anchor = "input";
        window.history.pushState({}, "Input Organization", url_org_user + "#" + anchor);

        document.getElementById('div_org_form_input').style.display = "block";
        document.getElementById('div_org_form_input').innerHTML = html_result;
        document.getElementById('div_org_list').style.display = "none";

        /*Làm select_lang_input auto complete */
        $("#select_lang_input").autocomplete();
        $("#select_type_input").autocomplete();
        $("#select_org_status").autocomplete();
        create_uploader_input_org();

        let str_img_profile = document.getElementById('img_profile').value;
        let str_img_banner = document.getElementById('img_banner').value;
        if (str_img_profile != "") uploader1.show(str_img_profile);
        if (str_img_banner != "") uploader2.show(str_img_banner);

        get_org_address();
    }

    function get_user_address() {
        let url_user_info = url_setting;
        if (url_user_info.indexOf("?") === -1) url_user_info += "?";
        url_user_info += "&output=json";
        console.log(url_user_info);
        return get_data(url_user_info, null, load_address, "", false);


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

    function view_org(uid_org_user) {
        /**Show window org */
        obj_window_org.show();
        var url_info = "<?php echo $this->get_link(array("controller" => "org", "function" => "index", "get" => "action=view")) ?>";
        url_info += "&org=" + uid_org_user + "&output=html";
        return get_page(url_info, null, show_org_info, "div_org_form_input");
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

    function create_uploader_input_org() {
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
        if (page_mode != "list") return;
        let sroll_position = $(window).height() - $(window).scrollTop();
        if (sroll_position <= 120 && flag_get_data == true) return get_org_user();



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

        load_org_user();

        let anchor = window.location.hash;
        let str_anchor = "";
        if (anchor) str_anchor = anchor.substring(1);
        if (str_anchor != "") input_org(str_anchor);

        $(window).on('scroll', scroll_load_org);

    })
</script>