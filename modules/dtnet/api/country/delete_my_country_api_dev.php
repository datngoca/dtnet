<?php

$uid_country = $array_param["country"];
if ($uid_country == "") exit(json_encode(array("result" => "false", "msg" => "no_uid")));

$this->loadModel("CountryUser");

$array_country_user = $this->CountryUser->read($uid_country);
if ($array_country_user === null) exit(json_encode(array("result" => "false", "msg" => "invalid_data")));

$array_country_user["status"] = "3";

$this->CountryUser->save($array_country_user);

echo json_encode(array("result" => "ok", "msg" => "delete_ok"));
