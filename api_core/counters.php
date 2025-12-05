<?php

global $connect;
$api_settings = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `settings`"));
if (strlen($api_settings['counters'])>10){ /// выводим если символов больше 10
echo '<div class="apicms_content">'.display_html($api_settings['counters']).'</div>';
}

////////////////////////////////////////
?>
