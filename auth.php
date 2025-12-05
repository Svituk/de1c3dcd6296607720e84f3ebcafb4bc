<?php

$title = 'Вход в персональный аккаунт';
require_once 'api_core/apicms_system.php';
require_once 'design/styles/'.display_html($api_design).'/head.php';
////////////////////////////////////////

if (isset($_GET['error'])){
echo '<div class="erors">Ошибка авторизации, проверьте правильность данных!</div>';
}

echo '<div class="apicms_content"><form action="login.php" method="post"><center>
<img src="/design/styles/'.display_html($api_design).'/images/user-worker.png" alt=""> <input type="text" name="login" placeholder="Логин..." maxlength="12" size="13" style="width:90%;"/><br />
<img src="/design/styles/'.display_html($api_design).'/images/key.png" alt=""> <input type="password" name="pass" placeholder="Пароль..." maxlength="15" size="13" style="width:90%;"/><br />
<input type="hidden" name="csrf_token" value="'.display_html(csrf_token()).'" />
<input type="submit" value="Выполнить вход" style="width:99%;"/></center></form></div>';
////////////////////////////////////////
echo '<a href="lost_pass.php" class="apicms_subhead"> <img src="/design/styles/'.display_html($api_design).'/images/recovery.png" alt=""> Восстановление пароля от аккаунта</a>';
////////////////////////////////////////
require_once 'design/styles/'.display_html($api_design).'/footer.php';
?>
