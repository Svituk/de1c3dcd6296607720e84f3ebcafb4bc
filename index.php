<?php

///////////////////////////////////
$title = 'Главная';
require_once 'api_core/apicms_system.php';
require_once 'design/styles/'.htmlspecialchars($api_design).'/head.php';

///////////////////////////////////
if ($api_settings['news_main']==1){
include_once 'modules/news.php';
}
///////////////////////////////////
include_once 'api_core/menu.php';
///////////////////////////////////
require_once 'design/styles/'.htmlspecialchars($api_design).'/footer.php';
///////////////////////////////////
?>