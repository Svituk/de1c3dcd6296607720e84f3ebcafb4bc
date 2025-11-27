<?php

//////////////////////////////////////////
$title = 'Админка';
require_once '../api_core/apicms_system.php';
if (!function_exists('apicms_ob_started')){ ob_start(); function apicms_ob_started(){} }
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
//////////////////////////////////////////
if ($user['level'] != 1) header('location: ../');
if ($user['level'] == 1){
//////////////////////////////////////////
echo '<a class="apicms_subhead" href="mysql.php"><img src="/design/styles/'.htmlspecialchars($api_design).'/admin/sql.png" alt=""> Сделать SQL запрос в базу</a>';
echo '<a class="apicms_subhead" href="rassilka.php"><img src="/design/styles/'.htmlspecialchars($api_design).'/admin/mail.png" alt=""> Почтовая рассылка</a>';
echo '<a class="apicms_subhead" href="add_news.php"><img src="/design/styles/'.htmlspecialchars($api_design).'/admin/news.png" alt=""> Управление новостями</a>';
echo '<a class="apicms_subhead" href="block_profiles.php"><img src="/design/styles/'.htmlspecialchars($api_design).'/admin/ban.png" alt=""> Список заблокированных</a>';
echo '<a class="apicms_subhead" href="ads.php"><img src="/design/styles/'.htmlspecialchars($api_design).'/admin/ads.png" alt=""> Управление рекламой</a>';
echo '<a class="apicms_subhead" href="sys_set.php"><img src="/design/styles/'.htmlspecialchars($api_design).'/admin/set.png" alt=""> Настройки сайта</a>';
echo '<div class="apicms_menu">Дополнительно</div>';
echo '<a class="apicms_subhead" href="/modules/system_test.php"><img src="/design/styles/'.htmlspecialchars($api_design).'/admin/sov.png" alt=""> Проверка совместности</a>';
echo '<a class="apicms_subhead" href="edit_rules.php"><img src="/design/styles/'.htmlspecialchars($api_design).'/admin/rul.png" alt=""> Редактирование правил</a>';
echo '<a class="apicms_subhead" href="edit_counters.php"><img src="/design/styles/'.htmlspecialchars($api_design).'/admin/num.png" alt=""> Редактирование счетчиков</a>';
echo '<a class="apicms_subhead" href="http://apicms.ru/"><img src="/design/styles/'.htmlspecialchars($api_design).'/admin/nmd.png" alt=""> Модули для ApiCMS</a>';
echo '<a class="apicms_subhead" href="api_info.php"><img src="/design/styles/'.htmlspecialchars($api_design).'/admin/not.png" alt=""> Документация по APICMS</a>';
//////////////////////////////////////////
}
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>