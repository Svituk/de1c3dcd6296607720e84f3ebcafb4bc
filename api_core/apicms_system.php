<?php

session_start();
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', true);
ini_set('html_errors', true);
ini_set('error_reporting', E_ALL ^ E_NOTICE);
////////////////////////////////////////////////////////////////
include_once 'api_connect.php';
////////////////////////////////////////////////////////////////
// авторизация на сервере базы
$db = @mysqli_connect(DBHOST, DBUSER, DBPASS);
if(!$db){
echo '<style>a, a:link, a:active, a:visited { color: #39728a; text-decoration: none; } a:hover { text-decoration: none; } body { background: #8ec1da url(/design/styles/default/style_images/bg.jpg) fixed; margin: 0 auto; max-width: 700px; font-size: 13px; color: #16223b; font-family: Arial; }.erors { color: #ffffff; padding:7px; background-color: #CC1559; text-align: center; border-top: 1px #ffffff solid; border-bottom: 1px #e8e8ea solid; display: block; }.apicms_menu{ background: #5790a1; color: #fff; padding: 10px; border-top: 1px solid #437e8f; border-bottom: 1px solid #6da1b0; }.apicms_comms { color: #39728a; padding:7px; background-color: #f5f5f5; border-top: 1px #ffffff solid; border-bottom: 1px #e8e8ea solid; display: block; }.loghead { padding: 12px; font-size: 12px; color: #ffffff; text-decoration: none; background: #326c85 url(/design/styles/default/style_images/foothover.gif) no-repeat top; } </style>';
echo '<title>APICMS - Система управления сайтом</title>';
echo '<div class=apicms_menu>Нет соединения с сервером базы!</div>
<div class=apicms_comms>Возможно на вашем хостинге локальный сервер базы данных не соответствует значению "localhost" уточните значение вашего сервера базы данных в хостинг-провайдера!</div>
<div class=apicms_comms>Так же возможно вы допустили ошибку при вводе данных базы. Проверьте еще раз точность введенных данных.</div>';
if (file_exists(''.$_SERVER['DOCUMENT_ROOT'].'/install/')){
echo '<div class=apicms_menu>Действие</div><a class="apicms_comms" href=/install/> Перейти к установке ApiCMS.</a>';
}echo"<div class=loghead><center><small><a href=http://apicms.ru><font color=FFFFFF> <strong>Управление сайтом ApiCMS</strong></font></a></small></center></div>";exit;}
if (!@mysqli_select_db($db, DBNAME)){
echo '<style>a, a:link, a:active, a:visited { color: #39728a; text-decoration: none; } a:hover { text-decoration: none; } body { background: #8ec1da url(/design/styles/default/style_images/bg.jpg) fixed; margin: 0 auto; max-width: 700px; font-size: 13px; color: #16223b; font-family: Arial; }.erors { color: #ffffff; padding:7px; background-color: #CC1559; text-align: center; border-top: 1px #ffffff solid; border-bottom: 1px #e8e8ea solid; display: block; }.apicms_menu{ background: #5790a1; color: #fff; padding: 10px; border-top: 1px solid #437e8f; border-bottom: 1px solid #6da1b0; }.apicms_comms { color: #39728a; padding:7px; background-color: #f5f5f5; border-top: 1px #ffffff solid; border-bottom: 1px #e8e8ea solid; display: block; }.loghead { padding: 12px; font-size: 12px; color: #ffffff; text-decoration: none; background: #326c85 url(/design/styles/default/style_images/foothover.gif) no-repeat top; } </style>';
echo '<title>APICMS - Система управления сайтом</title>';
echo '<div class=apicms_menu>Нет соединения с базой данных!</div>
<div class=apicms_comms>Вы допустили ошибку при вводе пользователя базы данных!</div> <div class=apicms_comms>Пожалуйста проверьте правильность введенных вами данных</div>';
if (file_exists(''.$_SERVER['DOCUMENT_ROOT'].'/install/')){
echo '<div class=apicms_menu>Действие</div><a class="apicms_comms" href=/install/> Перейти к установке ApiCMS.</a>';
}echo"<div class=loghead><center><small><a href=http://apicms.ru><font color=FFFFFF> <strong>Управление сайтом ApiCMS</strong></font></a></small></center></div>";exit;}

