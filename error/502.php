<?php


$title = 'Ошибка 502';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
////////////////////////////////////////
echo '<div class="apicms_subhead">Сервер, действуя в качестве шлюза или прокси-сервера, получил недопустимый ответ от вышестоящего сервера.</div>';
////////////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>