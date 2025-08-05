<?php
$array_data = $_POST['data2'];

$array_result = $this->request_api("street", "save_cross", $array_data);

exit($array_result);
