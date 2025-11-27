<?


/////////////////////////////////////////
$title = 'Добавление в контакты';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
/////////////////////////////////////////
if ($user['id']){
global $connect;
$contact = intval($_GET['id']);
$check_contact = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `contact_list` WHERE `id_user` = '$contact' AND `my_id` = '".intval($user['id'])."' LIMIT 1");
$check_contact_row = mysqli_fetch_assoc($check_contact);
$check_user = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `users` WHERE `id` = '".$contact."'");
$check_user_row = mysqli_fetch_assoc($check_user);
if (isset($_GET['id']) && $check_contact_row['cnt']==0 && $check_user_row['cnt']>0){
mysqli_query($connect, "INSERT INTO `contact_list` (`id_user`, `my_id`, `time`) VALUES ('$contact', '".intval($user['id'])."', '$time')");
echo '<div class="apicms_content"><center>Пользователь добавлен в контакт-лист</center></div>';
}
}else{
echo "<div class='apicms_content'>Функция только для пользователей</div>\n";
}
//////////////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>