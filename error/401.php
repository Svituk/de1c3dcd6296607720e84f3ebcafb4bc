<?php


$title = 'Ошибка 401';
require_once '../api_core/apicms_system.php';
http_response_code(401);
header('X-Robots-Tag: noindex, nofollow');
header('Content-Type: text/html; charset=UTF-8');
require_once '../design/styles/'.display_html($api_design).'/head.php';
////////////////////////////////////////
echo '<div class="apicms_subhead">Запрос требует проверки подлинности. Сервер может вернуть этот ответ, если страница защищена паролем.</div>';
////////////////////////////////////////
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
