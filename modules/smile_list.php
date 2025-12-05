<?


/////////////////////////////////////////
$title = 'Список смайлов сайта';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.display_html($api_design).'/head.php';
/////////////////////////////////////////
global $connect;
$k_post_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `smiles_list`");
$k_post_row = mysqli_fetch_assoc($k_post_result);
$k_post = $k_post_row['cnt'];
$k_page=k_page($k_post,$api_settings['on_page']);
$page=page($k_page);
$start=$api_settings['on_page']*$page-$api_settings['on_page'];
if ($k_post==0)echo "<div class='apicms_content'><center>Доступных смайлов не найдено</center></div>";
/////////////////////////////////////////
$qii=mysqli_query($connect, "SELECT * FROM `smiles_list` ORDER BY id ASC LIMIT $start, ".$api_settings['on_page']);
while ($sm_list = mysqli_fetch_assoc($qii)){
echo '<div class="apicms_subhead"><table width="100%" ><tr><td width="20%"><center> '.apicms_smiles($sm_list['sim']).'';
echo "</center></td><td width='80%'>".display_html($sm_list['sim'])." </td></tr></table></div>";
}
/////////////////////////////////////////
if ($k_page > 1){
echo '<div class="apicms_subhead"><center>';
str('?',$k_page,$page); // генерируем постраничную навигацию
echo '</center></div>';
}
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
