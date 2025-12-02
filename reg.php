<?php 

$title = 'Регистрация пользователя';
require_once 'api_core/apicms_system.php';
require_once 'design/styles/'.htmlspecialchars($api_design).'/head.php';
////////////////////////////////////////
if (isset($user['id']) && $user['id']) header('location: index.php');
////////////////////////////////////////
if ($api_settings['reg']==1){

$login = isset($_POST['login']) ? apicms_filter($_POST['login']) : '';
$pass = isset($_POST['pass']) ? apicms_filter($_POST['pass']) : '';
$email = isset($_POST['email']) ? apicms_filter($_POST['email']) : '';
$code = isset($_POST['code']) ? apicms_filter($_POST['code']) : '';
$pol = isset($_POST['sex']) ? apicms_filter($_POST['sex']) : '';
$kod_activate = '';

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

if ($code === '')$err = '<div class="erors">Вы не ввели проверочный код</div>';

if ($code !== '' && isset($_SESSION['captcha']) && $code != $_SESSION['captcha'])$err = '<div class="erors">Вы неверно ввели проверочный код</div>';

if (intval($pol)<0 || intval($pol)>2 || $pol==='')$err = '<div class="erors">Вы не выбрали вашу стать</div>';

if (!isset($err)){
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($connect, "INSERT INTO `users` (`login`,`activ_mail`,`pass`,`email`,`sex`,`regtime`,`last_aut`) VALUES (?,?,?,?,?,?,?)");
    $one = 1; $regt = time(); $last = $regt; $sexi = intval($pol);
    mysqli_stmt_bind_param($stmt, 'sissiii', $login, $one, $hash, $email, $sexi, $regt, $last);
    mysqli_stmt_execute($stmt);
    unset($_SESSION['captcha']);
    echo '<div class="apicms_content"><center>Регистрация прошла успешно! Аккаунт активирован.</center></div>';
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
