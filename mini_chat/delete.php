<?

/////////////////////////////////////////
$title = 'Удаление сообщения в чате';
require_once '../api_core/apicms_system.php';
/////////////////////////////////////////
global $connect;
if ($user['level'] >= 1) header('location: index.php');

$check_chat = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `mini_chat` WHERE `id` = '".intval($_GET['id'])."'");
$check_chat_row = mysqli_fetch_assoc($check_chat);
if (isset($_GET['id']) && $user['level']>=1 && $check_chat_row['cnt']==1){
$post=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `mini_chat` WHERE `id` = '".intval($_GET['id'])."' LIMIT 1"));
mysqli_query($connect, "DELETE FROM `mini_chat` WHERE `id` = '".intval($post['id'])."'");
header("Location: index.php");
}
//////////////////////////////////////////
?>