$connect = mysqli_connect(DBHOST, DBUSER, DBPASS) or die('Ошибка подключения, к пользователю Базы данных MySQL, либо не верно введен пароль! Проверьте параметры подключения!');
mysqli_set_charset($connect, 'utf8');
mysqli_select_db($connect, DBNAME) or die('Ошибка подключения к Базе данных MySQL! Проверьте параметры подключения!');
/////////////////////////////////// общий фильтр
function apicms_filter($check){
global $connect;
if (!is_string($check)){
    if ($check === null) $check = '';
    else $check = strval($check);
}
$check = mysqli_real_escape_string($connect, $check);
$check = htmlspecialchars($check, ENT_QUOTES, 'UTF-8');
$search = array('|', '\'', '$', '\\', '^', '%', '`', "\0", "\x00", "\x1A", "\x0a", "\x0d", "\x1a");
$replace = array('&#124;', '&#39;', '&#36;', '&#92;', '&#94;', '&#37;', '&#96;', '', '', '', '', '', '');
$check = str_replace($search, $replace, $check);
$check = trim($check);
return $check;
}
////////////////////////////////////////делаем переменную с настройками
$api_settings = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `settings`"));
///////////////////////////////////
// initialize cookie vars to avoid undefined variable warnings
$userlogin = '';
$userpass = '';
if (isset($_COOKIE['userlogin']) && isset($_COOKIE['userpass'])) {
    $userlogin = apicms_filter($_COOKIE['userlogin']);
    $userpass = apicms_filter($_COOKIE['userpass']);
}
///////////////////////////////////
// fetch user by cookie credentials (if provided)
$query = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '".mysqli_real_escape_string($connect, $userlogin)."' and `pass` = '".mysqli_real_escape_string($connect, $userpass)."' LIMIT 1");
$user = mysqli_fetch_assoc($query);
// if cookies were present but no matching user found, clear the cookies
if (($userlogin !== '' || $userpass !== '') && !$user){
    setcookie('userlogin', '', time() - 86400*31, '/');
    setcookie('userpass', '', time() - 86400*31, '/');
}
// Ensure $user is always defined (avoid "array offset on null" warnings)
if (!$user) {
    $user = array();
}
// Convenience flags to check user state safely across includes
$is_user = !empty($user) && isset($user['id']);
$user_level = $is_user && isset($user['level']) ? intval($user['level']) : 0;
$user_id = $is_user && isset($user['id']) ? intval($user['id']) : 0;
///////////////////////////////////
$set['api_v'] = '3.0';               // определяем версию CMS
$set['site'] = $_SERVER['HTTP_HOST'];       // определяем сайт
$time = time();                             // создаем переменную на время
$ip = $_SERVER['REMOTE_ADDR'];              // определяем ip
define("H", $_SERVER["DOCUMENT_ROOT"].'/'); // домашний каталог
///////////////////////////////////

if (!empty($user) && !empty($user['id'])){
    $api_design = $user['style'];
}else{
    $api_design = $api_settings['style'];
}
// дополнительная проверка $_GET
foreach ($_GET as $check_url) {
if (!is_string($check_url) || !preg_match('#^(?:[a-z0-9_\-/]+|\.+(?!/))*$#i', $check_url)) {
header ('Location: ../');
exit;
} 
} 
unset($check_url);
/////////////////////////////////// блокировка пользователя
if (isset($user['id']) && $user['block_time']>=time() && $_SERVER['PHP_SELF']!='/block.php'){
header ('Location: /block.php');
exit();
}
/////////////////////////////////// Анти Gues say

