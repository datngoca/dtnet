<?php

/*validate*/
if (!isset($_GET['street']) || ($_GET['street'] == ""))  exit(json_encode(array("result" => "false", "msg" => "no_street")));
if (!isset($_GET['num']))  exit(json_encode(array("result" => "false", "msg" => "no_num")));

$uid_street_user = $_GET['street'];
$num = $_GET['num'];
$array_result = $this->request_api("street", "delete_cross", ["street" => $uid_street_user, "num" => $num]);
exit($array_result);
