<?

/////////////////////////////////////////
$title = 'Удаление сообщения в гостевой';
require_once '../api_core/apicms_system.php';
/////////////////////////////////////////
global $connect;
if ($user['level']>=1) header('location: index.php');
$check_guest = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `guest` WHERE `id` = '".intval($_GET['id'])."'");
$check_guest_row = mysqli_fetch_assoc($check_guest);
if (isset($_GET['id']) && $user['level']>=1 && $check_guest_row['cnt']==1){
$post=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `guest` WHERE `id` = '".intval($_GET['id'])."' LIMIT 1"));
mysqli_query($connect, "DELETE FROM `guest` WHERE `id` = '".intval($post['id'])."'");
header("Location: index.php");
}
//////////////////////////////////////////
?>