<?php
// Xóa tổ chức
$uid_org = isset($_POST['org']) ? $_POST['org'] : '';
$result = $this->request_api('org', 'delete', ['org' => $uid_org], false);
exit(json_encode($result));
