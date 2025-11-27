<?php
////////////////////////////////////////
$title = 'Документация по APICMS';
require_once '../api_core/apicms_system.php';
if (!function_exists('apicms_ob_started')){ ob_start(); function apicms_ob_started(){} }
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
////////////////////////////////////////
echo file_get_contents('http://apicms.ru/info/api_info_3_0.php');
///////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>