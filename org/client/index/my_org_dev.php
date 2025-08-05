<?php
$search = "";
$output = "";

$page = "";
$token_list = "";
$limit = "";

if (isset($_GET["search"])) $search = $_GET["search"];
if (isset($_GET["output"])) $output = $_GET["output"];

/*page, token_list, limit*/
if (isset($_GET['page'])) $page = $_GET['page'];
if (isset($_GET['token_list'])) $token_list = $_GET['token_list'];
if (isset($_GET['limit'])) $limit = $_GET['limit'];

$array_param = null;
$array_param["search"] = $search;
$array_param["page"] = $page;
$array_param["token_list"] = $token_list;
$array_param["limit"] = $limit;

/*request api get org user */
exit($this->request_api('org', 'list_my', $array_param, false));
