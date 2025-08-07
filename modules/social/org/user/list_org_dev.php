<?php
$Html = $this->load("Html");
$Table = $Html->load("Table");
$Form = $Html->load("Form");

/**Lấy giá trị tham số search */
$search = "";
$area_str_code = "";
$lang = "";
$street = "";
$place = "";

if (isset($_GET["search"])) $search = $_GET["search"];
if (isset($_GET['area'])) $area_str_code = $_GET['area'];
if (isset($_GET['lang'])) $lang = $_GET['lang'];
if (isset($_GET['street'])) $street = $_GET['street'];
if (isset($_GET['place'])) $place = $_GET['place'];

/*request api get org user */
$array_org_data = $this->request_api('org', 'list_user', array('search' => $search, 'area' => $area_str_code, 'lang' => $lang, 'street' => $street, 'place' => $place));
$array_org = isset($array_org_data["data"]) ? $array_org_data["data"] : "";

/*Duyệt từng dòng dữ liệu trong mảng array_project */
$str_row = "";
$stt = 0;

if ($array_org != null) {
    foreach ($array_org as $key => $row) {
        $stt++;
        $id_org = $row["id"];
        $uid_org = $row["uid"];
        $lang = $row["lang"];

<<<<<<< HEAD
        $str_name = $Html->span($row['name'], "id ='org_name_$uid_org_user'");
=======
        $str_name = $Html->span($row['name'], "id ='org_name_$uid_org'");
>>>>>>> ecb0f9b (updated from huy's computer)
        $str_code = $Html->span($row['code'], "class = 'des2'");
        $des = $row["des"];

        $str_row_name = $str_name . "<br>" . $str_code;

        /*parent*/
        $area_str_name = $Html->span($row['area_str_name'], " id ='area_str_name_$uid_org'");
        $area_str_code = $Html->span($row['area_str_code'], " id ='area_str_code_$uid_org' class = 'des2'");
        $str_area = $area_str_name . "<br>" . $area_str_code;

        /*street*/
        $street_name = isset($row['street_name']) ? $row['street_name'] : '';
        $street_number = isset($row['street_number']) ? $row['street_number'] : '';
        $str_street = '';
        if (!empty($street_name) || !empty($street_number)) {
            $str_street = trim($street_number . ' ' . $street_name);
        }

        /*place*/
        $place_name = isset($row['place_name']) ? $row['place_name'] : '';
        $str_place = $place_name;

        $user_name = $row["username"];

        /**Get $str_status */
        $approved = $row["approved"];
        $str_status = "Unapproved";
        if ($approved == "1") $str_status = "Approved";

        /*Tạo button_view*/
        $button_v = $Form->button(array("type" => "button", "onclick" => "show_org_info('$uid_org')"), "View");

        /** Gọi hàm row() của đối tươngj Table để lấy chuỗi <tr>  <td></td> </tr> để nối dữ liệu vào biến $str_row  */
        $array_row = null;
        $array_row["col1"] = array($stt);
        $array_row["col2"] = array($lang);
        $array_row["col3"] = array($str_row_name);
        $array_row["col4"] = array($str_area);
        $array_row["col5"] = array($str_street);
        $array_row["col6"] = array($str_place);
        $array_row["col7"] = array($des);
        $array_row["col8"] = array($str_status);
        $array_row["col9"] = array($user_name);
        $array_row["col10"] = array($button_v);
        $str_row .= $Table->row($array_row);
    }
} else {
    $array_row = null;
    $array_row["col1"] = array("No data", array("colspan" => "10"));
    $str_row = $Table->row($array_row);
}

/**Gọi hàm row_header() của đối tượng Table để tạo chuỗi table_header gán vào biến str_header  */
$array_header = null;
$array_header["col1"] = array("Stt");
$array_header["col2"] = array("Lang");
$array_header["col3"] = array("Name");
$array_header["col4"] = array("Area");
$array_header["col5"] = array("Street");
$array_header["col6"] = array("Place");
$array_header["col7"] = array("Description");
$array_header["col8"] = array("Status");
$array_header["col9"] = array("User");
$array_header["col10"] = array("Options");
$str_header = $Table->row_header($array_header);

/**Gọi hàm get() của đối tượng Table để lấy cặp thẻ <table> </table> */
//$table_project = "<table> $str_header $str_row</table>";
$table_country = $Table->get($str_header . $str_row);
echo $table_country;
