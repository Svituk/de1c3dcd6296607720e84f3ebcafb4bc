<?


/////////////////////////////////////////
$title = 'Пользователи онлайн';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
/////////////////////////////////////////
$user_level = isset($user['level']) ? intval($user['level']) : 0;
$my_acts = time()-600;
///////////////////////////////////
global $connect;
$k_post_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `users`  WHERE `activity` > '$my_acts'");
$k_post_row = mysqli_fetch_assoc($k_post_result);
$k_post = $k_post_row['cnt'];
$k_page=k_page($k_post,$api_settings['on_page']);
$page=page($k_page);
$start=$api_settings['on_page']*$page-$api_settings['on_page'];
if ($k_post==0)echo "<div class='apicms_content'><center>На сайте пока никого нет</center></div>";
/////////////////////////////////////////
$qii_on=mysqli_query($connect, "SELECT * FROM `users` WHERE `activity` > '$my_acts'  ORDER BY activity DESC LIMIT $start, ".$api_settings['on_page']);
while ($post_on = mysqli_fetch_assoc($qii_on)){
$ank=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = ".intval($post_on['id'])." LIMIT 1"));
if ($ank['level']==1){
echo "<div class='apicms_subhead'><table width='100%'><tr><td width='10%'>";
echo apicms_ava40($ank['id']);
echo "</td><td width='90%'> ".agent($ank['id'])." <a href='/profile.php?id=".$ank['id']."'><b>".htmlspecialchars($ank['login'])."</b></a> (ADM) <span style='float:right'><small> ".apicms_data($post_on['activity'])." </small></span> </br> ".htmlspecialchars($ank['my_place'])." </br> ";
if ($user_level==1)echo "<small> IP: <a href='/admin/get_ip.php?ip=".$ank['ip']."'>".$ank['ip']."</a> </small></br> ";
echo "</td></tr></table> </div>";
}
if ($ank['level']==2){
echo "<div class='apicms_subhead'><table width='100%'><tr><td width='10%'>";
echo apicms_ava40($ank['id']);
echo "</td><td width='90%'><a href='/profile.php?id=".$ank['id']."'><b>".htmlspecialchars($ank['login'])."</b></a> (MOD) <span style='float:right'><small> ".apicms_data($post_on['activity'])." </small></span> </br> ".htmlspecialchars($ank['my_place'])." </br> ";
if ($user_level==1)echo "<small> IP: <a href='/admin/get_ip.php?ip=".$ank['ip']."'>".$ank['ip']."</a> </small></br> ";
echo "</td></tr></table> </div>";
}
if ($ank['level']==0){
echo "<div class='apicms_subhead'><table width='100%'><tr><td width='10%'>";
echo apicms_ava40($ank['id']);
echo "</td><td width='90%'><a href='/profile.php?id=".$ank['id']."'><b>".htmlspecialchars($ank['login'])."</b></a> <span style='float:right'><small> ".apicms_data($post_on['activity'])." </small></span> </br> ".htmlspecialchars($ank['my_place'])." </br> ";
if ($user_level==1)echo "<small> IP: <a href='/admin/get_ip.php?ip=".$ank['ip']."'>".$ank['ip']."</a> </small></br> ";
echo "</td></tr></table> </div>";
}
}
/////////////////////////////////////////
if ($k_page > 1){
echo '<div class="apicms_subhead"><center>';
str('?',$k_page,$page); // генерируем постраничную навигацию
echo '</center></div>';
}
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>
