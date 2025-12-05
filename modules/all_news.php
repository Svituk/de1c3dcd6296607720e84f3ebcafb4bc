<?php


/////////////////////////////////////////
$title = 'Новости за весь период';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.display_html($api_design).'/head.php';
/////////////////////////////////////////
global $connect;
$k_post_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `news`");
$k_post_row = mysqli_fetch_assoc($k_post_result);
$k_post = $k_post_row['cnt'];
$k_page=k_page($k_post,$api_settings['on_page']);
$page=page($k_page);
$start=$api_settings['on_page']*$page-$api_settings['on_page'];
if ($k_post==0)echo "<div class='apicms_content'><center>Новостей сайта не найдено</center></div>";
/////////////////////////////////////////
$query = mysqli_query($connect, "SELECT * FROM `news` ORDER BY time DESC LIMIT $start, ".$api_settings['on_page']);
while ($newsone = mysqli_fetch_assoc($query)){
$koms_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `news_comm` WHERE `id_news` = '".intval($newsone['id'])."'");
$koms_row = mysqli_fetch_assoc($koms_result);
$koms = $koms_row['cnt'];
if ($koms==0)$koms=NULL;
else $koms = ' +'.$koms.'';		
$ank = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '".intval($newsone['id_user'])."' LIMIT 1"));	
// Safe author name (user may have been deleted)
$author_login = (isset($ank['login']) && $ank['login'] !== null) ? display_html($ank['login']) : '—';
$koms_display = ($koms == 0) ? '' : ' +'.intval($koms);
echo '<div class="apicms_subhead"><div class="descr"><font color=#ffffff><strong>'.apicms_smiles(apicms_bb_code(apicms_br(display_html($newsone['name'])))).'</strong> <span style="float:right"><small>'.apicms_data($newsone['time']).'</small></span> <br/> '.apicms_smiles(apicms_bb_code(apicms_br(display_html($newsone['txt'])))).' 
<hr><a href="/modules/news_comm.php?id='.$newsone['id'].'"><small>Комментарии '.$koms_display.'</small></a> <span style="float:right"> <small>'.$author_login.'</small> <img src="/design/styles/'.display_html($api_design).'/menu/rsnews.png"/></span></font></div></div>';
}
/////////////////////////////////////////
if ($k_page > 1){
echo '<div class="apicms_subhead"><center>';
str('?',$k_page,$page); // генерируем постраничную навигацию
echo '</center></div>';
}
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
