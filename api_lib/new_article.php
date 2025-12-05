<?


////////////////////////////////////////
$title = 'Библиотека - Новая статья';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.display_html($api_design).'/head.php';
////////////////////////////////////////
global $connect;
if ($is_user){
$msg = '';
if (isset($_POST['save'])){
    if (!csrf_check()){
        $msg = '<div class="erors"><center>Неверный CSRF-токен</center></div>';
    } else {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $text = isset($_POST['text']) ? $_POST['text'] : '';
    $cat = isset($_POST['cat']) ? intval($_POST['cat']) : 0;
    if (strlen($name)>2 && strlen($text)>20 && $cat>0){
        $check_cat = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_lib_cat` WHERE `id` = '".$cat."' LIMIT 1");
        $check_cat_row = mysqli_fetch_assoc($check_cat);
        if ($check_cat_row && $check_cat_row['cnt']==1){
            $lib_name = apicms_filter($name);
            $lib_text = apicms_filter($text);
            $user_id = isset($user['id']) ? intval($user['id']) : 0;
            mysqli_query($connect, "INSERT INTO `api_lib_article` (name, text, id_user, cat, time) values ('$lib_name', '$lib_text', '$user_id', '$cat', '$time')");
            $msg = '<div class="apicms_content"><center>Статья создана!</center></div>';
        } else {
            $msg = '<div class="erors"><center>Раздел не найден</center></div>';
        }
    } else {
        $msg = '<div class="erors"><center>Проверьте название (минимум 3) и текст (минимум 20)</center></div>';
    }
    }
}
if ($msg !== '') echo $msg;
////////////////////////////////////////
echo "<form method='post' action='?ok'>\n";
echo "<input type='hidden' name='csrf_token' value='".display_html(csrf_token())."' />";
echo "<div class='apicms_subhead'>Название статьи: </br> <input type='text' name='name' value=''  /> <br /> Текст статьи: </br> <textarea name='text'></textarea></br>";
echo '</br><select name="cat">';
$cats = mysqli_query($connect, "SELECT * FROM `api_lib_cat` ORDER BY `id` ASC");
if(mysqli_num_rows($cats) > 0){
while($cat = mysqli_fetch_assoc($cats)){
echo '<option value="'.$cat['id'].'">'.display_html($cat['name']).'</option>';
}
}
echo '</select></div>';
/////////////////////////////////////
echo "<div class='apicms_subhead'><center><input type='submit' name='save' value='Создать статью' /></center></div>\n";
}else{
echo "<div class='apicms_content'><center>Авторизуйтесь, чтобы создать статью</center></div>\n";
}
////////////////////////////////////////
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
