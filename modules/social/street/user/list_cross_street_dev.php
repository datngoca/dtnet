<?php
$uid_street_user = '';
if (isset($_GET['street'])) $uid_street_user = $_GET['street'];

$source = '';
if (isset($_GET['source'])) $source = $_GET['source'];

/* tạo đối tượng html */
$Html = $this->load('html');
$Form = $Html->load('Form');
echo $Html->heading('Area Cross');

/* Tạo đối tượng html table */
$Html->load('Table');


/* tạo đối tượng liên kết với bảng street_user */
$array_street_user_data = $this->request_api("street", "info_user", ["street" => $uid_street_user]);
$array_street_user = isset($array_street_user_data["data"]) ? $array_street_user_data["data"] : null;
if ($array_street_user == null) exit("No data");

/*get data cross*/
$array_cross = json_decode($array_street_user['str_cross'], true);
if ($array_cross == null) exit("No data");

$stt = 0;

$table_row = '';
foreach ($array_cross as $code => $name) {
    $stt++;

    $array_row = null;
    $array_row['col1'] = array($stt);
    $array_row['col2'] = array($name);

    $table_row .= $Html->Table->row($array_row);
}


$array_header = null;
$array_header['col1'] = array("No");
$array_header['col2'] = array("Area code");
$table_header = $Html->Table->row_header($array_header);

echo $Html->Table->get($table_header . $table_row);
