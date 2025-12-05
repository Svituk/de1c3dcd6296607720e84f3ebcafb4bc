<?php


$title = 'Ошибка 400';
require_once '../api_core/apicms_system.php';
http_response_code(400);
header('X-Robots-Tag: noindex, nofollow');
header('Content-Type: text/html; charset=UTF-8');
require_once '../design/styles/'.display_html($api_design).'/head.php';
////////////////////////////////////////
echo '<div class="apicms_subhead">Серверу не удалось разобрать синтаксис запроса.</div>';
////////////////////////////////////////
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
