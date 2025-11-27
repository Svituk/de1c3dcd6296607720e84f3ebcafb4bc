<?php

if (!empty($user) && !empty($user['id'])) {

global $connect;
$new_mail_result = mysqli_query($connect, "SELECT COUNT(`id`) as cnt FROM `user_mail` WHERE `id_recipient` = '".intval($user['id'])."' AND `views` = '0'");
$new_mail_row = mysqli_fetch_assoc($new_mail_result);
$new_mail = $new_mail_row['cnt'];
if ($new_mail==0)$new_mail=NULL;
else $new_mail = ' <small> +'.$new_mail.' </small> ';

$sys_new_mail_result = mysqli_query($connect, "SELECT COUNT(`id`) as cnt FROM `api_system` WHERE `id_user` = '".intval($user['id'])."' AND `read` = '0'");
$sys_new_mail_row = mysqli_fetch_assoc($sys_new_mail_result);
$sys_new_mail = $sys_new_mail_row['cnt'];
if ($sys_new_mail==0)$sys_new_mail=NULL;
else $sys_new_mail = ' <small> +'.$sys_new_mail.' </small> ';

echo '<div class="headmenu"><table width="100%" border="0" cellpadding="0" cellspacing="0">';
echo '<td><a href="/profile.php?id='.$user['id'].'" >';
echo apicms_ava40($user['id']);
echo '</a> <a class="headmenulink" href="/modules/user_menu.php"><img src="/design/styles/'.htmlspecialchars($api_design).'/user_menu/ui_menu.png" alt=""></a></a> <a class="headmenulink" href="/modules/new_mail.php?id='.$user['id'].'"><img src="/design/styles/'.htmlspecialchars($api_design).'/user_menu/mail_open.png" alt=""> '.$new_mail.'</a> <a class="headmenulink" href="/modules/sys_mail.php"><img src="/design/styles/'.htmlspecialchars($api_design).'/user_menu/sys_mail.png" alt=""> '.$sys_new_mail.'</a> </td>';
echo '<td align="right"><a href="/log_out.php" class="headbut">Выйти</a></td>';
echo '</tr></table></div>';
}else{
echo '<div class="headmenu"><table width="100%" border="0" cellpadding="0" cellspacing="0">';
echo '<td> <a href="/" ><img src="/design/styles/'.htmlspecialchars($api_design).'/panel_logo.png" alt=""></a> </td>';
echo '<td align="right"><a href="/auth.php" class="headbut">Войти</a><a href="/reg.php" class="headbut">Создать профиль</a></td>';
echo '</tr></table></div>';
///////  можно убрать строку ниже будет лучше индексировать поисковиками
echo '<div class="apicms_content"><div class="descr">Процесс регистрации не займет у вас много времени, зато позволит по достойнству оценить возможности нашей CMS.</div></div>';
///////
}
////////////////////////////////////////
?>