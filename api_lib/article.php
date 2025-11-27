<?


/////////////////////////////////////////
require_once '../api_core/apicms_system.php';
/////////////////////////////////////////
global $connect;
if (isset($_GET['id']))$lib_id = intval($_GET['id']);
$libs_name = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `api_lib_article` WHERE `id` = '$lib_id' LIMIT 1"));
$title = ''.htmlspecialchars($libs_name['name']).' читать';
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
$check_article = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_lib_article` WHERE `id` = '".$lib_id."'");
$check_article_row = mysqli_fetch_assoc($check_article);
if (isset($_GET['id']) && $check_article_row['cnt']==1){
/////////////////////////////////////////

$qii=mysqli_query($connect, "SELECT * FROM `api_lib_article` WHERE `id` = '$lib_id' LIMIT 1");
while ($post_post = mysqli_fetch_assoc($qii)){
$who_post = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = ".intval($post_post['id_user'])." LIMIT 1"));
echo "<div class='apicms_subhead'><center><strong><h4> <img src='/design/styles/".htmlspecialchars($api_design)."/lib/bookmark.png' alt=''> ".htmlspecialchars($post_post['name'])."</h4></strong></center>";
echo " ".apicms_smiles(apicms_br(htmlspecialchars($post_post['text'])))."</br><hr />";
echo "<img src='/design/styles/".htmlspecialchars($api_design)."/lib/autors.png' alt=''> <small><a href='/profile.php?id=$who_post[id]'>".$who_post['login']."</a></small>  <span style='float:right'> <img src='/design/styles/".htmlspecialchars($api_design)."/lib/vremia.png' alt=''> <small>".apicms_data($post_post['time'])."</small> </span></div>";
}
}else{
echo "<div class='erors'><center>Извините, статьи не существует</center></div>\n";
}
/////////////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>