if (!isset($user['id']) && $_SERVER['PHP_SELF']!='/auth.php' && $_SERVER['PHP_SELF']!='/login.php' && $_SERVER['PHP_SELF']!='/lost_pass.php' && $_SERVER['PHP_SELF']!='/reg.php' && $_SERVER['PHP_SELF']!='/guest/index.php'){
unset($_POST);
}

/////////////////////////////////// активация почты пользователя отключена

if ($api_settings['open_guest']==0){
/////////////////////////////////// закрываем доступ гостям
if (!isset($user['id']) && $_SERVER['PHP_SELF']!='/index.php' && $_SERVER['PHP_SELF']!='/auth.php' && $_SERVER['PHP_SELF']!='/login.php' && $_SERVER['PHP_SELF']!='/lost_pass.php' && $_SERVER['PHP_SELF']!='/err.php' && $_SERVER['PHP_SELF']!='/captcha.php' && $_SERVER['PHP_SELF']!='/reg.php' && $_SERVER['PHP_SELF']!='/install/index.php' && $_SERVER['PHP_SELF']!='/install/install.php' && $_SERVER['PHP_SELF']!='/install/ok.php'){
header ('Location: /index.php');
exit();
}
}
/////////////////////////////////// функция переноса строк
function apicms_br($br){
$br=str_replace(array("\r\n","\n","\r","\\r\\n","&#92;r&#92;n","&#92;n","&#92;r","&amp;#92;r&amp;#92;n","&amp;#92;n","&amp;#92;r"),"<br />",$br);
return $br;
}
/////////////////////////////////// функция обработки BB-code
function apicms_bb_code($msg){
  // Protect and render [code] blocks first: preserve content, prevent further BBCode parsing inside
  $msg = preg_replace_callback('#\[code\](.*?)\[/code\]#si', function($m){
    $content = $m[1];
    // Convert any HTML-inserted line breaks back to newlines inside code
    $content = str_replace(array('<br />','</br>','<br/>','<br>'), "\n", $content);
    // Decode specific HTML entities produced by apicms_filter so code looks natural
    $content = str_replace(
      array('&amp;#36;','&#36;','&amp;#92;','&#92;','&amp;#092;','&#092;','&amp;#124;','&#124;','&amp;#39;','&#39;','&amp;#039;','&#039;','&amp;#94;','&#94;','&amp;#37;','&#37;','&amp;#96;','&#96;'),
      array('$','$','\\','\\','\\','\\','|','|','\'','\'','\'','\'','^','^','%','%','`','`'),
      $content
    );
    // Decode double-encoded common entities so they render as single-escaped in HTML
    $content = str_replace(
      array('&amp;lt;','&amp;gt;','&amp;quot;','&amp;amp;'),
      array('&lt;','&gt;','&quot;','&amp;'),
      $content
    );
    // Prevent other BBCode replacements inside code by escaping square brackets
    $content = str_replace(['[',']'], ['&#91;','&#93;'], $content);
    return '<pre><code>'.$content.'</code></pre>';
  }, $msg);
  $msg = preg_replace('#\[big\](.*?)\[/big\]#si', '<big>\1</big>', $msg);
  $msg = preg_replace('#\[b\](.*?)\[/b\]#si', '<b>\1</b>', $msg);
  $msg = preg_replace('#\[i\](.*?)\[/i\]#si', '<i>\1</i>', $msg);
  $msg = preg_replace('#\[u\](.*?)\[/u\]#si', '<u>\1</u>', $msg);
  $msg = preg_replace('#\[s\](.*?)\[/s\]#si', '<s>\1</s>', $msg);
  $msg = preg_replace('#\[sub\](.*?)\[/sub\]#si', '<sub>\1</sub>', $msg);
  $msg = preg_replace('#\[sup\](.*?)\[/sup\]#si', '<sup>\1</sup>', $msg);
  $msg = preg_replace('#\[small\](.*?)\[/small\]#si', '<small>\1</small>', $msg);
  $msg = preg_replace('#\[img\](.*?)\[/img\]#si', '<a href="\1"><img src="\1" width="100px"></a>', $msg);
  $msg = preg_replace('#\[red\](.*?)\[/red\]#si', '<span style="color:#ff0000">\1</span>', $msg);
  $msg = preg_replace('#\[green\](.*?)\[/green\]#si', '<span style="color:#00cc00">\1</span>', $msg);
  $msg = preg_replace('#\[blue\](.*?)\[/blue\]#si', '<span style="color:#0000ff">\1</span>', $msg);
  $msg = preg_replace('#\[yellow\](.*?)\[/yellow\]#si', '<span style="color:#FFFF00">\1</span>', $msg);
  $msg = preg_replace('#\[color=([^\]]+)\](.*?)\[/color\]#si', '<span style="color:\1">\2</span>', $msg);
  $msg = preg_replace_callback('#\[size=([0-9]{1,2})\](.*?)\[/size\]#si', function($m){
    $map = array(1=>'10px',2=>'12px',3=>'14px',4=>'16px',5=>'18px',6=>'24px',7=>'32px');
    $sz = intval($m[1]);
    $px = isset($map[$sz]) ? $map[$sz] : ($sz.'px');
    return '<span style="font-size:'.$px.'">'.$m[2].'</span>';
  }, $msg);
  $msg = preg_replace('#\[font=([^\]]+)\](.*?)\[/font\]#si', '<span style="font-family:\1">\2</span>', $msg);
  $msg = preg_replace('#\[center\](.*?)\[/center\]#si', '<div style="text-align:center">\1</div>', $msg);
  $msg = preg_replace('#\[left\](.*?)\[/left\]#si', '<div style="text-align:left">\1</div>', $msg);
  $msg = preg_replace('#\[right\](.*?)\[/right\]#si', '<div style="text-align:right">\1</div>', $msg);
  $msg = preg_replace('#\[justify\](.*?)\[/justify\]#si', '<div style="text-align:justify">\1</div>', $msg);
  $msg = preg_replace('#\[align=(left|right|center|justify)\](.*?)\[/align\]#si', '<div style="text-align:\1">\2</div>', $msg);
  $msg = preg_replace('#\[quote\](.*?)\[/quote\]#si', '<blockquote>\1</blockquote>', $msg);
  $msg = preg_replace('#\[quote=("|\'|)(.*?)\1\](.*?)\[/quote\]#si', '<blockquote>\3</blockquote>', $msg);
  $msg = str_replace('[hr]', '<hr/>', $msg);
  $msg = preg_replace('#\[email\](.*?)\[/email\]#si', '<a href="mailto:\1">\1</a>', $msg);
  $msg = preg_replace('#\[ul\](.*?)\[/ul\]#si', '<ul>\1</ul>', $msg);
  $msg = preg_replace('#\[ol\](.*?)\[/ol\]#si', '<ol>\1</ol>', $msg);
  $msg = preg_replace('#\[li\](.*?)\[/li\]#si', '<li>\1</li>', $msg);
  $msg = preg_replace('#\[list\](.*?)\[/list\]#si', '<ul>\1</ul>', $msg);
  $msg = preg_replace('#\[\*\]#si', '<li>', $msg);
  $msg = preg_replace('#\[table\](.*?)\[/table\]#si', '<table>\1</table>', $msg);
  $msg = preg_replace('#\[tr\](.*?)\[/tr\]#si', '<tr>\1</tr>', $msg);
  $msg = preg_replace('#\[th\](.*?)\[/th\]#si', '<th>\1</th>', $msg);
  $msg = preg_replace('#\[td\](.*?)\[/td\]#si', '<td>\1</td>', $msg);
  $msg = preg_replace('#\[youtube\]([A-Za-z0-9_-]{11})\[/youtube\]#si', '<div class="video"><iframe src="https://www.youtube.com/embed/\1" width="560" height="315" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>', $msg);
  $msg = preg_replace('#\[youtube=([A-Za-z0-9_-]{11})\](.*?)\[/youtube\]#si', '<div class="video"><iframe src="https://www.youtube.com/embed/\1" width="560" height="315" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>', $msg);
  $msg = preg_replace_callback('#\[youtube\](.*?)\[/youtube\]#si', function($m){
    $u = trim($m[1]);
    $id = '';
    if (preg_match('#youtu\.be/([A-Za-z0-9_-]{11})#i', $u, $mm)) $id = $mm[1];
    elseif (preg_match('#[?&]v=([A-Za-z0-9_-]{11})#i', $u, $mm)) $id = $mm[1];
    elseif (preg_match('#/embed/([A-Za-z0-9_-]{11})#i', $u, $mm)) $id = $mm[1];
    if ($id) return '<div class="video"><iframe src="https://www.youtube.com/embed/'.$id.'" width="560" height="315" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';
    return $m[0];
  }, $msg);
  $msg = preg_replace('#\[q\](.*?)\[/q\]#si', '<div class="quote">\1</div>', $msg);
  $msg = preg_replace('#\[del\](.*?)\[/del\]#si', '<del>\1</del>', $msg);
  $msg = preg_replace('#\[url=("|\'|)(.*?)("|\'|)\](.*?)\[/url\]#si', '<a href="$2">$4</a>', $msg);
  $msg = preg_replace('#\[url\](.*?)\[/url\]#si', '<a href="$1">$1</a>', $msg);
  return $msg;
}
/////////////////////////////////// функция генерации
function apicms_generate($number){
$arr = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','r','s','t','u','v','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','R','S','T','U','V','X','Y','Z','1','2','3','4','5','6','7','8','9','0');  
// Генерируем пароль  
$pass = '';  
for($i = 0; $i < $number; $i++){
// Вычисляем случайный индекс массива
$index = rand(0, count($arr) - 1);
$pass .= $arr[$index];  
}
return $pass;  
}
/////////////////////////////////// функция формирования постраничной навигации
function page($k_page=1){ // Выдает текущую страницу
$page=1;
if (isset($_GET['page'])){
if ($_GET['page']=='end')$page=intval($k_page);elseif(is_numeric($_GET['page'])) $page=intval($_GET['page']);}
if ($page<1)$page=1;
if ($page>$k_page)$page=$k_page;
return $page;}

