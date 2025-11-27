<?php


$title = 'Ошибка 500';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
////////////////////////////////////////
echo '<div class="apicms_subhead">На сервере возникла ошибка, и он не может выполнить запрос.</div>';
////////////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>