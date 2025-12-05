<?php

global $connect;
$query = mysqli_query($connect, "SELECT * FROM `news` ORDER BY time DESC LIMIT 1");
while ($newsone = $query ? mysqli_fetch_assoc($query) : array()){
    $news_id = isset($newsone['id']) ? intval($newsone['id']) : 0;
    $koms_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `news_comm` WHERE `id_news` = '".$news_id."'");
    $koms_row = $koms_result ? mysqli_fetch_assoc($koms_result) : array('cnt' => 0);
    $koms = isset($koms_row['cnt']) ? intval($koms_row['cnt']) : 0;
    $koms = $koms > 0 ? ' +'.$koms.'' : '';
    $author_id = isset($newsone['id_user']) ? intval($newsone['id_user']) : 0;
    $ank_result = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '".$author_id."' LIMIT 1");
    $ank = $ank_result ? mysqli_fetch_assoc($ank_result) : array('login' => 'Гость');
    $name_safe = isset($newsone['name']) ? display_html($newsone['name']) : '';
    $txt_safe = isset($newsone['txt']) ? display_html($newsone['txt']) : '';
    $login_safe = isset($ank['login']) ? display_html($ank['login']) : '';
    echo '<div class="apicms_content"><div class="descr">';
    echo ' <img src="/design/styles/'.display_html($api_design).'/menu/news_m.png"/> <a href="/modules/all_news.php"><strong><font color=#ffffff>'.apicms_smiles(apicms_bb_code(apicms_br($name_safe))).'</font></strong></a> [ <a href="/modules/rss.php"><font color=#ffffff>RSS</font></a> ] <span style="float:right"><small> '.apicms_data(isset($newsone['time']) ? $newsone['time'] : time()).' </small></span> </br> '.apicms_smiles(apicms_bb_code(apicms_br($txt_safe))).'';
    echo '<hr> <img src="/design/styles/'.display_html($api_design).'/menu/all_comms.png"/> <a href="/modules/news_comm.php?id='.$news_id.'"><small><font color=#ffffff>Комментарии '.$koms.'</font></small></a> <span style="float:right"> <small>'.$login_safe.'</small> <img src="/design/styles/'.display_html($api_design).'/menu/rsnews.png"/></span> </div></div>';
}
///////////////////////////////////
?>
