<?php

/////////////////////////////////////////
$title = 'Библиотека';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.display_html($api_design).'/head.php';
/////////////////////////////////////////
global $connect;
$on_page = isset($api_settings['on_page']) && intval($api_settings['on_page']) > 0 ? intval($api_settings['on_page']) : 10;
$k_post_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_lib_cat`");
$k_post_row = mysqli_fetch_assoc($k_post_result);
$k_post = $k_post_row['cnt'];
$k_page=k_page($k_post,$on_page);
$page=page($k_page);
$start=$on_page*$page-$on_page;
if ($k_post==0)echo "<div class='erors'><center>Разделов не найдено!</center></div>";
/////////////////////////////////////////
 $qii=mysqli_query($connect, "SELECT * FROM `api_lib_cat` ORDER BY id DESC LIMIT $start, ".$on_page);
while ($post_lib = mysqli_fetch_assoc($qii)){
$counts_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_lib_article` WHERE `cat` = '".intval($post_lib['id'])."'");
$counts_row = mysqli_fetch_assoc($counts_result);
$counts = $counts_row['cnt'];
echo '<div class="apicms_subhead"><table width="100%" ><tr><td width="10%"><center><img src="/design/styles/'.display_html($api_design).'/lib/cat.png">';
echo "</center></td><td width='90%'>";
if (!empty($user) && isset($user['level']) && ($user['level']==1 || $user['level']==2)) echo ' <a href="delete_cat.php?id='.$post_lib['id'].'"><img src="/design/styles/'.display_html($api_design).'/lib/del_cat.png"></a> ';
echo "<a href='article_list.php?id=$post_lib[id]'><b>".display_html($post_lib['name'])."  </b></a> </br>";
if ($post_lib['opis']!=NULL)echo ''.display_html($post_lib['opis']).'';
echo " <span style='float:right'> Статей: ".$counts." </small></span></br></td></tr></table></div>";
}
/////////////////////////////////////////
if ($k_page > 1){
echo '<div class="apicms_subhead"><center>';
str('index.php?',$k_page,$page); // генерируем постраничную навигацию
echo '</center></div>';
}
/////////////////////////////////////////
if (!empty($user) && isset($user['level']) && ($user['level']==1 || $user['level']==2)){
echo "<div class='apicms_subhead'> <table width='100%' ><tr><td width='50%'><center> <a href='lib_cat.php'>Создать раздел</a> </center></td><td width='50%'><center> <a href='new_article.php'>Создать статью</a></center></td></tr></table></div>";
} elseif ($is_user) {
echo "<div class='apicms_subhead'><center><a href='new_article.php'>Создать статью</a></center></div>";
}
/////////////////////////////////////////
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
