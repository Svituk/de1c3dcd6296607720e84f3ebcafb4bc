<?


/////////////////////////////////////////
$title = 'Добавление в контакты';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.display_html($api_design).'/head.php';
/////////////////////////////////////////
if ($user['id']){
global $connect;
$contact = isset($_GET['id']) ? intval($_GET['id']) : 0;
$check_contact = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `contact_list` WHERE `id_user` = '".$contact."' AND `my_id` = '".intval($user['id'])."' LIMIT 1");
$check_contact_row = mysqli_fetch_assoc($check_contact);
$check_user = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `users` WHERE `id` = '".$contact."'");
$check_user_row = mysqli_fetch_assoc($check_user);
if ($contact && $check_contact_row['cnt']==0 && $check_user_row['cnt']>0){
    if ($_SERVER['REQUEST_METHOD']==='POST'){
        if (csrf_check()){
            mysqli_query($connect, "INSERT INTO `contact_list` (`id_user`, `my_id`, `time`) VALUES ('".$contact."', '".intval($user['id'])."', '$time')");
            echo '<div class="apicms_content"><center>Пользователь добавлен в контакт-лист</center></div>';
        } else {
            echo '<div class="erors"><center>Неверный CSRF-токен</center></div>';
        }
    } else {
        echo "<div class='apicms_subhead'><center>Добавить пользователя в контакты?</center></div>";
        echo "<form method='post' action='?id=".$contact."'>";
        echo "<input type='hidden' name='csrf_token' value='".display_html(csrf_token())."' />";
        echo "<div class='apicms_subhead'><center><input type='submit' value='Добавить' /></center></div>";
        echo "</form>";
    }
} else if (!$contact) {
    echo '<div class="erors"><center>Не указан пользователь</center></div>';
}
}else{
echo "<div class='apicms_content'>Функция только для пользователей</div>\n";
}
//////////////////////////////////////////
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
