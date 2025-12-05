<?


/////////////////////////////////////////
$title = 'Форум - Подфорум - Темы';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.display_html($api_design).'/head.php';
/////////////////////////////////////////
global $connect;
if (isset($_GET['id']))$subforum_id = intval($_GET['id']);
$sub_name = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `api_forum_subforum` WHERE `id` = '$subforum_id' LIMIT 1"));
$check_subforum = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_forum_subforum` WHERE `id` = '".$subforum_id."'");
$check_subforum_row = mysqli_fetch_assoc($check_subforum);
if (isset($_GET['id']) && $check_subforum_row['cnt']==1){
/////////////////////////////////////////
$k_post_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_forum_theme` WHERE `subforum` = '$subforum_id'");
$k_post_row = mysqli_fetch_assoc($k_post_result);
$k_post = $k_post_row['cnt'];
$k_page=k_page($k_post,$api_settings['on_page']);
$page=page($k_page);
$start=$api_settings['on_page']*$page-$api_settings['on_page'];
if ($k_post==0)echo "<div class='apicms_content'><center>Тем не найдено!</center></div>";
/////////////////////////////////////////
$qii=mysqli_query($connect, "SELECT * FROM `api_forum_theme` WHERE `subforum` = '$subforum_id' ORDER BY id DESC LIMIT $start, ".$api_settings['on_page']);
while ($post_all_theme = mysqli_fetch_assoc($qii)){
$counts_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_forum_post` WHERE `theme` = '".intval($post_all_theme['id'])."'");
$counts_row = mysqli_fetch_assoc($counts_result);
$counts = $counts_row['cnt'];
$who_theme = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = ".intval($post_all_theme['id_user'])." LIMIT 1"));
echo '<div class="apicms_subhead"><table width="100%" ><tr><td width="10%"><center>';
if ($post_all_theme['close']==0)echo '<img src="/design/styles/'.display_html($api_design).'/forum/theme.png">';
if ($post_all_theme['close']==1)echo '<img src="/design/styles/'.display_html($api_design).'/forum/locked_theme.png">';
echo "</center></td><td width='90%'><a href='theme.php?id=$post_all_theme[id]'><b>".display_html($post_all_theme['name'])."</b></a> </br> Автор темы: <a href='profile.php?id=".$who_theme['id']."'>".$who_theme['login']."</a>";
echo "<span style='float:right'><small> ".apicms_data($post_all_theme['time'])." </span> </br> <span style='float:right'> Ответов: ".$counts." </small></span></td></tr></table></div>";
}
/////////////////////////////////////////
if ($k_page > 1){
echo '<div class="apicms_subhead"><center>';
str('&',$k_page,$page); // генерируем постраничную навигацию
echo '</center></div>';
}
/////////////////////////////////////////
if ($user)echo "<div class='apicms_subhead'> - <a href='theme_create.php?id=$subforum_id'>Создать новую тему</a></div>";
}else{
echo '<div class="erors">Ошибка доступа</div>';
}
/////////////////////////////////////////
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
