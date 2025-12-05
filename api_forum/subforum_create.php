<?


////////////////////////////////////////
$title = 'Форум - Создание подфорума';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.display_html($api_design).'/head.php';
////////////////////////////////////////
global $connect;
if (isset($_GET['id']))$razdel_id = intval($_GET['id']);
/////////////////////////////////////////
if ($user['level']>=1){
if (isset($_POST['save'])){
if (isset($_POST['subforum']) && strlen($_POST['subforum'])>10){
$my_subforum = apicms_filter($_POST['subforum']);
$my_subforum_opis = apicms_filter($_POST['subforum_opis']);
mysqli_query($connect, "INSERT INTO `api_forum_subforum` (name, opisanie, id_user, time, razdel) values ('".apicms_filter($my_subforum)."', '".apicms_filter($my_subforum_opis)."', '".intval($user['id'])."', '$time', '$razdel_id')");
}
///////////////////////////////////
echo '<div class="content"><center>Раздел успешно создан</center></div>';
header("Location: index.php");
}
////////////////////////////////////////
echo "<form method='post' action='?ok&id=$razdel_id'>\n";
echo "<div class='apicms_subhead'><center>Название подфорума: </br> <input type='text' name='subforum' value=''  /><br /> <textarea name='subforum_opis'></textarea></center></div>\n";
///////////////////////////////////
echo "<div class='apicms_subhead'><center><input type='submit' name='save' value='Создать подфорум' /></center></div>\n";
}else{
echo "<div class='erors'><center>Недостаточно прав для входа!</center></div>\n";
}
////////////////////////////////////////
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
