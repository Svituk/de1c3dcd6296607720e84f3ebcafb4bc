<?php

///////////////////////////////////
$title = 'Меню пользователя';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.display_html($api_design).'/head.php';
///////////////////////////////////
if (!$user['id']) header('location: /');
///////////////////////////////////
require_once '../api_core/user_panel.php';
///////////////////////////////////
if ($user['level']==1)echo '<strong><a class="apicms_subhead" href="/admin/" > <img src="/design/styles/'.display_html($api_design).'/user_menu/adm.png" alt=""> Панель администратора</strong></a>';
///////////////////////////////////
echo '<strong><a class="apicms_subhead" href="cont_list.php" > <img src="/design/styles/'.display_html($api_design).'/user_menu/fre.png" alt=""> Мой список контактов</strong></a>';
///////////////////////////////////
echo '<strong><a class="apicms_subhead" href="edit_ank.php" > <img src="/design/styles/'.display_html($api_design).'/user_menu/set.png" alt=""> Редактировать аккаунт</strong></a>';
///////////////////////////////////
echo '<strong><a class="apicms_subhead" href="/ava.php" > <img src="/design/styles/'.display_html($api_design).'/user_menu/ava.png" alt=""> Загрузка нового аватара</strong></a>';
///////////////////////////////////
echo '<strong><a class="apicms_subhead" href="edit_pass.php" > <img src="/design/styles/'.display_html($api_design).'/user_menu/pas.png" alt=""> Изменить пароль</strong></a>';
///////////////////////////////////
echo '<strong><a class="apicms_subhead" href="smile_list.php" > <img src="/design/styles/'.display_html($api_design).'/user_menu/sml.png" alt=""> Список смайлов сайта</strong></a>';
///////////////////////////////////
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
