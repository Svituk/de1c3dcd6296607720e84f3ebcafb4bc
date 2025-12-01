<?

///////////////////////////////////
require_once 'api_core/apicms_system.php';
///////////////////////////////////
if (isset($_GET['username'])){
    $uname = apicms_filter($_GET['username']);
    $res_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '".mysqli_real_escape_string($connect, $uname)."' LIMIT 1");
    $row_user = mysqli_fetch_assoc($res_user);
    if ($row_user){
        $ank = $row_user;
        $ank['id'] = intval($ank['id']);
    } else {
        header("Location: /error/404.php");
        exit;
    }
} else {
    if (!isset($user['id']) && !isset($_GET['id'])){header("Location: /index.php?");exit;}
    if (isset($user['id']))$ank['id']=intval($user['id']);
    if (isset($_GET['id']))$ank['id']=intval($_GET['id']);
}
// Guard user level for later checks
$user_level = isset($user['level']) ? intval($user['level']) : 0;
global $connect;
if (!isset($_GET['username'])){
    $check_user = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `users` WHERE `id` = '".intval($ank['id'])."' LIMIT 1");
    $check_row = mysqli_fetch_assoc($check_user);
    if ($check_row['cnt']==0){header("Location: /index.php?");exit;}
    $ank=mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '".intval($ank['id'])."' LIMIT 1"));
}
///////////////////////////////////
$login_safe = isset($ank['login']) ? htmlspecialchars($ank['login']) : '';
$title = ''.$login_safe.' - Личная страница / '.status($ank['id']).'';
require_once 'design/styles/'.htmlspecialchars($api_design).'/head.php';
///////////////////////////////////
echo '<div class="apicms_content">';
if ($ank['block_time']>=$time){
echo '<b><center>Пользователь заблокирован до '.apicms_data($ank['block_time']).'</center></b>';
}
$ava_path = avatar_path($ank['id']);
if (!$ava_path) $ava_path = '/files/ava/0.png';
$ava_noqs = strpos($ava_path, '?') !== false ? substr($ava_path, 0, strpos($ava_path, '?')) : $ava_path;
$abs = $_SERVER['DOCUMENT_ROOT'].$ava_noqs;
$size = @getimagesize($abs);
$w = $size ? intval($size[0]) : 0;
$h = $size ? intval($size[1]) : 0;
$needs_modal = ($w>256 || $h>256);
echo '<style>
#ava-modal{position:fixed;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,.6);display:none;align-items:center;justify-content:center;z-index:9999}
#ava-modal:target{display:flex}
#ava-modal img{max-width:90vw;max-height:90vh;border:8px solid #fff;box-shadow:0 2px 12px rgba(0,0,0,.4)}
.ava-close{position:absolute;top:20px;right:30px;color:#fff;font-size:28px;text-decoration:none}
.ava-frame img{max-width:256px;max-height:256px;width:auto;height:auto;border:1px solid #e8e8ea}
</style>';
echo '<div class="ava-frame"><center>';
if ($needs_modal) echo '<a href="#ava-modal">';
echo '<img src="'.$ava_path.'" alt="" />';
if ($needs_modal) echo '</a>';
echo '</center></div>';
echo '<div id="ava-modal"><a class="ava-close" href="#">×</a><img src="'.$ava_path.'" alt="" /></div>';
echo '</div>';
////////////////////////////////////////
echo '<div class="apicms_subhead">';
if (isset($ank['level']) && $ank['level']==1)echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/cadmin.png" alt=""> Должность: Администратор сайта</br>';
if (isset($ank['level']) && $ank['level']==2)echo '<img src="/design/profile/cmoder.png" alt=""> Должность: Модератор сайта</br>';
echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/calendar.png" alt=""> Дата регистрации: '.apicms_data($ank['regtime']).'</br>';
echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/vhod.png" alt=""> Последнее посещение: '.apicms_data($ank['last_aut']).'</br>';
echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/activity.png" alt=""> Последняя активность: '.apicms_data($ank['activity']).'</br>';
$my_place_safe = isset($ank['my_place']) ? htmlspecialchars($ank['my_place']) : '';
echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/razdel.png" alt=""> Последний раздел: '.$my_place_safe;
echo '</div>';
////////////////////////////////////////
echo '<div class="apicms_subhead">';
if ($ank['block_count']>0)echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/user_ban.png" alt=""> Нарушений на сайте: '.$ank['block_count'].' </br> ';
echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/mail.png" alt=""> E-mail: '.(isset($ank['email']) ? htmlspecialchars($ank['email']) : '').'</br>';
echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/fishka.png" alt=""> Фишек сайта : '.(isset($ank['fishka']) ? htmlspecialchars($ank['fishka']) : '0').'</br>';

if ($ank['rating']==0)$userraiting = 'нулевой';
else $userraiting = $ank['rating'];

if ($ank['sex']==1)$userpol = 'Мужчина';
elseif ($ank['sex']==0)$userpol = 'Женщина';
else $userpol = 'Не определено';

echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/raiting.png" alt=""> Рейтинг : '.$userraiting.'</br>';
echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/nick.png" alt=""> Псевдоним: '.(isset($ank['login']) ? htmlspecialchars($ank['login']) : '').' / '.$userpol.'</br>';
echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/style.png" alt=""> Используемый стиль: '.(isset($ank['style']) ? htmlspecialchars($ank['style']) : '').'</br>';
if ($ank['name']!=NULL)echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/name.png" alt=""> Имя: '.htmlspecialchars($ank['name']).'</br>';
if ($ank['surname']!=NULL)echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/name.png" alt=""> Фамилия: '.htmlspecialchars($ank['surname']).'</br>';
if ($ank['country']!=NULL)echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/country.png" alt=""> Страна: '.htmlspecialchars($ank['country']).'</br>';
if ($ank['city']!=NULL)echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/city.png" alt=""> Город: '.htmlspecialchars($ank['city']).'</br>';
echo '</div>';
///////////////////////////////////
if ($user_level>=1){
echo '<div class="apicms_subhead">';
echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/ip.png" alt=""> IP: <a href="/admin/get_ip.php?ip='.$ank['ip'].'">'.$ank['ip'].'</a></br>';
echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/oc.png" alt=""> OC: '.(isset($ank['oc']) ? htmlspecialchars($ank['oc']) : '').'</br>';
echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/brouse.png" alt=""> Браузер: '.(isset($ank['browser']) ? htmlspecialchars($ank['browser']) : '').'</br>';
if ($user_level>=1 && isset($user['id']) && $user['id']!=$ank['id'])echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/block.png" alt="">  <a href="/admin/user_block.php?id='.$ank['id'].'">Блокировать профиль</a></br>';
if ($user_level==1)echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/edit.png" alt="">  <a href="/admin/edit_user.php?id='.$ank['id'].'">Редактировать профиль</a></br>';
echo '</div>';
}
if (isset($user['id']) && $user['id']!=$ank['id'])echo '<div class="apicms_subhead"><img src="/design/styles/'.htmlspecialchars($api_design).'/profile/e_mail.png" alt="">  <a href="/modules/user_mail.php?id='.$ank['id'].'">Написать приватно '.htmlspecialchars($ank['login']).'</a></br></div>';
if (isset($user['id']) && $user['id']!=$ank['id']){
    $contact_check = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `contact_list` WHERE `id_user` = '".intval($ank['id'])."' AND `my_id` = '".intval($user['id'])."' LIMIT 1");
$contact_row = mysqli_fetch_assoc($contact_check);
if ($contact_row['cnt']==0)echo '<div class="apicms_subhead"><img src="/design/styles/'.htmlspecialchars($api_design).'/profile/cont.png" alt="">  <a href="/modules/my_contacts.php?id='.$ank['id'].'">Добавить в контакты</a></br></div>';
}
///////////////////////////////////
require_once 'design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>
