<?php

if (!isset($action)) exit("no_action");

/*check input*/
if (isset($_REQUEST["debug"]) && $_REQUEST["debug"] == "api_request") echo "<br>***action: $action<br>";

// if ($action == "save") return $this->run("language/save_language");
// if ($action == "info") return $this->run("language/info_language", array("array_language" => $params));
// if ($action == "approve") return $this->run("language/approve_language", array("array_language" => $params));
// if ($action == "active") return $this->run("language/active_language", array("array_language" => $params));

if ($action == "list_my") return $this->run("language/list_my_language", array("array_param" => $params));
if ($action == "save_my") return $this->run("language/save_my_language", array("array_param" => $params));
if ($action == "info_my") return $this->run("language/info_my_language", array("array_param" => $params));
if ($action == "delete_my") return $this->run("language/delete_my_language", array("array_param" => $params));

if ($action == "list_user") return $this->run("language/list_user_language", array("array_param" => $params));
if ($action == "info_user") return $this->run("language/info_user_language", array("array_param" => $params));
if ($action == "approve_user") return $this->run("language/approve_user_language", array("array_param" => $params));

if ($action == "list") return $this->run("language/list_language", array("array_param" => $params));
if ($action == "info") return $this->run("language/info_language", array("array_param" => $params));
if ($action == "all") return $this->run("language/all_language", array("array_param" => $params));
if ($action == "activate") return $this->run("language/activate_language", array("array_param" => $params));

return exit("invalid_action_language");
