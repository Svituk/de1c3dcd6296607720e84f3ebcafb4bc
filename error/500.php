<?php


$title = 'Ошибка 500';
require_once '../api_core/apicms_system.php';
http_response_code(500);
header('X-Robots-Tag: noindex, nofollow');
header('Content-Type: text/html; charset=UTF-8');
require_once '../design/styles/'.display_html($api_design).'/head.php';
////////////////////////////////////////
echo '<div class="apicms_subhead">На сервере возникла ошибка, и он не может выполнить запрос.</div>';
////////////////////////////////////////
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
