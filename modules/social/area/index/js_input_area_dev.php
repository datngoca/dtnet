<script>
    var request = '';
    var str_code_parent_selected = '';

    function change_area_parent_input(str_code) {
        /*update parent_str_code*/
        $("#parent_str_code").val(str_code);

        /*get new parent area input*/
        get_area_parent_input(str_code);
    }

    function change_lang_input() {
        get_area_parent_input(str_code_parent_selected);
    }


    function show_area_parent_input(result) {
        /* đưa selectbox vào div_area_parent_input */
        $("#span_list_select_area_input").css("display", "block");
        $("#span_list_select_area_input").html(result);

        /*autocomplete các input*/
        $(".select_area_input").autocomplete();
    }

    function get_area_parent_input(str_area_code) {
        /*lưu lại str_code_parent_selected */
        str_code_parent_selected = str_area_code;
        let lang = document.getElementById("select_lang_input").value;

        /*lấy select parent_area_code*/
        var url_area_input = "<?php echo $this->get_link(array("controller" => "area", "function" => "index", "get" => "action=get_parent&data_type=input")) ?>";
        url_area_input += "&area=" + str_area_code + "&parent=&lang=" + lang;
        return get_page(url_area_input, null, show_area_parent_input, "span_list_select_area_input");

    }

    function get_area_info(obj_result) {
        console.log(obj_result);
        $("#div_msg").css("display", "block");

        document.getElementById("button_save").disabled = false;

        if (!obj_result) return $("#div_msg").html("Error");


        if (!obj_result.hasOwnProperty('result')) obj_result.result = "";
        if (!obj_result.hasOwnProperty('msg')) obj_result.msg = "";
        if (!obj_result.hasOwnProperty('last_uid')) obj_result.last_uid = "";

        if (obj_result.result != "ok") return alert("Error: " + obj_result.msg);

        alert('Save successfully');

        show_area_info(obj_result.area);

    }

    function save_area() {
        /* khóa nút bấm, không lưu liên tục */
        document.getElementById("button_save").disabled = true;

        document.getElementById('lbl_name').innerHTML = "";

        /*kiểm tra input name có dữ liệu không? */
        if (document.getElementById('name').value == "") {
            document.getElementById('lbl_name').innerHTML = "Please input area name";
            document.getElementById('name').focus();
            return;
        }

        /*data*/
        const formData = new FormData(document.getElementById('form_area'));
        var url_area_input = "<?php echo $this->get_link(array("controller" => "area", "function" => "index", "get" => "action=save")) ?>";

        return submit_form(url_area_input, formData, get_area_info, "div_msg");


    }
    /*end : function save_area() */
</script>