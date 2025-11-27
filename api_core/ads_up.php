<?php

global $connect;
echo '<div class="apicms_ads"><!--noindex-->';
$rek_up = mysqli_query($connect, "SELECT * FROM `advertising` WHERE `time` > '".time()."' AND `mesto` = '1' ORDER BY time DESC");
while ($ads_up = mysqli_fetch_assoc($rek_up)){			
echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/images/reks.png" alt=""> <a href="'.$ads_up['link'].'" rel="nofollow"><small>'.htmlspecialchars($ads_up['name']).'</small></a> </br>';
}
echo '<!--/noindex--></div>';
////////////////////////////////////////
?>