<?

/////////////////////////////////////////
$title = 'Диалоги';
require_once '../api_core/apicms_system.php';
/////////////////////////////////////////
global $connect;
if (!isset($user['id']) || !$user['id']){
    header('Location: /auth.php?error');
    exit;
}
$uid = intval($user['id']);

mysqli_query($connect, "CREATE TABLE IF NOT EXISTS `user_mail_hidden` ( `user_id` int NOT NULL, `other_id` int NOT NULL, `created` int NOT NULL, PRIMARY KEY (`user_id`,`other_id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

if (isset($_POST['del_id']) && csrf_check()){
    $other_id = intval($_POST['del_id']);
    if ($other_id > 0){
        mysqli_query($connect, "REPLACE INTO `user_mail_hidden` (`user_id`,`other_id`,`created`) VALUES ('".$uid."','".$other_id."','".$time."')");
    }
    header('Location: /modules/new_mail.php');
    exit;
}
if (isset($_POST['restore_id']) && csrf_check()){
    $other_id = intval($_POST['restore_id']);
    if ($other_id > 0){
        mysqli_query($connect, "DELETE FROM `user_mail_hidden` WHERE `user_id`='".$uid."' AND `other_id`='".$other_id."' LIMIT 1");
    }
    header('Location: /modules/new_mail.php');
    exit;
}

// Общее число диалогов (уникальные собеседники) за минусом скрытых
$total_row = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) as cnt FROM (SELECT IF(id_sender='$uid', id_recipient, id_sender) AS other_id FROM `user_mail` WHERE id_sender='$uid' OR id_recipient='$uid' GROUP BY other_id) AS t WHERE other_id NOT IN (SELECT other_id FROM `user_mail_hidden` WHERE user_id='$uid')"));
$k_post = $total_row ? intval($total_row['cnt']) : 0;
$k_page = k_page($k_post, $api_settings['on_page']);
$page = page($k_page);
$start = $api_settings['on_page']*$page - $api_settings['on_page'];
if ($k_post==0) echo "<div class='apicms_content'><center>Диалогов пока нет</center></div>";

// Получаем список диалогов с последним сообщением
$threads_sql = "SELECT other_id, MAX(time) as last_time FROM (
    SELECT IF(id_sender='$uid', id_recipient, id_sender) AS other_id, time
    FROM `user_mail`
    WHERE id_sender='$uid' OR id_recipient='$uid'
) AS t WHERE other_id NOT IN (SELECT other_id FROM `user_mail_hidden` WHERE user_id='$uid') GROUP BY other_id ORDER BY last_time DESC LIMIT $start, ".$api_settings['on_page'];
$threads = mysqli_query($connect, $threads_sql);

