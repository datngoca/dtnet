<?php
$array_data = $array_param;
$uid_org = isset($array_data["org"]) ? $array_data["org"] : "";

if ($uid_org == "") exit(json_encode(array("result" => "false", "msg" => "missing_org_id")));

/* Load models */
$this->loadModel('OrgUser');

$array_org_user = $this->OrgUser->read($uid_org);
echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_org_user));
