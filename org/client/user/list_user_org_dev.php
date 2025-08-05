<?php
$Html = $this->load("Html");
$Table = $Html->load("Table");
$Form = $Html->load("Form");

/**Lấy giá trị tham số search */
$search = "";
if (isset($_GET["search"])) $search = $_GET["search"];

$search = "";
if (isset($_GET["search"])) $search = $_GET["search"];

/*request api get org user */
$array_org = $this->request_api('org', 'list_user', array('search' => $search));

/*Duyệt từng dòng dữ liệu trong mảng array_project */
$str_row = "";
$stt = 0;

if ($array_org != null) {
    foreach ($array_org as $key => $row) {
        $stt++;
        $id_org = $row["id"];
        $uid_org = $row["uid"];
        $lang = $row["lang"];

        $name = $row["name"];
        $code = $row["code"];
        $des = $row["des"];

        $area_str_name = $row["area_str_name"];
        $sub_area_name = $row["sub_area_name"];

        $user_name = $row["username"];

        /**Get $str_status */
        $approved = $row["approved"];
        $str_status = "Unapproved";
        if ($approved == "1") $str_status = "Approved";

        /*Tạo button_view*/
        $button_v = $Form->button(array("type" => "button", "onclick" => "view_org_user('$uid_org')"), "View");

        /** Gọi hàm row() của đối tươngj Table để lấy chuỗi <tr>  <td></td> </tr> để nối dữ liệu vào biến $str_row  */
        $array_row = null;
        $array_row["col1"] = array($stt);
        $array_row["col2"] = array($lang);
        $array_row["col3"] = array($name . "<span>$code</span>");
        $array_row["col4"] = array($area_str_name . "<span class= 'area_des'>$sub_area_name</span>");
        $array_row["col5"] = array($des);
        $array_row["col6"] = array($str_status);
        $array_row["col7"] = array($user_name);
        $array_row["col8"] = array($button_v);
        $str_row .= $Table->row($array_row);
    }
} else {
    $array_row = null;
    $array_row["col1"] = array("No data", array("colspan" => "5"));
    $str_row = $Table->row($array_row);
}

/**Gọi hàm row_header() của đối tượng Table để tạo chuỗi table_header gán vào biến str_header  */
$array_header = null;
$array_header["col1"] = array("Stt");
$array_header["col2"] = array("Lang");
$array_header["col3"] = array("Name");
$array_header["col4"] = array("Area");
$array_header["col5"] = array("Description");
$array_header["col6"] = array("Status");
$array_header["col7"] = array("User");
$array_header["col8"] = array("Options");
$str_header = $Table->row_header($array_header);

/**Gọi hàm get() của đối tượng Table để lấy cặp thẻ <table> </table> */
//$table_project = "<table> $str_header $str_row</table>";
$table_country = $Table->get($str_header . $str_row);
echo $table_country;
?>
<style>
    .area_des {
        color: #f59f01;
        margin: 0px 5px
    }
</style>