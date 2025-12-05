<?


/////////////////////////////////////////
require_once '../api_core/apicms_system.php';
header('Content-Type: application/rss+xml; charset=UTF-8');
echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/"><channel>';
echo '<title>Новости</title>';
echo '<link>'.$set['site'].'</link>';
echo '<description>Новости '.$set['site'].'</description>';
echo '<language>ru-RU</language>';
/////////////////////////////////////////
global $connect;
$apirss = mysqli_query($connect, 'SELECT * FROM `news` ORDER BY `time` DESC LIMIT 15;');
if (mysqli_num_rows($apirss)){
while ($api_rss = mysqli_fetch_assoc($apirss)){
$ank = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '".intval($api_rss['id_user'])."' LIMIT 1"));
echo '<item><title>News: '.display_html($api_rss['name']).'</title>';
echo '<link>'.$set['site'].'/modules/news.php</link>';
echo '<author>'.display_html($ank['login']).'</author>';
echo '<description>'.display_html($api_rss['txt']).'</description>';
echo '<pubDate></pubDate></item>';
}
}
/////////////////////////////////////////
echo '</channel></rss>';
?>
