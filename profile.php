<?

///////////////////////////////////
require_once 'api_core/apicms_system.php';
///////////////////////////////////
if (!isset($user) && !isset($_GET['id'])){header("Location: /index.php?");exit;}
if (isset($user))$ank['id']=$user['id'];
if (isset($_GET['id']))$ank['id']=intval($_GET['id']);
global $connect;
$check_user = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `users` WHERE `id` = '".intval($ank['id'])."' LIMIT 1");
$check_row = mysqli_fetch_assoc($check_user);
if ($check_row['cnt']==0){header("Location: /index.php?");exit;}
$ank=mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '".intval($ank['id'])."' LIMIT 1"));
///////////////////////////////////
$title = ''.htmlspecialchars($ank['login']).' - Личная страница / '.status($ank['id']).'';
require_once 'design/styles/'.htmlspecialchars($api_design).'/head.php';
///////////////////////////////////
echo '<div class="apicms_content">';
if ($ank['block_time']>=$time){
echo '<b><center>Пользователь заблокирован до '.apicms_data($ank['block_time']).'</center></b>';
}
echo '<center>';
echo apicms_ava64($ank['id']);
echo '</center></br>';
echo '</div>';
////////////////////////////////////////
echo '<div class="apicms_subhead">';
if ($ank['level']==1)echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/cadmin.png" alt=""> Должность: Администратор сайта</br>';
if ($ank['level']==2)echo '<img src="/design/profile/cmoder.png" alt=""> Должность: Модератор сайта</br>';
echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/calendar.png" alt=""> Дата регистрации: '.apicms_data($ank['regtime']).'</br>';
echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/vhod.png" alt=""> Последнее посещение: '.apicms_data($ank['last_aut']).'</br>';
echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/activity.png" alt=""> Последняя активность: '.apicms_data($ank['activity']).'</br>';
echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/razdel.png" alt=""> Последний раздел: '.htmlspecialchars($ank['my_place']).'';
echo '</div>';
////////////////////////////////////////
echo '<div class="apicms_subhead">';
if ($ank['block_count']>0)echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/user_ban.png" alt=""> Нарушений на сайте: '.$ank['block_count'].' </br> ';
echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/mail.png" alt=""> E-mail: '.htmlspecialchars($ank['email']).'</br>';
echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/fishka.png" alt=""> Фишек сайта : '.htmlspecialchars($ank['fishka']).'</br>';

if ($ank['rating']==0)$userraiting = 'нулевой';
else $userraiting = $ank['rating'];

if ($ank['sex']==1)$userpol = 'Мужчина';
elseif ($ank['sex']==0)$userpol = 'Женщина';
else $userpol = 'Не определено';

echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/raiting.png" alt=""> Рейтинг : '.$userraiting.'</br>';
echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/nick.png" alt=""> Псевдоним: '.htmlspecialchars($ank['login']).' / '.$userpol.'</br>';
echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/style.png" alt=""> Используемый стиль: '.htmlspecialchars($ank['style']).'</br>';
if ($ank['name']!=NULL)echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/name.png" alt=""> Имя: '.htmlspecialchars($ank['name']).'</br>';
if ($ank['surname']!=NULL)echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/name.png" alt=""> Фамилия: '.htmlspecialchars($ank['surname']).'</br>';
if ($ank['country']!=NULL)echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/country.png" alt=""> Страна: '.htmlspecialchars($ank['country']).'</br>';
if ($ank['city']!=NULL)echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/city.png" alt=""> Город: '.htmlspecialchars($ank['city']).'</br>';
echo '</div>';
///////////////////////////////////
if ($user['level']>=1){
echo '<div class="apicms_subhead">';
echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/ip.png" alt=""> IP: <a href="/admin/get_ip.php?ip='.$ank['ip'].'">'.$ank['ip'].'</a></br>';
echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/oc.png" alt=""> OC: '.htmlspecialchars($ank['oc']).'</br>';
echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/brouse.png" alt=""> Браузер: '.htmlspecialchars($ank['browser']).'</br>';
if ($user['level']>=1 && $user['id']!=$ank['id'])echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/block.png" alt="">  <a href="/admin/user_block.php?id='.$ank['id'].'">Блокировать профиль</a></br>';
if ($user['level']==1)echo '<img src="/design/styles/'.htmlspecialchars($api_design).'/profile/edit.png" alt="">  <a href="/admin/edit_user.php?id='.$ank['id'].'">Редактировать профиль</a></br>';
echo '</div>';
}
if ($user && $user['id']!=$ank['id'])echo '<div class="apicms_subhead"><img src="/design/styles/'.htmlspecialchars($api_design).'/profile/e_mail.png" alt="">  <a href="/modules/user_mail.php?id='.$ank['id'].'">Написать приватно '.htmlspecialchars($ank['login']).'</a></br></div>';
if ($user && $user['id']!=$ank['id']){
$contact_check = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `contact_list` WHERE `id_user` = '".intval($ank['id'])."' AND `my_id` = '".intval($user['id'])."' LIMIT 1");
$contact_row = mysqli_fetch_assoc($contact_check);
if ($contact_row['cnt']==0)echo '<div class="apicms_subhead"><img src="/design/styles/'.htmlspecialchars($api_design).'/profile/cont.png" alt="">  <a href="/modules/my_contacts.php?id='.$ank['id'].'">Добавить в контакты</a></br></div>';
}
///////////////////////////////////
require_once 'design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>
