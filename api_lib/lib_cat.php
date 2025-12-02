<?


////////////////////////////////////////
$title = 'Библиотека - Создание раздела';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
////////////////////////////////////////
global $connect;
$user_level = isset($user['level']) ? intval($user['level']) : 0;
if ($user_level==1 || $user_level==2){
if (isset($_POST['save'])){
if (!csrf_check()){
echo '<div class="erors"><center>Неверный CSRF-токен</center></div>';
} elseif (isset($_POST['cat']) && strlen($_POST['cat'])>2){
$lib_cat = apicms_filter($_POST['cat']);
$lib_opis = apicms_filter($_POST['opis']);
mysqli_query($connect, "INSERT INTO `api_lib_cat` (name, opis, id_user) values ('$lib_cat', '$lib_opis', '".intval($user['id'])."')");
}
///////////////////////////////////
echo '<div class="apicms_content"><center>Раздел успешно создан</center></div>';
}
////////////////////////////////////////
echo "<form method='post' action='?ok'>\n";
echo "<input type='hidden' name='csrf_token' value='".htmlspecialchars(csrf_token())."' />";
echo "<div class='apicms_subhead'><center>Название раздела: </br> <input type='text' name='cat' value=''  /> <br /> Описание раздела </br> <textarea name='opis'></textarea></center></div>\n";
///////////////////////////////////
echo "<div class='apicms_subhead'><center><input type='submit' name='save' value='Создать  раздел' /></center></div>\n";
}else{
echo "<div class='apicms_content'><center>Недостаточно прав для входа!</center></div>\n";
}
////////////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>
