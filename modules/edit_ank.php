<?


////////////////////////////////////////
$title = 'Редактирование аккаунта';
require_once '../api_core/apicms_system.php';
if (!isset($user['id']) || !$user['id']) { header('Location: /'); exit; }
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';

global $connect;
$my_sets = isset($_POST['set_theme']) ? mysqli_real_escape_string($connect, $_POST['set_theme']) : '';
///////////////////////////////////
if (isset($_POST['save'])){
///////////////////////////////////
if (isset($_POST['name']) && preg_match('/[A-zА-я0-9 _\-\=\+\(\)\*\?\.,]/i', $_POST['name'])){
$nameus = mysqli_real_escape_string($connect, $_POST['name']);
mysqli_query($connect, "UPDATE `users` SET `name` = '$nameus' WHERE `id` = '".intval($user['id'])."' LIMIT 1");
}
///////////////////////////////////
if (isset($_POST['set_theme']) && preg_match('#^([A-z0-9\-_\(\)]+)$#ui', $_POST['set_theme']) && is_dir(H.'design/styles/'.$_POST['set_theme'])){
mysqli_query($connect, "UPDATE `users` SET `style` = '$my_sets' WHERE `id` = '".intval($user['id'])."' LIMIT 1");
}
///////////////////////////////////
if (isset($_POST['email']) && preg_match('/[0-9a-z_\-]+@[0-9a-z_\-^\.]+\.[a-z]{2,6}/i', $_POST['email'])){
$mailus = mysqli_real_escape_string($connect, $_POST['email']);
mysqli_query($connect, "UPDATE `users` SET `email` = '$mailus' WHERE `id` = '".intval($user['id'])."' LIMIT 1");
}
///////////////////////////////////
if (isset($_POST['surname']) && preg_match('/[A-zА-я0-9 _\-\=\+\(\)\*\?\.,]/i', $_POST['surname'])){
$surnameus = mysqli_real_escape_string($connect, $_POST['surname']);
mysqli_query($connect, "UPDATE `users` SET `surname` = '$surnameus' WHERE `id` = '".intval($user['id'])."' LIMIT 1");
}
///////////////////////////////////
if (isset($_POST['country']) && preg_match('/[A-zА-я0-9 _\-\=\+\(\)\*\?\.,]/i', $_POST['country'])){
$countryus = mysqli_real_escape_string($connect, $_POST['country']);
mysqli_query($connect, "UPDATE `users` SET `country` = '$countryus' WHERE `id` = '".intval($user['id'])."' LIMIT 1");
}
///////////////////////////////////
if (isset($_POST['city']) && preg_match('/[A-zА-я0-9 _\-\=\+\(\)\*\?\.,]/i', $_POST['city'])){
$cityus = mysqli_real_escape_string($connect, $_POST['city']);
mysqli_query($connect, "UPDATE `users` SET `city` = '$cityus' WHERE `id` = '".intval($user['id'])."' LIMIT 1");
}
///////////////////////////////////
echo '<div class="apicms_content"><center>Изменения в анкету внесены</center></div>';
}
////////////////////////////////////////
echo "<form method='post' action='?ok'>\n";
///////////////////////////////////
echo '<div class="apicms_subhead">';
echo "Ваше имя: </br> <input type='text' name='name' value='".htmlentities(isset($user['name']) ? $user['name'] : '', ENT_QUOTES, 'UTF-8')."'  /><br />\n";
echo '</div>';
///////////////////////////////////
echo '<div class="apicms_subhead">';
echo "Ваша фамилия: </br> <input type='text' name='surname' value='".htmlentities(isset($user['surname']) ? $user['surname'] : '', ENT_QUOTES, 'UTF-8')."'  /><br />\n";
echo '</div>';
///////////////////////////////////
echo '<div class="apicms_subhead">';
echo "Ваша страна: </br> <input type='text' name='country' value='".htmlentities(isset($user['country']) ? $user['country'] : '', ENT_QUOTES, 'UTF-8')."'  /><br />\n";
echo '</div>';
///////////////////////////////////
echo '<div class="apicms_subhead">';
echo "Ваш город: </br> <input type='text' name='city' value='".htmlentities(isset($user['city']) ? $user['city'] : '', ENT_QUOTES, 'UTF-8')."'  /><br />\n";
echo '</div>';
///////////////////////////////////
echo '<div class="apicms_subhead">';
echo "Оформление  <br/><select name='set_theme'>\n";
$opendirthem=opendir(H.'design/styles');
while ($themes_set=readdir($opendirthem)){
if ($themes_set=='.' || $themes_set=='..' || !is_dir(H."design/styles/$themes_set"))continue;
echo "<option value='$themes_set'>".trim(file_get_contents(H.'design/styles/'.$themes_set.'/them.name'))."</option>\n";
}
closedir($opendirthem);
echo "</select><br />\n";
echo '</div>';
///////////////////////////////////
echo '<div class="apicms_subhead">';
echo "E-mail: <br/><input type='text' name='email' value='".htmlentities(isset($user['email']) ? $user['email'] : '', ENT_QUOTES, 'UTF-8')."'  /><br />\n";
echo '</div>';
///////////////////////////////////
echo "<div class='apicms_subhead'><center><input type='submit' name='save' value='Сохранить' /></center></div>\n";
////////////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>
