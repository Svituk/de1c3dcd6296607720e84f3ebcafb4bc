<?

/////////////////////////////////////////
$title = ' Восстановление пароля';
require_once 'api_core/apicms_system.php';
require_once 'design/styles/'.htmlspecialchars($api_design).'/head.php';
/////////////////////////////////////////
if ($user['id']) header('location: /');

/////////////////////////////////////////
if (isset($_POST['login']) && isset($_POST['email']) && $_POST['login']!=NULL && $_POST['email']!=NULL){
$myret = apicms_generate(12);
/////////////////////////////////////////
$pass = md5(md5(apicms_filter($myret)));
/////////////////////////////////////////
global $connect;
$qq = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '".apicms_filter($_POST['login'])."'"));
////////////////////////////////////////
if ($qq && isset($qq['login']) && isset($qq['email']) && $qq['login']==$_POST['login'] && $qq['email']==$_POST['email']){
////////////////////////////////////////
mysqli_query($connect, "UPDATE `users` SET `pass` = '$pass' WHERE `login` = '".mysqli_real_escape_string($connect, $qq['login'])."' LIMIT 1");
////////////////////////////////////////
//Отправка на E-Mail
$email_a = 'password@'.$set['site'];
$message = 'Здравствуйте, вы запросили восстановление пароля. Ваш временный пароль '.$myret.' пожалуйста смените его при первом входе на сайт.';
mail($qq['email'], '=?utf-8?B?'.base64_encode('Восстановление '.$set['site']).'?=', $message, "From: $email_a\r\napicms_content-type: text/plain; charset=utf-8;\r\nX-Mailer: PHP;");
echo '<div class="apicms_subhead"><center>Пароль отправлен на e-mail пользователя '.$qq['login'].'</center></div>';
}
////////////////////////////////////////
echo "<form action='?okpass' method='post'><div class='apicms_content'>";
echo "Логин:<br /> <input type='text' name='login' title='Логин' value='' maxlength='32' size='16' /><br />";
echo "E-mail:<br /> <input type='text' name='email' title='E-mail' value='' maxlength='32' size='16' /><br />";
echo "<input type='submit' value='Восстановление' title='Далее' /></div></form>";
////////////////////////////////////////
require_once 'design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>