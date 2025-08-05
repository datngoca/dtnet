<script>
    const Word = {
        "street_exist": "Đường phố đã tồn tại",
        "invalid_data": "Dữ liệu không hợp lệ",
        "no_uid": "Thiếu UID",
        "no_lang": "Thiếu ngôn ngữ",
        "no_area_code": "Thiếu mã khu vực",
        "no_name": "Thiếu tên đường phố",
        "no_code": "Thiếu mã đường phố",
        "update_ok": "Lưu thành công",
        "insert_ok": "Lưu thành công",
        "success": "Thành công",
    };

    var request = '';
    var str_code_parent_selected = '';

    function change_area_input(str_code) {
        /*update parent_str_code*/
        $("#area_str_code_input").val(str_code);

        /*get new parent area input*/
        get_area_input(str_code);
    }

    function change_lang_input() {
        get_area_input(str_code_parent_selected);
    }


    function show_area_parent_input(result) {
        /* đưa selectbox vào div_area_parent_input */
        $("#span_list_select_area_input").css("display", "block");
        $("#span_list_select_area_input").html(result);

        /*autocomplete các input*/
        $(".select_area_input").autocomplete();
    }

    function get_area_input(str_area_code) {
        /*lưu lại str_code_parent_selected */
        str_code_parent_selected = str_area_code;
        let lang = document.getElementById("select_lang_input").value;

        /*lấy select parent_area_code*/
        var url_area_input = "<?php echo $this->get_link(array("controller" => "street", "function" => "index", "get" => "action=get_area&source=input")) ?>";
        url_area_input += "&area=" + str_area_code + "&parent=&lang=" + lang;
        console.log(url_area_input);
        return get_page(url_area_input, null, show_area_parent_input, "span_list_select_area_input");

    }

    function show_save_street(obj) {
        document.getElementById("button_save").disabled = false;

        if (!obj) return alert("error");

        const result = obj?.result;
        const msg = obj?.msg;
        const data = obj?.data;

        const str_msg = Word[msg] || msg;

        if (result !== "ok") return alert("Error: " + str_msg);
        alert(str_msg);

        const uid_street = data?.street;
        if (uid_street) {
            show_street_info(uid_street);
        }
        list_street();
    }

    function save_street() {
        /* khóa nút bấm, không lưu liên tục */
        document.getElementById("button_save").disabled = true;

        document.getElementById('lbl_name').innerHTML = "";

        /*kiểm tra input name có dữ liệu không? */
        if (document.getElementById('name').value == "") {
            document.getElementById('lbl_name').innerHTML = "Xin vui lòng nhập tên đường phố";
            document.getElementById('name').focus();
            document.getElementById("button_save").disabled = false;
            return;
        }

        /*data*/
        const formData = $('#form_street').serialize();

        var url_save_street = "<?php echo $this->get_link(array("controller" => "street", "function" => "index")) ?>";

        return request_data(url_save_street, formData, show_save_street, "div_msg");
    }
    /*end : function save_street() */
</script>