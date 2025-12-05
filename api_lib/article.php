<?


/////////////////////////////////////////
require_once '../api_core/apicms_system.php';
/////////////////////////////////////////
global $connect;
$lib_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$libs_name = $lib_id ? mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `api_lib_article` WHERE `id` = '$lib_id' LIMIT 1")) : false;
$title = $libs_name && isset($libs_name['name']) ? (display_html($libs_name['name']).' читать') : 'Статья';
$edit_error = '';
if ($lib_id && $libs_name){
    if (isset($_GET['edit']) && $is_user){
        $owner_id = intval($libs_name['id_user']);
        $can_edit = ($user_level==1 || ($user_id && $user_id==$owner_id));
        if ($can_edit && $_SERVER['REQUEST_METHOD']==='POST'){
            if (!csrf_check()){
                $edit_error = '<div class="erors"><center>Неверный CSRF-токен</center></div>';
            } else {
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $text = isset($_POST['text']) ? $_POST['text'] : '';
            if (strlen($name)>2 && strlen($text)>20){
                $lib_name_new = apicms_filter($name);
                $lib_text_new = apicms_filter($text);
                mysqli_query($connect, "UPDATE `api_lib_article` SET `name` = '$lib_name_new', `text` = '$lib_text_new' WHERE `id` = '$lib_id' LIMIT 1");
                header("Location: article.php?id=".$lib_id);
                exit;
            }
            }
        }
    }
    require_once '../design/styles/'.display_html($api_design).'/head.php';
/////////////////////////////////////////

$qii=mysqli_query($connect, "SELECT * FROM `api_lib_article` WHERE `id` = '$lib_id' LIMIT 1");
while ($post_post = mysqli_fetch_assoc($qii)){
$who_post = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = ".intval($post_post['id_user'])." LIMIT 1"));
if (!$who_post) $who_post = array('id'=>0,'login'=>'Гость');
echo " <div class='apicms_subhead'><center><strong><h4> <img src='/design/styles/".display_html($api_design)."/lib/bookmark.png' alt=''> ".display_html($post_post['name'])."</h4></strong></center>";
if ($edit_error !== '') echo $edit_error;
if (isset($_GET['edit']) && $is_user && ($user_level==1 || ($user_id && $user_id==intval($post_post['id_user'])))){
    echo "<form method='post' action='?id=$lib_id&edit=1'>";
    echo "<input type='hidden' name='csrf_token' value='".display_html(csrf_token())."' />";
    echo "<div class='apicms_subhead'>Название статьи: </br> <input type='text' name='name' value='".display_html($post_post['name'])."'  /> <br /> Текст статьи: </br> <textarea name='text'>".display_html($post_post['text'])."</textarea></div>";
    echo "<div class='apicms_subhead'><center><input type='submit' value='Сохранить' /></center></div></form><hr />";
} else {
    echo " ".apicms_smiles(apicms_br(display_html($post_post['text'])))."</br><hr />";
}
 $profile_link = function_exists('profile_url_by_id') ? profile_url_by_id(intval($who_post['id'])) : ('/profile.php?id='.intval($who_post['id']));
echo "<img src='/design/styles/".display_html($api_design)."/lib/autors.png' alt=''> <small><a href='".$profile_link."'>".display_html($who_post['login'])."</a></small>  <span style='float:right'> <img src='/design/styles/".display_html($api_design)."/lib/vremia.png' alt=''> <small>".apicms_data($post_post['time'])."</small> </span></div>";
}
}else{
require_once '../design/styles/'.display_html($api_design).'/head.php';
echo "<div class='erors'><center>Извините, статьи не существует</center></div>\n";
}
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
