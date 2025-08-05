<?php

if (!isset($action)) $action = "";

/*check action*/
if ($action == "list_my") return $this->run("country/list_my_country", array("array_param" => $params));
if ($action == "save_my") return $this->run("country/save_my_country", array("array_param" => $params));
if ($action == "info_my") return $this->run("country/info_my_country", array("array_param" => $params));
if ($action == "delete_my") return $this->run("country/delete_my_country", array("array_param" => $params));

if ($action == "list_user") return $this->run("country/list_user_country", array("array_param" => $params));
if ($action == "info_user") return $this->run("country/info_user_country", array("array_param" => $params));
if ($action == "approve_user") return $this->run("country/approve_user_country", array("array_param" => $params));

if ($action == "info") return $this->run("country/info_country", array("array_param" => $params));
if ($action == "activate") return $this->run("country/activate_country", array("array_param" => $params));
if ($action == "list") return $this->run("country/list_country", array("array_param" => $params));
if ($action == "all") return $this->run("country/all_country", array("array_param" => $params));
// if ($action == "save") return $this->run("country/save_country");
// if ($action == "approve") return $this->run("country/approve_country", array("array_country" => $params));

// if ($action != "list"  && $action != "all")   exit("invalid_action");

// /*search param*/
// $search = "";
// $lang = "";
// if (isset($params["search"])) $search = $params["search"];
// if (isset($params["lang"])) $lang = $params["lang"];

// $this->loadModel("Country", "countries");
// if ($search != "") $this->Country->search(array("name", "code", "des"), $search);

// $this->Country->order = "status DESC, approved DESC, order_number ASC";

// if ($action == "list") {

//     $this->Country->fields = "code, name, des_short,  uid, des, id,  approved, status, order_number";

//     if ($lang == "") exit("no_lang");
//     $this->Country->cond("status", "1");
//     $this->Country->cond("approved", "1");
//     $this->Country->cond("lang", $lang);
//     exit(json_encode($this->Country->get()));
// }


// /*acton == all*/
// if ($lang != "") $this->Country->cond("lang", $lang);
// exit(json_encode($this->Country->get()));
