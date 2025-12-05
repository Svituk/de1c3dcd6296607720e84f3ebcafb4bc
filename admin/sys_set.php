<?


////////////////////////////////////////
$title = 'Настройки системы';
require_once '../api_core/apicms_system.php';
if (!function_exists('apicms_ob_started')){ ob_start(); function apicms_ob_started(){} }
require_once '../design/styles/'.display_html($api_design).'/head.php';
////////////////////////////////////////
if ($user['level'] != 1) header('location: ../');
if ($user['level'] == 1){
////////////////////////////////////////
$my_sets = isset($_POST['set_theme']) ? apicms_filter($_POST['set_theme']) : (isset($api_settings['style']) ? $api_settings['style'] : 'default');
/////////////////////////////////////////
global $connect;
if (isset($_POST['save']) && csrf_check()){
if (isset($_POST['set_theme']) && preg_match('#^([A-z0-9\-_\(\)]+)$#ui', $_POST['set_theme']) && is_dir(H.'design/styles/'.$_POST['set_theme'])){
mysqli_query($connect, "UPDATE `settings` SET `style` = '$my_sets' LIMIT 1");
}
/////////////////////////////////////////
if (isset($_POST['email']) && preg_match('/[0-9a-z_\-]+@[0-9a-z_\-^\.]+\.[a-z]{2,6}/i', $_POST['email'])){
$mailus = apicms_filter($_POST['email']);
mysqli_query($connect, "UPDATE `settings` SET `adm_mail` = '$mailus' LIMIT 1");
}
/////////////////////////////////////////
if (isset($_POST['title']) && preg_match('/[A-zА-я0-9 _\-\=\+\(\)\*\?\.,]/i', $_POST['title'])){
$titleus = apicms_filter($_POST['title']);
mysqli_query($connect, "UPDATE `settings` SET `title` = '$titleus' LIMIT 1");
}
/////////////////////////////////////////
if (isset($_POST['Description']) && preg_match('/[A-zА-я0-9 _\-\=\+\(\)\*\?\.,]/i', $_POST['Description'])){
$Descriptionus = apicms_filter($_POST['Description']);
mysqli_query($connect, "UPDATE `settings` SET `Description` = '$Descriptionus' LIMIT 1");
}
/////////////////////////////////////////
if (isset($_POST['Keywords']) && preg_match('/[A-zА-я0-9 _\-\=\+\(\)\*\?\.,]/i', $_POST['Keywords'])){
$Keywordsus = apicms_filter($_POST['Keywords']);
mysqli_query($connect, "UPDATE `settings` SET `Keywords` = '$Keywordsus' LIMIT 1");
}
/////////////////////////////////////////
if (isset($_POST['revisit']) && preg_match('/[A-zА-я0-9 _\-\=\+\(\)\*\?\.,]/i', $_POST['revisit'])){
$revisitus = apicms_filter($_POST['revisit']);
mysqli_query($connect, "UPDATE `settings` SET `revisit` = '$revisitus' LIMIT 1");
}
/////////////////////////////////////////
if (isset($_POST['fishka']) && preg_match('/[A-zА-я0-9 _\-\=\+\(\)\*\?\.,]/i', $_POST['fishka'])){
$fishkaus = apicms_filter($_POST['fishka']);
mysqli_query($connect, "UPDATE `settings` SET `fishka_chat` = '$fishkaus' LIMIT 1");
}
/////////////////////////////////////////
if (isset($_POST['fishka_mail']) && preg_match('/[A-zА-я0-9 _\-\=\+\(\)\*\?\.,]/i', $_POST['fishka_mail'])){
$fishka_mailus = apicms_filter($_POST['fishka_mail']);
mysqli_query($connect, "UPDATE `settings` SET `fishka_mail` = '$fishka_mailus' LIMIT 1");
}
/////////////////////////////////////////
if (isset($_POST['fishka_n_comm']) && preg_match('/[A-zА-я0-9 _\-\=\+\(\)\*\?\.,]/i', $_POST['fishka_n_comm'])){
$fishka_n_commus = apicms_filter($_POST['fishka_n_comm']);
mysqli_query($connect, "UPDATE `settings` SET `fishka_n_comm` = '$fishka_n_commus' LIMIT 1");
}
/////////////////////////////////////////
if (isset($_POST['page']) && preg_match('/[A-zА-я0-9 _\-\=\+\(\)\*\?\.,]/i', $_POST['page'])){
$pageus = apicms_filter($_POST['page']);
mysqli_query($connect, "UPDATE `settings` SET `on_page` = '$pageus' LIMIT 1");
}
/////////////////////////////////////////
if (isset($_POST['set_reg']) && ($_POST['set_reg']==1 || $_POST['set_reg']==0)){
$set_reg = intval($_POST['set_reg']);
mysqli_query($connect, "UPDATE `settings` SET `reg` = '$set_reg' LIMIT 1");
}
/////////////////////////////////////////
if (isset($_POST['set_open_guest']) && ($_POST['set_open_guest']==1 || $_POST['set_open_guest']==0)){
$set_open_guest = intval($_POST['set_open_guest']);
mysqli_query($connect, "UPDATE `settings` SET `open_guest` = '$set_open_guest' LIMIT 1");
}
/////////////////////////////////////////
if (isset($_POST['set_news']) && ($_POST['set_news']==1 || $_POST['set_news']==0)){
$set_news = intval($_POST['set_news']);
mysqli_query($connect, "UPDATE `settings` SET `news_main` = '$set_news' LIMIT 1");
}
/////////////////////////////////////////
if (isset($_POST['set_diz']) && ($_POST['set_diz']==1 || $_POST['set_diz']==0)){
$set_diz = intval($_POST['set_diz']);
mysqli_query($connect, "UPDATE `settings` SET `set_diz` = '$set_diz' LIMIT 1");
}
/////////////////////////////////////////
echo '<div class="apicms_content"><center>Новые настройки системы приняты</center></div>';
}
////////////////////////////////////////
echo "<form method='post' action='?ok'>\n";
echo '<div class="apicms_subhead">';
echo "Оформление для гостя <br /><select name='set_theme'>\n";
$opendirthem=opendir(H.'design/styles');
while ($themes_set=readdir($opendirthem)){
if ($themes_set=='.' || $themes_set=='..' || !is_dir(H."design/styles/$themes_set"))continue;
echo "<option value='".$themes_set."'>".display_html(trim(@file_get_contents(H.'design/styles/'.$themes_set.'/them.name')))."</option>\n";
}
closedir($opendirthem);
echo "</select><br />\n";
echo '</div>';
/////////////////////////////////////////
echo '<div class="apicms_subhead">';
echo "E-mail администратора: <br /><input type='text' name='email' value='".display_html($api_settings['adm_mail'])."'  /><br />\n";
echo '</div>';
/////////////////////////////////////////
echo '<div class="apicms_menu">Настройки для SEO оптимизации сайта</div>';
echo '<div class="apicms_subhead">';
echo "Название сайта: <br /><input type='text' name='title' value='".display_html($api_settings['title'])."'  /><br />\n";
echo '</div>';
/////////////////////////////////////////
echo '<div class="apicms_subhead">';
echo "Описание сайта: <br /><input type='text' name='Description' value='".display_html($api_settings['Description'])."'  /><br />\n";
echo '</div>';
/////////////////////////////////////////
echo '<div class="apicms_subhead">';
echo "Ключевые слова: <br /><input type='text' name='Keywords' value='".display_html($api_settings['Keywords'])."'  /><br />\n";
echo '</div>';
/////////////////////////////////////////
echo '<div class="apicms_subhead">';
echo "Срок посещения поисковых ботов (минуты): <br /><input type='text' name='revisit' value='".display_html($api_settings['revisit'])."'  /><br />\n";
echo '</div>';
/////////////////////////////////////////
echo '<div class="apicms_menu">Настройки сайта</div>';
echo '<div class="apicms_subhead">';
echo "Пунктов на страницу: <br /><input type='text' name='page' value='".display_html($api_settings['on_page'])."'  /><br />\n";
echo '</div>';
/////////////////////////////////////////
echo '<div class="apicms_subhead">';
echo "Регистрация на сайте: <br /> <select name='set_reg'>\n";
echo "<option value='1'".($api_settings['reg']==1?" selected='selected'":null).">Открыта</option>\n";
echo "<option value='0'".($api_settings['reg']==0?" selected='selected'":null).">Закрыта</option>\n";
echo "</select><br />\n";
echo '</div>';
/////////////////////////////////////////
echo '<div class="apicms_subhead">';
echo "Сайт открыт гостям?: <br /> <select name='set_open_guest'>\n";
echo "<option value='1'".($api_settings['open_guest']==1?" selected='selected'":null).">Открыт</option>\n";
echo "<option value='0'".($api_settings['open_guest']==0?" selected='selected'":null).">Закрыт</option>\n";
echo "</select><br />\n";
echo '</div>';
/////////////////////////////////////////
echo '<div class="apicms_subhead">';
echo "Показывать новости на главной: <br /> <select name='set_news'>\n";
echo "<option value='1'".($api_settings['news_main']==1?" selected='selected'":null).">Показывать</option>\n";
echo "<option value='0'".($api_settings['news_main']==0?" selected='selected'":null).">Скрывать</option>\n";
echo "</select><br />\n";
echo '</div>';
/////////////////////////////////////////
echo '<div class="apicms_subhead">';
echo "Защита дизайна (Beta): <br /> <select name='set_diz'>\n";
echo "<option value='1'".($api_settings['set_diz']==1?" selected='selected'":null).">Включена</option>\n";
echo "<option value='0'".($api_settings['set_diz']==0?" selected='selected'":null).">Отключена</option>\n";
echo "</select><br />\n";
echo '</div>';
/////////////////////////////////////////
echo '<div class="apicms_subhead">';
echo "Фишек за сообщение в чате: <br /><input type='text' name='fishka' value='$api_settings[fishka_chat]'  /><br />\n";
echo '</div>';
/////////////////////////////////////////
echo '<div class="apicms_subhead">';
echo "Фишек за приватное сообщение: <br /><input type='text' name='fishka_mail' value='$api_settings[fishka_mail]'  /><br />\n";
echo '</div>';
/////////////////////////////////////////
echo '<div class="apicms_subhead">';
echo "Фишек за коммент к новости: <br /><input type='text' name='fishka_n_comm' value='$api_settings[fishka_n_comm]'  /><br />\n";
echo '</div>';
/////////////////////////////////////////
echo "<input type='hidden' name='csrf_token' value='".display_html(csrf_token())."' />\n";
echo "<div class='apicms_subhead'><center><input type='submit' name='save' value='Сохранить' /></center></div>\n";
////////////////////////////////////////
}
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
