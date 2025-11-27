<?


////////////////////////////////////////
$title = 'Библиотека - Новая статья';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
////////////////////////////////////////
global $connect;
if ($user['level']==1 or $user['level']==2){
if (isset($_POST['save'])){
if (isset($_POST['name']) && isset($_POST['text']) && strlen($_POST['name'])>2 && strlen($_POST['text'])>20){
$lib_name = apicms_filter($_POST['name']);
$lib_text = apicms_filter($_POST['text']);
$cat = intval($_POST['cat']);
mysqli_query($connect, "INSERT INTO `api_lib_article` (name, text, id_user, cat, time) values ('$lib_name', '$lib_text', '".intval($user['id'])."', '$cat', '$time')");
}
///////////////////////////////////
echo '<div class="apicms_content"><center>Статья создана!</center></div>';
}
////////////////////////////////////////
echo "<form method='post' action='?ok'>\n";
echo "<div class='apicms_subhead'>Название статьи: </br> <input type='text' name='name' value=''  /> <br /> Текст статьи: </br> <textarea name='text'></textarea>\n";
echo '</br><select name="cat">';
$cats = mysqli_query($connect, "SELECT * FROM `api_lib_cat` ORDER BY `id` ASC");
if(mysqli_num_rows($cats) > 0){
while($cat = mysqli_fetch_assoc($cats)){
echo '<option value="'.$cat['id'].'">'.htmlspecialchars($cat['name']).'</option>';
}
}
echo '</select></div>';
///////////////////////////////////
echo "<div class='apicms_subhead'><center><input type='submit' name='save' value='Создать статью' /></center></div>\n";
}else{
echo "<div class='apicms_content'><center>Недостаточно прав для входа!</center></div>\n";
}
////////////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>