function k_page($k_post=0,$k_p_str=10){ // Высчитывает количество страниц
if ($k_post!=0){$v_pages=ceil($k_post/$k_p_str);return $v_pages;}
else return 1;}
///////////////////////////////////
function str($link='?',$k_page=1,$page=1){ // Вывод номеров страниц (только на первый взгляд кажется сложно ;))
if ($page<1)$page=1;
if ($page>1)echo " <a href=\"".$link."page=".($page-1)."\" title='Предыдущая страница (№".($page-1).")'>назад</a> ";
if ($page!=1)echo "<a href=\"".$link."page=1\" title='Страница №1'>1</a>";else echo "<b>1</b>";
for ($ot=-1; $ot<=1; $ot++){
if ($page+$ot>1 && $page+$ot<$k_page){
if ($ot==-1 && $page+$ot>2)echo " ..";
if ($ot!=0)echo " <a href=\"".$link."page=".($page+$ot)."\" title='Страница №".($page+$ot)."'>".($page+$ot)."</a>";else echo " <b>".($page+$ot)."</b>";
if ($ot==1 && $page+$ot<$k_page-1)echo " ..";}}
if ($page!=$k_page)echo " <a href=\"".$link."page=end\" title='Страница №$k_page'>$k_page</a>";elseif ($k_page>1)echo " <b>$k_page</b>";
echo " ";
if ($page<$k_page)echo " <a href=\"".$link."page=".($page+1)."\" title='Следующая страница (№".($page+1).")'>вперед</a> ";
}
///////////////////////////////////// вывод времени с возможностью под сдвиг временной под часовые пояса (по надобности)
function apicms_data($time=NULL){
if ($time==NULL)$time=time();
if (isset($user))$time=$time+$user['set_timesdvig']*60*60;
$timep="".date("jMY в H:i", $time)."";
$time_p[0]=date("jnY", $time);
$time_p[1]=date("H:i", $time);
if ($time_p[0]==date("jnY"))$timep=date("H:i:s", $time);
if (isset($user)){
if ($time_p[0]==date("jnY", time()+$user['set_timesdvig']*60*60))$timep=date("H:i:s", $time);
if ($time_p[0]==date("jnY", time()-60*60*(24-$user['set_timesdvig'])))$timep="Вчера в $time_p[1]";}
else{
if ($time_p[0]==date("jnY"))$timep=date("H:i:s", $time);
if ($time_p[0]==date("jnY", time()-60*60*24))$timep="Вчера в $time_p[1]";}
$timep=str_replace("Jan",".01.",$timep);
$timep=str_replace("Feb",".02.",$timep);
$timep=str_replace("Mar",".03.",$timep);
$timep=str_replace("May",".04.",$timep);
$timep=str_replace("Apr",".05.",$timep);
$timep=str_replace("Jun",".06.",$timep);
$timep=str_replace("Jul",".07.",$timep);
$timep=str_replace("Aug",".08.",$timep);
$timep=str_replace("Sep",".09.",$timep);
$timep=str_replace("Oct",".10.",$timep);
$timep=str_replace("Nov",".11.",$timep);
$timep=str_replace("Dec",".12.",$timep);
return $timep;
}
//////////////////////////////////////// функция обработки смайлов
function apicms_smiles($msg){
global $connect;
$q=mysqli_query($connect, "SELECT * FROM `smiles_list`");
while($post = mysqli_fetch_array($q)){
$msg = str_replace($post['sim'], '<img src="/design/smiles/'.$post['name'].'.gif" alt="'.$post['name'].'"/>', $msg);
}
return $msg;
}
//////////////////////////////////////// функция вывода браузера
function browser() {
    $ua = $_SERVER['HTTP_USER_AGENT'];

    if (stripos($ua, 'Edg') !== false) return 'Edge';              // Microsoft Edge
    elseif (stripos($ua, 'Firefox') !== false) return 'Firefox';   // Mozilla Firefox
    elseif (stripos($ua, 'Chrome') !== false && stripos($ua, 'Chromium') === false) return 'Chrome'; // Google Chrome
    elseif (stripos($ua, 'Safari') !== false && stripos($ua, 'Chrome') === false) return 'Safari';   // Apple Safari
    elseif (stripos($ua, 'OPR') !== false || stripos($ua, 'Opera') !== false) return 'Opera';        // Opera
    elseif (stripos($ua, 'SamsungBrowser') !== false) return 'Samsung Browser'; // Samsung Internet
    elseif (stripos($ua, 'UCBrowser') !== false) return 'UCBrowser';    // UC Browser
    elseif (stripos($ua, 'YaBrowser') !== false) return 'Yandex';       // Яндекс.Браузер
    else return 'unknown';
}

