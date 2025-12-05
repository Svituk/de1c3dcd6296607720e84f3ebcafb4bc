<?


/////////////////////////////////////////
$title = 'Пользователи сайта';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.display_html($api_design).'/head.php';
/////////////////////////////////////////
global $connect;
$k_post_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `users`");
$k_post_row = mysqli_fetch_assoc($k_post_result);
$k_post = $k_post_row['cnt'];
$k_page=k_page($k_post,$api_settings['on_page']);
$page=page($k_page);
$start=$api_settings['on_page']*$page-$api_settings['on_page'];
if ($k_post==0)echo "<div class='apicms_content'><center>Регистраций не найдено</center></div>";
/////////////////////////////////////////
$qii_us=mysqli_query($connect, "SELECT * FROM `users` ORDER BY id DESC LIMIT $start, ".$api_settings['on_page']);
while ($post_us = mysqli_fetch_assoc($qii_us)){
$ank=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = ".intval($post_us['id'])." LIMIT 1"));
if ($ank['level']==1){
echo "<div class='apicms_subhead'><table width='100%'><tr><td width='10%'> ";
echo apicms_ava32($ank['id']);
echo "</td><td width='90%'> <a href='/profile.php?id=".$ank['id']."'><b>".display_html($ank['login'])."</b></a> 
 <small>[ Администратор ]</small> 
 <small><span style='float:right'>".apicms_data($post_us['activity'])."</span></small></br>
 <small>Регистрация: ".apicms_data($post_us['regtime'])."</small>  </br>";
echo "</td></tr></table> </div>";
}else{
echo "<div class='apicms_subhead'><table width='100%'><tr><td width='10%'> ";
echo apicms_ava32($ank['id']);
echo "</td><td width='90%'> <a href='/profile.php?id=".$ank['id']."'><b>".display_html($ank['login'])."</b></a>   
 <small><span style='float:right'>".apicms_data($post_us['activity'])."</span></small></br>
 <small>Регистрация: ".apicms_data($post_us['regtime'])."</small>  </br>";
echo "</td></tr></table> </div>";
}
}
/////////////////////////////////////////
if ($k_page > 1){
echo '<div class="apicms_subhead"><center>';
str('?',$k_page,$page); // генерируем постраничную навигацию
echo '</center></div>';
}
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
