<?php


$title = 'Ошибка 406';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
////////////////////////////////////////
echo '<div class="apicms_subhead">Запрашиваемая страница не может быть возвращена с указанными в запросе характеристиками содержания.</div>';
////////////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>