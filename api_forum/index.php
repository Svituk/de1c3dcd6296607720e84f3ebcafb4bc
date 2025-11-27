<?

/////////////////////////////////////////
$title = 'Форум';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
/////////////////////////////////////////
// Guard user level for admin controls
$user_level = isset($user['level']) ? intval($user['level']) : 0;
global $connect;
$k_post_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_forum_razdel`");
$k_post_row = mysqli_fetch_assoc($k_post_result);
$k_post = $k_post_row['cnt'];
$k_page=k_page($k_post,$api_settings['on_page']);
$page=page($k_page);
$start=$api_settings['on_page']*$page-$api_settings['on_page'];
if ($k_post==0)echo "<div class='erors'>Разделов не найдено!</div>";
/////////////////////////////////////////
$qii=mysqli_query($connect, "SELECT * FROM `api_forum_razdel` ORDER BY id DESC LIMIT $start, ".$api_settings['on_page']);
while ($post_forum = mysqli_fetch_assoc($qii)){
$counts_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_forum_subforum` WHERE `razdel` = '".intval($post_forum['id'])."'");
$counts_row = mysqli_fetch_assoc($counts_result);
$counts = $counts_row['cnt'];
echo '<div class="apicms_subhead"><table width="100%" ><tr><td width="10%"><center><img src="/design/styles/'.htmlspecialchars($api_design).'/forum/razdel.png">';
echo "</center></td><td width='90%'>";
if ($user_level==1 || $user_level==2) echo ' <a href="delete_razdel.php?id='.$post_forum['id'].'"><img src="/design/styles/'.htmlspecialchars($api_design).'/forum/del_theme.png"></a> ';
echo "<a href='subforum.php?id=$post_forum[id]'><b>".htmlspecialchars($post_forum['name'])."  </b></a> ";
echo "<span style='float:right'> <small>".apicms_data($post_forum['time'])."</span> </br>";
if ($post_forum['opisanie']!=NULL)echo ''.htmlspecialchars($post_forum['opisanie']).'';
echo " <span style='float:right'> Всего: ".$counts." </small></span></br></td></tr></table></div>";
}
/////////////////////////////////////////
if ($k_page > 1){
echo '<div class="apicms_subhead"><center>';
str('&',$k_page,$page); // генерируем постраничную навигацию
echo '</center></div>';
}
/////////////////////////////////////////
if ($user_level==1 || $user_level==2)echo "<div class='apicms_subhead'> - <a href='razdel_create.php'>Создать новый раздел</a></div>";
/////////////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>
