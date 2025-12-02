<?php

/////////////////////////////////////////
$title = 'Каталог статей';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
/////////////////////////////////////////
global $connect;
$lib_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
/////////////////////////////////////////
$on_page = isset($api_settings['on_page']) && intval($api_settings['on_page']) > 0 ? intval($api_settings['on_page']) : 10;
$k_post_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_lib_article` WHERE `cat` = '".intval($lib_id)."'");
$k_post_row = mysqli_fetch_assoc($k_post_result);
$k_post = $k_post_row['cnt'];
$k_page=k_page($k_post,$on_page);
$page=page($k_page);
$start=$on_page*$page-$on_page;
if ($k_post==0)echo "<div class='erors'><center>Статей не найдено!</center></div>";
/////////////////////////////////////////
 $qii=mysqli_query($connect, "SELECT * FROM `api_lib_article` WHERE `cat` = '".intval($lib_id)."' ORDER BY id DESC LIMIT $start, ".$on_page);
while ($post_lib = mysqli_fetch_assoc($qii)){
echo '<div class="apicms_subhead"><table width="100%" ><tr><td width="10%"><center><img src="/design/styles/'.htmlspecialchars($api_design).'/lib/article.png">';
echo "</center></td><td width='90%'>";
$user_level = isset($user['level']) ? intval($user['level']) : 0;
$user_id = isset($user['id']) ? intval($user['id']) : 0;
if ($user_level==1 || ($user_id && $user_id==$post_lib['id_user'])) echo ' <span style="float:right"><a href="delete_article.php?id='.$post_lib['id'].'&raz='.$lib_id.'"><img src="/design/styles/'.htmlspecialchars($api_design).'/lib/del_article.png"></a> </span>';
echo "<a href='article.php?id=$post_lib[id]'><b>".htmlspecialchars($post_lib['name'])."</b></a>";
if ($user_id && $user_id==$post_lib['id_user']) echo " &nbsp;<small><a href='article.php?id=$post_lib[id]&edit=1'>Редактировать</a></small>";
echo "</br></td></tr></table></div>";
}
/////////////////////////////////////////
if ($k_page > 1){
echo '<div class="apicms_subhead"><center>';
str('article_list.php?',$k_page,$page); // генерируем постраничную навигацию
echo '</center></div>';
}
/////////////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>
