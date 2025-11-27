<?


////////////////////////////////////////
$title = 'Тестирование системы';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
////////////////////////////////////////
echo '<div class="apicms_subhead">';
echo "Версия APICMS: $set[api_v] <br />\n";
////////////////////////////////////////
list ($php_ver1,$php_ver2,$php_ver3)=explode('.', strtok(strtok(phpversion(),'-'),' '), 3);
////////////////////////////////////////
if ($php_ver1==5){
echo "<span class='on'>Версия PHP: $php_ver1.$php_ver2.$php_ver3 (хорошо)</span><br />\n";
}else{
echo "<span class='off'>Версия PHP: $php_ver1.$php_ver2.$php_ver3</span><br />\n";
echo "Тестирование на версии php $php_ver1.$php_ver2.$php_ver3 не осуществялось";
}
////////////////////////////////////////
if (function_exists('set_time_limit'))echo "<span class='on'>set_time_limit: хорошо</span><br />\n";
else echo "<span class='on'>set_time_limit: Запрещено</span><br />\n";
////////////////////////////////////////
if (ini_get('session.use_trans_sid')==true){
echo "<span class='on'>session.use_trans_sid: хорошо</span><br />\n";
}else{
echo "<span class='off'>session.use_trans_sid: Нет</span><br />\n";
echo 'Будет теряться сессия на браузерах без поддержки COOKIE</br>';
echo 'Добавьте в корневой .htaccess строку <b>php_value session.use_trans_sid 1</b></br>';
}
////////////////////////////////////////
if (ini_get('magic_quotes_gpc')==0){
echo "<span class='on'>magic_quotes_gpc: 0 (хорошо)</span><br />\n";
}else{
echo "<span class='off'>magic_quotes_gpc: Включено</span><br />\n";
echo 'Включено экранирование кавычек</br>';
echo 'Добавьте в корневой .htaccess строку <b>php_value magic_quotes_gpc 0</b></br>';
}
////////////////////////////////////////
if (ini_get('arg_separator.output')=='&amp;'){
echo "<span class='on'>arg_separator.output: &amp;amp; (хорошо)</span><br />\n";
}else{
echo "<span class='off'>arg_separator.output: ".ini_get('arg_separator.output')."</span><br />\n";
echo 'Возможно появление ошибки xml</br>';
echo 'Добавьте в корневой .htaccess строку <b>php_value arg_separator.output &amp;amp;</b></br>';
}
////////////////////////////////////////
if (file_exists(H.'install/mod_rewrite_test.php')){
if (@trim(file_get_apicms_contents("http://$_SERVER[HTTP_HOST]/install/mod_rewrite.test"))=='mod_rewrite-ok') {
echo "<span class='on'>mod_rewrite: хорошо</span><br />\n";
}
elseif(function_exists('apache_get_modules'))
{
$apache_mod=@apache_get_modules();
////////////////////////////////////////
if (array_search('mod_rewrite', $apache_mod)) {
echo "<span class='on'>mod_rewrite: хорошо</span><br />\n";
}else{
echo "<span class='off'>mod_rewrite: Нет</span><br />\n";
echo 'Необходима поддержка mod_rewrite';
}
}else{
echo "<span class='off'>mod_rewrite: Нет</span><br />\n";
echo 'Необходима поддержка mod_rewrite';
}
}
elseif(function_exists('apache_get_modules'))
{
$apache_mod=@apache_get_modules();
if (array_search('mod_rewrite', $apache_mod)) {
echo "<span class='on'>mod_rewrite: хорошо</span><br />\n";
}else{
echo "<span class='off'>mod_rewrite: Нет</span><br />\n";
echo 'Необходима поддержка mod_rewrite';
}
}else{
echo "<span class='off'>mod_rewrite: Нет данных</span><br />\n";
}
////////////////////////////////////////
if (function_exists('imagecreatefromstring') && function_exists('gd_info')){
$gdinfo=gd_info();
echo "<span class='on'>GD: ".$gdinfo['GD Version']." хорошо</span><br />\n";
}else{
echo "<span class='off'>GD: Нет</span><br />\n";
echo 'GD необходима для корректной работы движка';
}
////////////////////////////////////////
if (function_exists('mysqli_info')){
echo "<span class='on'>MySQLi: хорошо</span><br />\n";
}else{
echo "<span class='off'>MySQLi: Нет</span><br />\n";
echo 'Без MySQLi работа не возможна';
}
////////////////////////////////////////
if (function_exists('iconv')){
echo "<span class='on'>Iconv: хорошо</span><br />\n";
}else{
echo "<span class='off'>Iconv: Нет</span><br />\n";
echo 'Без Iconv работа не возможна';
}
////////////////////////////////////////
if (class_exists('ffmpeg_movie')){
echo "<span class='on'>FFmpeg: хорошо</span><br />\n";
}else{
echo "<span class='on'>FFmpeg: Нет</span><br />\n";
echo "* Без FFmpeg автоматическое создание скриношотов к видео недоступно<br />\n";
}
////////////////////////////////////////
if (ini_get('register_globals')==false){
echo "<span class='on'>register_globals off: хорошо</span><br />\n";
}else{
echo "<span class='off'>register_globals on: !!!</span><br />\n";
echo 'register_globals включен. Грубое нарушение безопасности';
}
////////////////////////////////////////
if (function_exists('mcrypt_cbc')){
echo "<span class='on'>Шифрование COOKIE: хорошо</span><br />\n";
}else{
echo "<span class='on'>Шифрование COOKIE: нет</span><br />\n";
echo "* mcrypt не доступен<br />\n";
}
echo '</div>';
///////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>