<?php 

$title = 'Регистрация пользователя';
require_once 'api_core/apicms_system.php';
require_once 'design/styles/'.htmlspecialchars($api_design).'/head.php';
////////////////////////////////////////
if ($user['id']) header('location: index.php');
////////////////////////////////////////
if ($api_settings['reg']==1){

$login = apicms_filter($_POST['login']);
$pass = apicms_filter($_POST['pass']);
$email = apicms_filter($_POST['email']);
$code = apicms_filter($_POST['code']);
$pol = apicms_filter($_POST['sex']);
$kod_activate = apicms_generate(19);

if (isset($_POST['save'])){

global $connect;
$querylogin = mysqli_query($connect, "SELECT COUNT(`id`) as cnt FROM `users` WHERE `login` = '$login'");
$row_login = mysqli_fetch_assoc($querylogin);
if ($row_login['cnt']>0)$err = '<div class="erors">Извините, данный логин уже зарегистрирован, выберите другой</div>';

if (empty($_POST['login'])) $err = '<div class="erors">Логин не введен!</div>';

if (!preg_match('/^([A-zА-я0-9\-]*)+$/', $login))$err = '<div class="erors">Логин должен содержать только буквы Латинского алфавита и цифры</div>';

if (strlen($login)<=2 || strlen($login)>=13)$err = '<div class="erors">Логин должен содержать от 3 до 12 символов</div>';

if (empty($_POST['pass']))$err = '<div class="erors">Ошибка! Пароль не введен</div>';

if (strlen($pass)<=7 or strlen($pass)>=17)$err = '<div class="erors">Пароль должен содержать от 8 до 16 символов</div>';

if (empty($_POST['email']))$err = '<div class="erors">Ошибка! Вы не ввели E-Mail (почту)</div>';

if (!preg_match('/[0-9a-z_\-]+@[0-9a-z_\-^\.]+\.[a-z]{2,6}/i', $email))$err = '<div class="erors">Ошибка! E-Mail (почта) введён не верно</div>';

$query = mysqli_query($connect, "SELECT COUNT(`email`) as cnt FROM `users` WHERE `email` = '$email'");
$row_email = mysqli_fetch_assoc($query);
if ($row_email['cnt']>0)$err = '<div class="erors">Извините, данный email уже зарегистрирован в системе</div>';

if (empty($_POST['code']))$err = '<div class="erors">Вы не ввели проверочный код</div>';

if ($_POST['code'] != $_SESSION['captcha'])$err = '<div class="erors">Вы неверно ввели проверочный код</div>';

if ($pol<0 || $pol>2)$err = '<div class="erors">Вы не выбрали вашу стать</div>';

if (!isset($err)){
////////////////////////////////////////			
mysqli_query($connect, "INSERT INTO `users` SET `login` = '$login', `activ_mail` = '".$kod_activate."', `pass` = '".md5(md5($pass))."', `email` = '$email', `sex` = '$pol', `regtime` = '".time()."', `last_aut` = '".time()."'");
////////////////////////////////////////		
//Отправка на E-Mail
$email_a = 'admin@'.$set['site'];
$message = 'Уважаемый пользователь! Вы успешно зарегистрировались на сайте '.$set['site'].'  
Ваши данные для входа на сайт:
Ваш Логин: '.$login.'
Ваш Пароль: '.$pass.'
Автологин для входа: http://'.$set['site'].'/login.php?log='.$login.'&pas='.$pass.'
Подтвердите ваш email перейдя по ссылке http://'.$set['site'].'/mail_activate.php?log='.$login.'&code='.$kod_activate.'
Пожалуйста сохраните данные в надежном месте!
С уважением, команда '.$set['site'];
mail($email, '=?utf-8?B?'.base64_encode('Регистрация на '.$set['site']).'?=', $message, "From: $email_a\r\napicms_content-type: text/plain; charset=utf-8;\r\nX-Mailer: PHP;");
unset($_SESSION['captcha']);
echo '<div class="apicms_content"><center>Регистрация прошла успешно! </br> 
На ваш e-mail '.htmlspecialchars($email).' отправлено письмо с активацией аккаунта </br>
Если письма нету в папке входящие, советуем проверить папку спам или подождать некоторое время</center></div>';
}else{
apicms_error($err);
}
}


echo '<form action="?" method="post">
<div class="apicms_subhead"><small>Никнейм - до 12 симв.</small><br /><img src="/design/styles/'.htmlspecialchars($api_design).'/style_images/arrhover.png" alt=""><input name="login" placeholder="Логин" type="text" maxlength="12" /><br /></div>
<div class="apicms_subhead"><small>Пароль - до 16 симв.</small><br /><img src="/design/styles/'.htmlspecialchars($api_design).'/style_images/arrhover.png" alt=""><input name="pass" placeholder="Пароль" value="'.apicms_generate(14).'" type="text" maxlength="16" /><br />
<small>*Для смены автопароля обновите страницу</small></div>	
<div class="apicms_subhead"><small>E-Mail - до 25 симв.</small><br /><img src="/design/styles/'.htmlspecialchars($api_design).'/style_images/arrhover.png" alt=""><input name="email" placeholder="e-mail" type="text" maxlength="25" /><br /></div>
<div class="apicms_subhead"><small>Выберите вашу стать:</small><br /><img src="/design/styles/'.htmlspecialchars($api_design).'/style_images/arrhover.png" alt="">
<select name="sex"><option value="">Выбрать свою стать</option>
<option value="1">Мужчина</option>
<option value="0">Женщина</option></select><br /></div>
<div class="apicms_subhead"><img src="captcha.php?'.rand(100, 999).'" width="50" height="27"  alt="captcha" style="-moz-border-radius: 7px; -webkit-border-radius: 7px;" />
<input name="code" placeholder="число..." type="text" maxlength="3" size="13" /><br/></div>
<div class="apicms_subhead"><input type="submit" name="save" value="Завершить регистрацию"/></div></form>';
}else{
echo '<div class="erors">Извините, регистрация временно приостановлена</div>';
}
require_once 'design/styles/'.htmlspecialchars($api_design).'/footer.php';
////////////////////////////////////////
?>