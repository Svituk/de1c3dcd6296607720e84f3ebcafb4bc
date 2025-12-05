<?php

$themos = '4'; /////количество тем которые выводим

global $connect, $time, $api_design;
$last_theme = mysqli_query($connect, "SELECT * FROM `api_forum_theme` WHERE `close` = '0' ORDER BY time DESC LIMIT ".intval($themos)."");
while ($themes = mysqli_fetch_assoc($last_theme)){
	// get total posts count for this theme
	$counts = 0;
	$counts_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_forum_post` WHERE `theme` = '".intval($themes['id'])."'");
	if ($counts_result){
		$counts_row = mysqli_fetch_assoc($counts_result);
		$counts = isset($counts_row['cnt']) ? $counts_row['cnt'] : 0;
	}
$last_time = $time-86000;
$counts_last_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_forum_post` WHERE `theme` = '".intval($themes['id'])."' AND `time`>'$last_time'");
$counts_last_row = mysqli_fetch_assoc($counts_last_result);
	$counts_last = isset($counts_last_row['cnt']) ? $counts_last_row['cnt'] : 0;
if ($counts_last==0)$counts_last = '';
else
$counts_last = '<sup><font color=#FF0000>+'.$counts_last.'</font></sup>';
echo '<small><a class="apicms_menu_s" href="/api_forum/theme.php?id='.$themes['id'].'"> <img src="/design/styles/'.display_html($api_design).'/forum/m_theme.png" alt=" - "> ';
	// Properly nest tags: <a><strong>...</strong></a>
	echo ' '.display_html($themes['name']).' <b><span style="float:right"> '.$counts.''.$counts_last.'</span></b></a></small>';
}
////////////////////////////////////////
?>
