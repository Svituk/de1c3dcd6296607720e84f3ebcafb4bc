<?php


$title = 'Ошибка 406';
require_once '../api_core/apicms_system.php';
http_response_code(406);
header('X-Robots-Tag: noindex, nofollow');
header('Content-Type: text/html; charset=UTF-8');
require_once '../design/styles/'.display_html($api_design).'/head.php';
////////////////////////////////////////
echo '<div class="apicms_subhead">Запрашиваемая страница не может быть возвращена с указанными в запросе характеристиками содержания.</div>';
////////////////////////////////////////
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
