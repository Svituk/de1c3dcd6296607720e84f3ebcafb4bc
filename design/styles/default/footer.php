<?php

// Include ads_down using absolute path (H defined in apicms_system.php). Fallback to relative path if needed.
if (defined('H') && file_exists(H.'api_core/ads_down.php')){
	include_once H.'api_core/ads_down.php';
} elseif (file_exists(__DIR__.'/../../api_core/ads_down.php')){
	include_once __DIR__.'/../../api_core/ads_down.php';
}
// Flush buffered errors so they are visible even if set after head rendering
if (isset($apicms_errors) && is_array($apicms_errors)){
    foreach($apicms_errors as $e){ echo $e; }
    $apicms_errors = array();
}
global $connect;
$refr = apicms_generate(6);
$reg_count_result = mysqli_query($connect, "SELECT id FROM `users`");
$reg_count = mysqli_num_rows($reg_count_result);
$tm_on = time()-600;
$onsus_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `users` WHERE `activity` > '$tm_on'");
$onsus_row = mysqli_fetch_assoc($onsus_result);
$onsus = $onsus_row['cnt'];
if ($onsus > 0)$onsite = '<img src="/design/styles/'.display_html($api_design).'/images/onliner.png"> '.$onsus.'';
else $onsite = 'Никого нет';
$us_last = mysqli_fetch_array(mysqli_query($connect, "select `login`,`id` from `users` ORDER BY id DESC limit 1"));
////////////////////////////////////////
echo '<div class="apicms_footer"><table width="100%"><tr><td width="33%"><center><a href="/modules/all_profiles.php"><img src="/design/styles/'.display_html($api_design).'/images/profiles.png"> '.$reg_count.' </a> <a href="/profile.php?id='.$us_last['id'].'">('.display_html($us_last['login']).')</a> </center></td>';
echo '<td width="33%"><center> <a href="/"><img src="/design/styles/'.display_html($api_design).'/images/home.png"></a>  <a href="javascript:history.back()" onMouseOver="window.status=\'Назад\';return true"><img src="/design/styles/'.display_html($api_design).'/images/undo.png"></a> <a href="#top" id="top-link" title="Поднятся вверх"><img src="/design/styles/'.display_html($api_design).'/images/up.png"></a> <a href="?'.$refr.'" title="Обновить страницу"><img src="/design/styles/'.display_html($api_design).'/images/refresh.png"></a> </center></td>';
echo '<td width="33%"><center><a href="/modules/online.php">'.$onsite.'</a></center></td></tr></table></div>';
echo '<div class="loghead"><center><small>';
echo date( "На сервере - d.m.y H:i" );
$gen_s = 0;
if (isset($GLOBALS['APICMS_START'])){ $gen_s = (microtime(true) - $GLOBALS['APICMS_START']); }
elseif (isset($_SERVER['REQUEST_TIME_FLOAT'])){ $gen_s = (microtime(true) - floatval($_SERVER['REQUEST_TIME_FLOAT'])); }
$gen_fmt = number_format($gen_s, 3, ',', '');
if (function_exists('apicms_mark')){ apicms_mark('footer'); }
echo ' • Pgen: '.$gen_fmt;
if (defined('APICMS_DEBUG') && APICMS_DEBUG){
    $cur_bytes = memory_get_usage(false);
    $peak_bytes = memory_get_peak_usage(false);
    $start_bytes = isset($GLOBALS['APICMS_MEM_START']) ? $GLOBALS['APICMS_MEM_START'] : $cur_bytes;
    $mem_cur = number_format($cur_bytes/1048576, 2, ',', '');
    $mem_peak = number_format($peak_bytes/1048576, 2, ',', '');
    $mem_delta = number_format(max(0, $cur_bytes - $start_bytes)/1048576, 2, ',', '');
    $php_v = phpversion(); $sapi = php_sapi_name();
    $mysql_v = isset($connect) ? @mysqli_get_server_info($connect) : '';
    $files = count(get_included_files());
    $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
    $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
    echo ' | Mem: '.$mem_cur.'MB/'.$mem_peak.'MB (+'.$mem_delta.'MB) | Files: '.$files.' | PHP: '.$php_v.' '.$sapi.($mysql_v?(' | MySQL: '.$mysql_v):'');
    if (isset($GLOBALS['APICMS_PROFILE'])){
        $p = $GLOBALS['APICMS_PROFILE']; $s = isset($GLOBALS['APICMS_START']) ? $GLOBALS['APICMS_START'] : microtime(true);
        $seg = array();
        if (isset($p['db'])) $seg[] = 'db '.number_format($p['db']-$s,3,',','');
        if (isset($p['settings'])) $seg[] = 'set '.number_format($p['settings']-($p['db']??$s),3,',','');
        if (isset($p['user'])) $seg[] = 'user '.number_format($p['user']-($p['settings']??$s),3,',','');
        if (isset($p['head'])) $seg[] = 'head '.number_format($p['head']-($p['user']??$s),3,',','');
        if (isset($p['footer'])) $seg[] = 'foot '.number_format($p['footer']-($p['head']??$s),3,',','');
        if ($seg) echo ' • seg: '.implode(', ',$seg);
    }
}
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
