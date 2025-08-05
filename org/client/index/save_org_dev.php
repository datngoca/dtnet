<?php
/*check post data */
$array_data_column = array(
    'type',
    'name',
    'business_activity',
    'org',
    'status',
    'google_map',
    'phone',
    'img_profile',
    'img_banner',
    'code',
    'des',
    'address',
    'email',
    'website',
    'lang'
);

$array_data = null;
foreach ($array_data_column as $value) {
    $array_data[$value] = '';
    if (isset($_POST[$value])) $array_data[$value] = $_POST[$value];
}

if ($array_data['code'] == '') exit(json_encode(array('result' => 'false', 'msg' => 'no_code')));
if ($array_data['name'] == '') exit(json_encode(array('result' => 'false', 'msg' => 'no_name')));
if ($array_data['type'] == '') exit(json_encode(array('result' => 'false', 'msg' => 'no_type')));
if ($array_data['address'] == '') exit(json_encode(array('result' => 'false', 'msg' => 'no_address')));

/**Lấy thông tin người dùng đang đăng nhập */
$array_data["id_user"] = $this->CurrentUser->id;
$array_data["uid_user"] = $this->CurrentUser->uid;
$array_data["user_fullname"] = $this->CurrentUser->fullname;
$array_data["username"] = $this->CurrentUser->username;

$this->load('ApiClient');
echo $this->ApiClient->request("org", "save_user", $array_data, false);
