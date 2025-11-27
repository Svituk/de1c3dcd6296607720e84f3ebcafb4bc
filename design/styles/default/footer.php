<?php

// Include ads_down using absolute path (H defined in apicms_system.php). Fallback to relative path if needed.
if (defined('H') && file_exists(H.'api_core/ads_down.php')){
	include_once H.'api_core/ads_down.php';
} elseif (file_exists(__DIR__.'/../../api_core/ads_down.php')){
	include_once __DIR__.'/../../api_core/ads_down.php';
}
global $connect;
$refr = apicms_generate(6);
$reg_count_result = mysqli_query($connect, "SELECT id FROM `users`");
$reg_count = mysqli_num_rows($reg_count_result);
$tm_on = time()-600;
$onsus_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `users` WHERE `activity` > '$tm_on'");
$onsus_row = mysqli_fetch_assoc($onsus_result);
$onsus = $onsus_row['cnt'];
if ($onsus > 0)$onsite = '<img src="/design/styles/'.htmlspecialchars($api_design).'/images/onliner.png"> '.$onsus.'';
else $onsite = 'Никого нет';
$us_last = mysqli_fetch_array(mysqli_query($connect, "select `login`,`id` from `users` ORDER BY id DESC limit 1"));
////////////////////////////////////////
echo '<div class="apicms_footer"><table width="100%"><tr><td width="33%"><center><a href="/modules/all_profiles.php"><img src="/design/styles/'.htmlspecialchars($api_design).'/images/profiles.png"> '.$reg_count.' </a> <a href="/profile.php?id='.$us_last['id'].'">('.htmlspecialchars($us_last['login']).')</a> </center></td>';
echo '<td width="33%"><center> <a href="/"><img src="/design/styles/'.htmlspecialchars($api_design).'/images/home.png"></a>  <a href="javascript:history.back()" onMouseOver="window.status=\'Назад\';return true"><img src="/design/styles/'.htmlspecialchars($api_design).'/images/undo.png"></a> <a href="#top" id="top-link" title="Поднятся вверх"><img src="/design/styles/'.htmlspecialchars($api_design).'/images/up.png"></a> <a href="?'.$refr.'" title="Обновить страницу"><img src="/design/styles/'.htmlspecialchars($api_design).'/images/refresh.png"></a> </center></td>';
echo '<td width="33%"><center><a href="/modules/online.php">'.$onsite.'</a></center></td></tr></table></div>';
echo '<div class="loghead"><center><small>';
echo '<a href="http://apicms.ru"><font color="FFFFFF"> <strong>Управление сайтом ApiCMS</strong></a></br>';
echo date( "На сервере - d.m.y H:i" );
// Safely output counters: decode stored value and only output if it looks like HTML/JS
$decoded_counters = '';
if (!empty($api_settings['counters'])){
	$decoded_counters = @base64_decode($api_settings['counters']);
	if ($decoded_counters === false) $decoded_counters = '';
}
// Wrap counters to avoid breaking footer markup if counters content is malformed
$counters_output = '';
if ($decoded_counters !== '' && strpos($decoded_counters, '<') !== false){
	$counters_output = '<div class="site_counters">'. $decoded_counters .'</div>';
}
echo '</small></center></font></div>'. $counters_output .'</body></html>';
////////////////////////////////////////
?>