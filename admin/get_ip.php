<?


/////////////////////////////////////////
$title = 'Поиск совпадений в IP';
require_once '../api_core/apicms_system.php';
if (!function_exists('apicms_ob_started')){ ob_start(); function apicms_ob_started(){} }
require_once '../design/styles/'.display_html($api_design).'/head.php';
/////////////////////////////////////////
if ($user['level']==1 or $user['level']==2){
global $connect;
if (isset($_GET['ip']))$ips=mysqli_real_escape_string($connect, $_GET['ip']);
/////////////////////////////////////////
if (isset($_GET['ip'])){
$k_post_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `users`  WHERE `ip` like '%".$ips."%'");
$k_post_row = mysqli_fetch_assoc($k_post_result);
$k_post = $k_post_row['cnt'];
if ($k_post==0)echo "<div class='erors'>Совпадений не найдено!</div>\n";
/////////////////////////////////////////
$q=mysqli_query($connect, "SELECT * FROM `users` WHERE `ip` like '%".$ips."%' ORDER BY `id`");
while ($post = mysqli_fetch_assoc($q)){
echo '<a class="apicms_subhead" href="/profile.php?id='.intval($post['id']).'">'.display_html($post['login']).' </a>';
}
}else{
echo "<div class='erors'>Ошибка построения запроса</div>";
}
/////////////////////////////////////////
echo "<div class='apicms_content'><a href='/admin/'>В админ-панель</a><br /></div>\n";
}else{
echo "<div class='erors'>У вас нет прав для данной функции</div>";
}
require_once '../design/styles/'.display_html($api_design).'/footer.php';
/////////////////////////////////////////
?>
