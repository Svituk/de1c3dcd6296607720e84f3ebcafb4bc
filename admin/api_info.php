<?php
////////////////////////////////////////
$title = 'Документация по APICMS';
require_once '../api_core/apicms_system.php';
if (!function_exists('apicms_ob_started')){ ob_start(); function apicms_ob_started(){} }
require_once '../design/styles/'.display_html($api_design).'/head.php';
////////////////////////////////////////
$url = 'https://apicms.ru/info/api_info_3_0.php';
$ctx = stream_context_create(['http'=>['timeout'=>5]]);
$html = @file_get_contents($url, false, $ctx);
echo $html ? $html : '<div class="apicms_content"><center>Не удалось загрузить документацию</center></div>';
///////////////////////////////////
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