function agent($user){
global $connect;
$user_result = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '".mysqli_real_escape_string($connect, $user)."'"));
if ($user_result['browser']=='firefox' || $user_result['browser']=='chrome' || $user_result['browser']=='safari' || $user_result['browser']=='opera' || $user_result['browser']=='ie6' || $user_result['browser']=='ie7' || $user_result['browser']=='ie8'){
$user = ' <img src="/images/device_pc.png" alt="PC"> ';
}else{
$user = ' <img src="/images/device_mobile.png" alt="Моб."> ';
}
return $user;
}


/////////////////////////////////// функция обработки операционной системы + поисковые системы
function getOS($userAgent) {
    $oses = array(
        // 📱 Мобильные ОС
        'iOS' => '(iPhone|iPad|iPod)',
        'Android' => '(Android)',
        'HarmonyOS' => '(HarmonyOS)', // Huawei
        'KaiOS' => '(KaiOS)',

        // 💻 Windows
        'Windows 11' => '(Windows NT 10.0; Win64; x64)',
        'Windows 10' => '(Windows NT 10.0)',
        'Windows 8.1' => '(Windows NT 6.3)',
        'Windows 8' => '(Windows NT 6.2)',
        'Windows 7' => '(Windows NT 6.1)',
        'Windows Vista' => '(Windows NT 6.0)',
        'Windows XP' => '(Windows NT 5.1|Windows XP)',

        // 🍎 Apple
        'macOS' => '(Macintosh|Mac OS X)',
        'iPadOS' => '(iPad)',

        // 🐧 Linux и Unix
        'Linux' => '(Linux)',
        'Ubuntu' => '(Ubuntu)',
        'Debian' => '(Debian)',
        'Fedora' => '(Fedora)',
        'Red Hat' => '(Red Hat)',
        'OpenBSD' => '(OpenBSD)',
        'FreeBSD' => '(FreeBSD)',
        'Solaris' => '(SunOS)',

        // 🤖 Устройства
        'PlayStation' => '(PlayStation)',
        'Xbox' => '(Xbox)',
        'Nintendo Switch' => '(Nintendo Switch)',
        'SmartTV' => '(SmartTV|Tizen|WebOS)',

        // 🔍 Поисковые боты
        'Googlebot' => '(Googlebot)',
        'Bingbot' => '(bingbot)',
        'YandexBot' => '(Yandex)',
        'DuckDuckBot' => '(DuckDuckBot)',
        'Baiduspider' => '(Baiduspider)',
        'Yahoo! Slurp' => '(Slurp)',
        'Applebot' => '(Applebot)'
    );

    foreach($oses as $os=>$pattern){
        if(preg_match('/'.$pattern.'/i', $userAgent)) {
            return $os;
        }
    }
    return 'Unknown';
}

