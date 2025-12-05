<?php

global $connect;
echo '<div class="apicms_ads"><!--noindex-->';
$rek_up = mysqli_query($connect, "SELECT * FROM `advertising` WHERE `time` > '".time()."' AND `mesto` = '1' ORDER BY time DESC");
while ($ads_up = mysqli_fetch_assoc($rek_up)){
    $ad_name = display_html($ads_up['name']);
    $link_raw = trim($ads_up['link']);
    $safe_href = '';
    if ($link_raw !== ''){
        if (stripos($link_raw, 'javascript:') === 0) {
            $safe_href = '';
        } elseif (filter_var($link_raw, FILTER_VALIDATE_URL) || strpos($link_raw, '/') === 0) {
            $safe_href = display_html($link_raw);
        }
    }
    if ($safe_href !== ''){
        echo '<img src="/design/styles/'.display_html($api_design).'/images/reks.png" alt=""> <a href="'.$safe_href.'" rel="nofollow"><small>'.$ad_name.'</small></a><br/>';
    } else {
        echo '<img src="/design/styles/'.display_html($api_design).'/images/reks.png" alt=""> <small>'.$ad_name.'</small><br/>';
    }
}
echo '<!--/noindex--></div>';
////////////////////////////////////////
?>
