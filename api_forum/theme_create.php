<?


////////////////////////////////////////
$title = 'Форум - Создание новой темы';
require_once '../api_core/apicms_system.php';
// NOTE: do not include head.php before processing POST/redirects — header() must be sent before output.
////////////////////////////////////////
global $connect;
if (isset($_GET['id'])) $subforum_id = intval($_GET['id']);
$check_subforum = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_forum_subforum` WHERE `id` = '".$subforum_id."'");
$check_subforum_row = mysqli_fetch_assoc($check_subforum);
if (isset($_GET['id']) && $check_subforum_row['cnt']==1){
	if ($user){
		// Handle POST before any output so header() can work
		if (isset($_POST['save']) && csrf_check()){
			if (isset($_POST['name']) && isset($_POST['text'])){
				$name_len = mb_strlen($_POST['name']);
				$text_len = mb_strlen($_POST['text']);
				if ($name_len > 10 && $text_len > 50){
                    $my_theme_name = apicms_filter($_POST['name']);
                    $my_theme_text = apicms_filter($_POST['text']);
                    $stmt = mysqli_prepare($connect, "INSERT INTO `api_forum_theme` (name, text, id_user, time, subforum) values (?,?,?,?,?)");
                    $uid=intval($user['id']); $sub=intval($subforum_id);
                    mysqli_stmt_bind_param($stmt,'ssiii',$my_theme_name,$my_theme_text,$uid,$time,$sub);
                    $res = mysqli_stmt_execute($stmt);
					if ($res && mysqli_affected_rows($connect) > 0) {
						header("Location: all_theme.php?id=$subforum_id");
						exit();
					} else {
						$post_error = 'Ошибка при создании темы. Попробуйте позже.';
					}
				} else {
					$post_error = 'Ошибка: название должно быть не менее 10 символов, текст не менее 50.';
				}
			} else {
				$post_error = 'Ошибка: заполните все поля формы.';
			}
		}
		// Now safe to include head and continue rendering form/page
		require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
////////////////////////////////////////
echo "<form method='post' action='?ok&id=$subforum_id'>\n";
echo '<div class="apicms_dialog">';
echo "Название темы:  мин. 10 симв.</br> <input type='text' name='name' value=''  /><br />\n";
echo "Текст обращения: мин. 50 симв.</br><textarea name='text'></textarea><br />\n";
echo '</div>';
if (!empty($post_error)) echo '<div class="erors"><center>'.htmlspecialchars($post_error).'</center></div>';
///////////////////////////////////
echo "<input type='hidden' name='csrf_token' value='".htmlspecialchars(csrf_token())."' />";
echo "<div class='apicms_subhead'><input type='submit' name='save' value='Создать новую тему' /></div>\n";
}else{
echo "<div class='erors'>У вас нет прав создавать темы</div>\n";
}
}else{
echo "<div class='erors'>Ошибка раздела</div>\n";
}
////////////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>