require_once '../design/styles/'.display_html($api_design).'/head.php';
if (!isset($_GET['arch'])){
    echo '<div class="apicms_subhead"><a href="/modules/new_mail.php?arch=1">Архив диалогов</a></div>';
} else {
    echo '<div class="apicms_subhead"><a href="/modules/new_mail.php">← Назад к диалогам</a></div>';
}
while ($th = mysqli_fetch_assoc($threads)){
    $other_id = intval($th['other_id']);
    $last = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `user_mail` WHERE (id_sender='$uid' AND id_recipient='$other_id') OR (id_sender='$other_id' AND id_recipient='$uid') ORDER BY time DESC LIMIT 1"));
    $other = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$other_id' LIMIT 1"));
    if (!$other) $other = array('id'=>0,'login'=>'Гость');
    $unread_row = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `user_mail` WHERE id_recipient='$uid' AND id_sender='$other_id' AND views='0'"));
    $unread = $unread_row ? intval($unread_row['cnt']) : 0;
    echo '<div class="apicms_subhead"><table width="100%"><tr>';
    echo '<td width="12%"><center>'; apicms_ava32($other['id']); echo '</center></td>';
    echo '<td width="58%">';
    echo '<b><a href="/modules/user_mail.php?id='.$other['id'].'">'.display_html($other['login']).'</a></b><br/>';
    if ($last){
        $preview = mb_strlen($last['txt'],'UTF-8')>80 ? mb_substr($last['txt'],0,80,'UTF-8').'…' : $last['txt'];
        echo '<small>'.apicms_smiles(apicms_br(display_html($preview))).'</small>';
    }
    echo '</td>';
    echo '<td width="30%" align="right">';
    echo '<small>'.apicms_data($th['last_time']).'</small><br/>';
    if ($unread>0) echo '<span class="pill">Непрочитано: '.$unread.'</span>';
    echo '<form method="post" action="/modules/new_mail.php" style="display:inline">'
        .'<input type="hidden" name="del_id" value="'.$other['id'].'" />'
        .'<input type="hidden" name="csrf_token" value="'.display_html(csrf_token()).'" />'
        .'<button type="submit" title="Удалить диалог" style="background:none;border:none;padding:0;margin-left:8px;vertical-align:middle">'
        .'<img src="/design/styles/'.display_html($api_design).'/forum/del_theme.png" alt="Удалить" />'
        .'</button>'
        .'</form>';
    echo '</td>';
    echo '</tr></table></div>';
}

// Archived (hidden) dialogs (shown only when arch=1)
if (isset($_GET['arch'])){
    $arch = mysqli_query($connect, "SELECT h.other_id, MAX(m.time) as last_time FROM `user_mail_hidden` h LEFT JOIN `user_mail` m ON ((m.id_sender='".$uid."' AND m.id_recipient=h.other_id) OR (m.id_sender=h.other_id AND m.id_recipient='".$uid."')) WHERE h.user_id='".$uid."' GROUP BY h.other_id ORDER BY last_time DESC LIMIT 50");
    echo '<div class="apicms_subhead"><center>Архив диалогов</center></div>';
    while ($arch && ($ah = mysqli_fetch_assoc($arch))){
        $other_id = intval($ah['other_id']);
        $last = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `user_mail` WHERE (id_sender='".$uid."' AND id_recipient='".$other_id."') OR (id_sender='".$other_id."' AND id_recipient='".$uid."') ORDER BY time DESC LIMIT 1"));
        $other = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '".$other_id."' LIMIT 1"));
        if (!$other) $other = array('id'=>0,'login'=>'Гость');
        echo '<div class="apicms_subhead"><table width="100%"><tr>';
        echo '<td width="12%"><center>'; apicms_ava32($other['id']); echo '</center></td>';
        echo '<td width="58%">';
        echo '<b>'.display_html($other['login']).'</b><br/>';
        if ($last){
            $preview = mb_strlen($last['txt'],'UTF-8')>80 ? mb_substr($last['txt'],0,80,'UTF-8').'…' : $last['txt'];
            echo '<small>'.apicms_smiles(apicms_br(display_html($preview))).'</small>';
        }
        echo '</td>';
        echo '<td width="30%" align="right">';
        echo '<small>'.apicms_data($ah['last_time']).'</small><br/>';
        echo '<span class="pill">Архив</span>';
        echo '<form method="post" action="/modules/new_mail.php" style="display:inline">'
            .'<input type="hidden" name="restore_id" value="'.$other['id'].'" />'
            .'<input type="hidden" name="csrf_token" value="'.display_html(csrf_token()).'" />'
            .'<button type="submit" title="Вернуть диалог" style="background:none;border:none;padding:0;margin-left:8px;vertical-align:middle">'
            .'Вернуть'
            .'</button>'
            .'</form>';
        echo '</td>';
        echo '</tr></table></div>';
    }
}

if ($k_page > 1){
    echo '<div class="apicms_subhead"><center>';
    str('/modules/new_mail.php?',$k_page,$page);
    echo '</center></div>';
}

require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