$oc = getOS($_SERVER['HTTP_USER_AGENT']);


/////////////////////////////////// #64х64 ава
function avatar_path($id_user){
global $ava;
$ava = glob($_SERVER['DOCUMENT_ROOT'].'/files/ava/'.$id_user.'*');
if ($ava){
    $full = $ava[0];
    $rel = str_replace($_SERVER['DOCUMENT_ROOT'],'',$full);
    $ts = @filemtime($full);
    return $ts ? ($rel.'?v='.$ts) : $rel;
}
return false;
}
///////////////////////////////////
function apicms_ava64($users) {
$ava = avatar_path($users);
if ($ava){
echo '<img src="'.$ava.'" alt=""  width="128" height="128"/>';
}else{
#если ава не загружена то выводим эту
echo '<img src="/files/ava/0.png" width="128" height="128">';
}
}
///////////////////////////////////
function apicms_ava32($users) {
$ava = avatar_path($users);
if ($ava){
echo '<img src="'.$ava.'" alt=""  width="50" height="50"/>';
}else{
#если ава не загружена то выводим эту
echo '<img src="/files/ava/0.png" width="50" height="50">';
}
}
///////////////////////////////////
function apicms_ava40($users) {
$ava = avatar_path($users);
if ($ava){
echo '<img src="'.$ava.'" alt=""  width="40" height="40"/>';
}else{
#если ава не загружена то выводим эту
echo '<img src="/files/ava/0.png" width="40" height="40">';
}
}
///////////////////////////////////
#Вывод ошибок
function apicms_error($var){
    // Buffer errors so they don't produce output before headers are sent.
    global $apicms_errors;
    if (!isset($apicms_errors) || !is_array($apicms_errors)) $apicms_errors = array();
    if (!empty($var)) $apicms_errors[] = $var;
}

function status($user){
global $connect;
$user_escaped = mysqli_real_escape_string($connect, $user);
$result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `users` WHERE `id` = '$user_escaped' AND `activity` > '".(time()-600)."' LIMIT 1");
$row = mysqli_fetch_assoc($result);
if ($row['cnt']==1){
$user = ' онлайн ';
}else{
$user = ' оффлайн ';
}
return $user;
}

?>
