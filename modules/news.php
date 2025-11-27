<?php

global $connect;
$query = mysqli_query($connect, "SELECT * FROM `news` ORDER BY time DESC LIMIT 1");
while ($newsone = mysqli_fetch_assoc($query)){
$koms_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `news_comm` WHERE `id_news` = '".intval($newsone['id'])."'");
$koms_row = mysqli_fetch_assoc($koms_result);
$koms = $koms_row['cnt'];
if ($koms==0)$koms=NULL;
else $koms = ' +'.$koms.'';
$ank=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '".intval($newsone['id_user'])."' LIMIT 1"));
echo '<div class="apicms_content"><div class="descr">';
echo ' <img src="/design/styles/'.htmlspecialchars($api_design).'/menu/news_m.png"/> <a href="/modules/all_news.php"><strong><font color=#ffffff>'.apicms_smiles(apicms_bb_code(apicms_br(htmlspecialchars($newsone['name'])))).'</font></strong></a> [ <a href="/modules/rss.php"><font color=#ffffff>RSS</font></a> ] <span style="float:right"><small> '.apicms_data($newsone['time']).' </small></span> </br> '.apicms_smiles(apicms_bb_code(apicms_br(htmlspecialchars($newsone['txt'])))).'';
echo '<hr> <img src="/design/styles/'.htmlspecialchars($api_design).'/menu/all_comms.png"/> <a href="/modules/news_comm.php?id='.$newsone['id'].'"><small><font color=#ffffff>Комментарии '.$koms.'</font></small></a> <span style="float:right"> <small>'.htmlspecialchars($ank['login']).'</small> <img src="/design/styles/'.htmlspecialchars($api_design).'/menu/rsnews.png"/></span> </div></div>';
}
///////////////////////////////////
?>