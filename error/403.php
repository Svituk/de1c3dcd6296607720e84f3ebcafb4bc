<?php


$title = 'Ошибка 403';
require_once '../api_core/apicms_system.php';
http_response_code(403);
header('X-Robots-Tag: noindex, nofollow');
header('Content-Type: text/html; charset=UTF-8');
require_once '../design/styles/'.display_html($api_design).'/head.php';
////////////////////////////////////////
echo '<div class="apicms_subhead">Сервер отказывает запросу. 
Если вы видите, что Googlebot получил этот код статуса при попытке сканирования страниц вашего сайта (эта информация находится на странице Ошибки сканирования), вполне возможно, что ваш сервер или хост блокируют доступ робота Google.</div>';
////////////////////////////////////////
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
