<?


/////////////////////////////////////////
$title = 'Мой список контактов';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';

if ($user['id']){
/////////////////////////////////////////
global $connect;
$k_post_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `contact_list` WHERE `my_id` = '".intval($user['id'])."'");
$k_post_row = mysqli_fetch_assoc($k_post_result);
$k_post = $k_post_row['cnt'];
$k_page=k_page($k_post,$api_settings['on_page']);
$page=page($k_page);
$start=$api_settings['on_page']*$page-$api_settings['on_page'];
if ($k_post==0)echo "<div class='erors'><center>Ваш контакт-лист пуст!</center></div>";
/////////////////////////////////////////
$qii=mysqli_query($connect, "SELECT * FROM `contact_list` WHERE `my_id` = '".intval($user['id'])."' ORDER BY id DESC LIMIT $start, ".$api_settings['on_page']);
while ($post_cont = mysqli_fetch_assoc($qii)){
$ank2=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = ".intval($post_cont['id_user'])." LIMIT 1"));
echo '<div class="apicms_subhead"><table width="100%" ><tr><td width="20%"><center>';
echo apicms_ava32($ank2['id']);
echo "</center></td><td width='80%'><a href='/profile.php?id=$ank2[id]'>".htmlspecialchars($ank2['login'])."</a> ( ".htmlspecialchars($ank2['name']).") </br>Добавлен: ".apicms_data($post_cont['time'])."</span>";
echo "</br><a href='/modules/user_mail.php?id=".$ank2['id']."'>Написать приватно</a></b></td></tr></table></div>";
}
if ($k_page > 1){
echo '<div class="apicms_subhead"><center>';
str('&',$k_page,$page); // генерируем постраничную навигацию
echo '</center></div>';
}
}else{
echo "<div class='apicms_content'>Функция только для пользователей</div>\n";
}

require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>