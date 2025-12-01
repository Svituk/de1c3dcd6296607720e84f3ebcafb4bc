<?


/////////////////////////////////////////
$title = 'Гостевая страница сайта';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
/////////////////////////////////////////
// Guard user access to avoid null offset warnings
$is_user = !empty($user);
$user_level = $is_user && isset($user['level']) ? intval($user['level']) : 0;

if ($user_level>0){
if (isset($_POST['txt'])){
$raw = isset($_POST['txt']) ? $_POST['txt'] : '';
$len = mb_strlen($raw, 'UTF-8');
if ($len>1024)$err = '<div class="apicms_content"><center>Очень длинное сообщение</center></div>';
if ($len<10)$err = '<div class="apicms_content"><center>Короткое сообщение</center></div>';
$hashtxt=str_replace(" ","", $raw);
if(empty($hashtxt))$err = '<div class="apicms_content"><center>Ошибка ввода сообщения</center></div>';  
if (!isset($err)){
$text = apicms_filter($raw);
if (mb_strlen($text, 'UTF-8') > 1024) $err = '<div class="apicms_content"><center>Очень длинное сообщение</center></div>';
}
if (!isset($err)){
global $connect;
$ins = mysqli_query($connect, "INSERT INTO `guest` (`txt`, `ip`, `time`, `browser`, `oc`, `adm`) VALUES ('$text', '".apicms_filter($ip)."', '$time', '".browser()."', '".apicms_filter($oc)."', '1')");
if ($ins){
echo '<div class="erors">Сообщение успешно добавлено</div>';
} else {
echo '<div class="apicms_content"><center>Ошибка записи сообщения</center></div>';
}
} else {
apicms_error($err);
}
}
}
if (!$is_user){
if (isset($_POST['txt'])){
    $raw = isset($_POST['txt']) ? $_POST['txt'] : '';
    $code = isset($_POST['code']) ? $_POST['code'] : '';
    if ($code === '') $err = '<div class="apicms_content"><center>Вы не ввели проверочное число</center></div>';
    else if (!isset($_SESSION['captcha']) || $code != $_SESSION['captcha']) $err = '<div class="apicms_content"><center>Неверное проверочное число</center></div>';
$len = mb_strlen($raw, 'UTF-8');
if ($len>1024)$err = '<div class="apicms_content"><center>Очень длинное сообщение</center></div>';
if ($len<10)$err = '<div class="apicms_content"><center>Короткое сообщение</center></div>';
$hashtxt=str_replace(" ","", $raw);
if(empty($hashtxt))$err = '<div class="apicms_content"><center>Ошибка ввода сообщения</center></div>';  
if (!isset($err)){
$text = apicms_filter($raw);
if (mb_strlen($text, 'UTF-8') > 1024) $err = '<div class="apicms_content"><center>Очень длинное сообщение</center></div>';
}
if (!isset($err)){
global $connect;
$ins = mysqli_query($connect, "INSERT INTO `guest` (`txt`, `ip`, `time`, `browser`, `oc`, `adm`) VALUES ('$text', '".apicms_filter($ip)."', '$time', '".browser()."', '".apicms_filter($oc)."', '0')");
if ($ins){
echo '<div class="erors">Сообщение успешно добавлено</div>';
} else {
echo '<div class="apicms_content"><center>Ошибка записи сообщения</center></div>';
}
} else {
apicms_error($err);
}
}
}

/////////////////////////////////////////
global $connect;
$k_post_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `guest`");
$k_post_row = mysqli_fetch_assoc($k_post_result);
$k_post = $k_post_row['cnt'];
$k_page=k_page($k_post,$api_settings['on_page']);
$page=page($k_page);
$start=$api_settings['on_page']*$page-$api_settings['on_page'];
if ($k_post==0)echo "<div class='erors'>Сообщений в гостевой не найдено</div>";
/////////////////////////////////////////
$qii=mysqli_query($connect, "SELECT * FROM `guest` ORDER BY id DESC LIMIT $start, ".$api_settings['on_page']);
while ($post_guest = mysqli_fetch_assoc($qii)){
	// safe user id for guest posts (in case the field is missing/null)
	$post_guest_user_id = isset($post_guest['id_user']) ? intval($post_guest['id_user']) : 0;
	$ank2_result = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '".intval($post_guest_user_id)."' LIMIT 1");
	$ank2 = $ank2_result ? mysqli_fetch_assoc($ank2_result) : array('id' => 0, 'login' => 'Гость');
	echo '<div class="apicms_subhead"><table width="100%" ><tr><td width="20%"><center>';
if ($post_guest['adm']==1){
echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/guest/admin.png">';
}else{
echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/guest/user.png">';
}
echo "</center></td><td width='80%'> ";
if ($post_guest['adm']==1){
echo 'Статус: <font color="red"><b>Администрация сайта</b></font>';
}else{
echo 'Статус: <b>Гость сайта</b>';
}
echo "<span style='float:right'> ".apicms_data($post_guest['time'])." ";
if ($user_level>=1) echo ' | <a href="delete.php?id='.$post_guest['id'].'">DEL</a> ';
echo " </span>";
echo "</br>";
if ($user_level>=1)echo "<small> IP: ".$post_guest['ip']." / Браузер: ".$post_guest['browser']." / ОС: ".$post_guest['oc']."</small></br>";
echo " ".apicms_smiles(apicms_bb_code(apicms_br(htmlspecialchars($post_guest['txt']))))."</td></tr></table></div>";
}
/////////////////////////////////////////
if ($user_level>0){
echo "<form action='?ok' method='post'>";
echo "<div class='apicms_dialog'><center><textarea name='txt'></textarea><br />";
echo "<input type='submit' value='Добавить'/></form></center></div>";
}
if (!$is_user){
echo "<form action='?ok' method='post'>";
echo "<div class='apicms_dialog'><center><textarea name='txt'></textarea><br />";
echo '<img src="/captcha.php?'.rand(100, 999).'" width="50" height="27"  alt="captcha" />
<input name="code" type="text" maxlength="3" size="15" /><br/>';
echo "<input type='submit' value='Добавить'/></form></center></div>";
}
/////////////////////////////////////////
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sceditor@3/minified/themes/default.min.css" />';
echo '<script src="https://cdn.jsdelivr.net/npm/sceditor@3/minified/sceditor.min.js"></script>';
echo '<script src="https://cdn.jsdelivr.net/npm/sceditor@3/minified/formats/bbcode.min.js"></script>';
echo '<script>(function(){ var areas = document.querySelectorAll("textarea[name=\'txt\']"); if(areas && areas.length){ areas.forEach(function(textarea){ try { sceditor.create(textarea, { format: "bbcode", style: "https://cdn.jsdelivr.net/npm/sceditor@3/minified/themes/content/default.min.css" }); } catch(e){} }); } })();</script>';
/////////////////////////////////////////
if ($k_page > 1){
echo '<div class="apicms_subhead"><center>';
str('?',$k_page,$page); // генерируем постраничную навигацию
echo '</center></div>';
}
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>
