<?php
// Lưu tổ chức
$array_data = $_POST['data'];

$result = $this->request_api('org', 'save_my', $array_data, false);
exit($result);
