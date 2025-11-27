<?

/////////////////////////////////////////
$title = 'Изменение пароля';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
/////////////////////////////////////////
if (!$user['id']) header('location: /');

global $connect;
$pass = md5(md5(apicms_filter($_POST['pass1'])));
/////////////////////////////////////////
if (isset($_POST['save'])){
if (md5(md5($_POST['pass'])) == $user['pass']  && $_POST['pass1']!=null && $_POST['pass2']!=null && $_POST['pass1']==$_POST['pass2']){
mysqli_query($connect, "UPDATE `users` SET `pass` = '$pass' WHERE `id` = '".intval($user['id'])."' LIMIT 1");
setcookie('userpass', $pass, time()+86400*365, '/');
echo '<div class="apicms_content"><center>Пароль успешно изменен</center></div>';
}else{
echo '<div class="erors"><center>Одно из полей заполнено не верно</center></div>';
}
}
/////////////////////////////////////////
echo "<form method='post' action='?saves'>";
echo "<div class='apicms_subhead'>";
echo "Старый пароль: <br /> <input type='text' name='pass' value='' /><br />";
echo "Новый пароль: <br /> <input type='password' name='pass1' value='' /><br />";
echo "Подтверждение: <br /> <input type='password' name='pass2' value='' /><br />";
echo "<input type='submit' name='save' value='Изменить' /></div></form>";
/////////////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>