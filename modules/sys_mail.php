<?


/////////////////////////////////////////
$title = 'Системные оповещения';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.display_html($api_design).'/head.php';
/////////////////////////////////////////

global $connect;
mysqli_query($connect, "UPDATE `api_system` SET `read` = '1' WHERE `id_user` = '".intval($user['id'])."'");

/////////////////////////////////////////
$k_post_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_system` WHERE `id_user` = '".intval($user['id'])."'");
$k_post_row = mysqli_fetch_assoc($k_post_result);
$k_post = $k_post_row['cnt'];
$k_page=k_page($k_post,$api_settings['on_page']);
$page=page($k_page);
$start=$api_settings['on_page']*$page-$api_settings['on_page'];
if ($k_post==0)echo "<div class='erors'>Оповещений не найдено</div>";
/////////////////////////////////////////
$qii=mysqli_query($connect, "SELECT * FROM `api_system` WHERE `id_user` = '".intval($user['id'])."' ORDER BY time DESC LIMIT $start, ".$api_settings['on_page']);
while ($post_mail = mysqli_fetch_assoc($qii)){
echo '<div class="apicms_comms">Система <span style="float:right"> '.apicms_data($post_mail['time']).' </span></br> 
<b>'.apicms_smiles(apicms_br(display_html($post_mail['text']))).'</b></div>';
}

if ($k_page > 1){
echo '<div class="apicms_subhead"><center>';
str('/modules/sys_mail.php?',$k_page,$page); // генерируем постраничную навигацию
echo '</center></div>';
}

require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
