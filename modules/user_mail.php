<?


/////////////////////////////////////////
$title = 'Приватная почта';
require_once '../api_core/apicms_system.php';
/////////////////////////////////////////

if (!isset($_GET['id'])){header("Location: /");exit;}
$ank = intval($_GET['id']);
if (!$ank){header("Location: /");exit;}
global $connect;
$stmt_u = mysqli_prepare($connect, "SELECT * FROM `users` WHERE `id` = ? LIMIT 1");
$uid_param = intval($ank);
mysqli_stmt_bind_param($stmt_u, 'i', $uid_param);
mysqli_stmt_execute($stmt_u);
$res_u = mysqli_stmt_get_result($stmt_u);
$ank = mysqli_fetch_assoc($res_u);
if ($user['id']==$ank['id']){header("Location: /");exit;}
// AJAX handlers
if (isset($_POST['ajax']) && $_POST['ajax']==='send' && isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
    header('Content-Type: application/json; charset=UTF-8');
    $resp = array('ok'=>0);
    if (!csrf_check()){ echo json_encode($resp); exit; }
    $txt = apicms_filter(isset($_POST['txt'])?$_POST['txt']:'');
    if (strlen(trim($txt))<1 || strlen($txt)>1024){ echo json_encode($resp); exit; }
    $dup = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `id`,`time`,`txt` FROM `user_mail` WHERE `id_sender` = '".intval($user['id'])."' AND `id_recipient` = '".intval($ank['id'])."' ORDER BY `id` DESC LIMIT 1"));
    if ($dup && isset($dup['txt']) && $dup['txt'] === $txt && ($time - intval($dup['time'])) <= 5){ echo json_encode(array('ok'=>1,'html'=>'')); exit; }
    $stmt = mysqli_prepare($connect, "INSERT INTO `user_mail` (`txt`,`id_sender`,`id_recipient`,`time`) VALUES (?,?,?,?)");
    $sid=intval($user['id']); $rid=intval($ank['id']);
    mysqli_stmt_bind_param($stmt,'siii',$txt,$sid,$rid,$time);
    mysqli_stmt_execute($stmt);
    $mid = mysqli_insert_id($connect);
    $ank2 = $user; // current sender
    $html = '<div class="apicms_subhead" id="msg-'.$mid.'"><table width="100%" ><tr><td width="20%"><center>';
    ob_start(); apicms_ava32($ank2['id']); $ava_html = ob_get_clean();
    $html .= $ava_html;
    $html .= "</center></td><td width='80%'><a href='".(function_exists('profile_url_by_id')?profile_url_by_id(intval($ank2['id'])):'/profile.php?id='.intval($ank2['id']))."'>".display_html($ank2['login'])."</a> ";
    $html .= "<span style='float:right'> ".apicms_data($time)." </span>";
    $html .= "</br> <b>".apicms_smiles(apicms_bb_code(apicms_br(display_html($txt))))."</b>";
    $html .= "</td></tr></table></div>";
    echo json_encode(array('ok'=>1,'html'=>$html));
    exit;
}
if (isset($_POST['ajax']) && $_POST['ajax']==='edit' && isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
    header('Content-Type: application/json; charset=UTF-8');
    $resp = array('ok'=>0);
    if (!csrf_check()){ echo json_encode($resp); exit; }
    $edit_id = intval(isset($_POST['edit_id'])?$_POST['edit_id']:0);
    $newtxt = apicms_filter(isset($_POST['newtxt'])?$_POST['newtxt']:'');
    $row = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `user_mail` WHERE `id` = '".$edit_id."' LIMIT 1"));
    if (!$row || intval($row['id_sender'])!=intval($user['id']) || intval($row['id_recipient'])!=intval($ank['id']) || ($time - intval($row['time'])) > 180){ echo json_encode($resp); exit; }
    if (strlen(trim($newtxt))<1 || strlen($newtxt)>1024){ echo json_encode($resp); exit; }
    $stmt_e = mysqli_prepare($connect, "UPDATE `user_mail` SET `txt` = ? WHERE `id` = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt_e,'si',$newtxt,$edit_id);
    mysqli_stmt_execute($stmt_e);
    $html = apicms_smiles(apicms_bb_code(apicms_br(display_html($newtxt))));
    echo json_encode(array('ok'=>1,'id'=>$edit_id,'html'=>$html));
    exit;
}
if (isset($_POST['ajax']) && $_POST['ajax']==='poll' && isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
    header('Content-Type: application/json; charset=UTF-8');
    $cur_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    if ($cur_page > 1) { echo json_encode(array('ok'=>0)); exit; }
    $last_id = intval(isset($_POST['last_id'])?$_POST['last_id']:0);
    $items = array();
    $max_id = $last_id;
    $q = mysqli_query($connect, "SELECT * FROM `user_mail` WHERE ((`id_recipient` = '".intval($user['id'])."' AND `id_sender` = '".intval($ank['id'])."') OR (`id_recipient` = '".intval($ank['id'])."' AND `id_sender` = '".intval($user['id'])."')) AND `id` > '".$last_id."' ORDER BY `id` ASC LIMIT 20");
    while ($row = mysqli_fetch_assoc($q)){
        $ank2=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = ".intval($row['id_sender'])." LIMIT 1"));
        $html = '<div class="apicms_subhead" id="msg-'.intval($row['id']).'"><table width="100%" ><tr><td width="20%"><center>';
        ob_start(); apicms_ava32($ank2['id']); $ava_html = ob_get_clean();
        $html .= $ava_html;
        $html .= "</center></td><td width='80%'>";
        $plink = function_exists('profile_url_by_id') ? profile_url_by_id(intval($ank2['id'])) : ('/profile.php?id='.intval($ank2['id']));
        $html .= "<a href='".$plink."'>".display_html($ank2['login'])."</a> ";
        $badge = (intval($row['id_recipient'])===intval($user['id'])) ? " <span class='badge-new' style='margin-left:6px;font-size:11px;padding:1px 6px;border-radius:10px;background:#e6f4ff;color:#1e60a0;border:1px solid #cde4ff;'>новое</span>" : "";
        $html .= "<span style='float:right'> ".apicms_data($row['time'])." </span>".$badge;
        $html .= "</br> <b>".apicms_smiles(apicms_bb_code(apicms_br(display_html($row['txt']))))."</b>";
        if (intval($row['id_sender']) === intval($ank['id'])){
            $html .= " <small><a href='/modules/user_mail.php?id=".$ank['id']."&quote=".$row['id']."'>Цитировать</a></small>";
        }
        if (intval($row['id_sender'])===intval($user['id']) && ($time - intval($row['time'])) <= 180){
            $html .= " <small><a href='/modules/user_mail.php?id=".$ank['id']."&edit=".$row['id']."'>Редактировать</a></small>";
        }
        $html .= "</td></tr></table></div>";
        $items[] = $html;
        if (intval($row['id'])>$max_id){ $max_id = intval($row['id']); }
        if (intval($row['id_recipient'])===intval($user['id'])){
            mysqli_query($connect, "UPDATE `user_mail` SET `views` = '1' WHERE `id` = '".intval($row['id'])."' LIMIT 1");
        }
    }
    echo json_encode(array('ok'=>1,'items'=>$items,'last_id'=>$max_id));
    exit;
}
// Prefill quote if requested
$quote_prefill = '';
if (isset($_GET['quote'])){
    $mid = intval($_GET['quote']);
    if ($mid>0){
        // Разрешаем цитировать только сообщения собеседника (он отправитель, я получатель)
        $qmsg = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `user_mail` WHERE `id` = '$mid' AND (`id_sender` = '".intval($ank['id'])."' AND `id_recipient` = '".intval($user['id'])."') LIMIT 1"));
        if ($qmsg && isset($qmsg['txt'])){
            $author_row = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `login` FROM `users` WHERE `id` = '".intval($qmsg['id_sender'])."' LIMIT 1"));
            $author = $author_row && isset($author_row['login']) ? $author_row['login'] : 'Пользователь';
            $quote_prefill = "Цитата от ".$author." (".apicms_data($qmsg['time'])."):\n[quote]".$qmsg['txt']."[/quote]\n";
        }
    }
}

if (isset($_POST['txt']) && csrf_check()){
$text = apicms_filter($_POST['txt']);
if (strlen($text)>1024)$err = '<div class="erors"><center>Очень длинное сообщение</center></div>';
if (strlen(trim($text))<1)$err = '<div class="erors"><center>Слишком короткое сообщение</center></div>';
if (!isset($err)){
 $dup2 = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `id`,`time`,`txt` FROM `user_mail` WHERE `id_sender` = '".intval($user['id'])."' AND `id_recipient` = '".intval($ank['id'])."' ORDER BY `id` DESC LIMIT 1"));
 if ($dup2 && isset($dup2['txt']) && $dup2['txt'] === $text && ($time - intval($dup2['time'])) <= 5){
     header('Location: /modules/user_mail.php?id='.$ank['id']);
     exit;
 }
$stmt = mysqli_prepare($connect, "INSERT INTO `user_mail` (`txt`,`id_sender`,`id_recipient`,`time`) VALUES (?,?,?,?)");
$sid=intval($user['id']); $rid=intval($ank['id']);
mysqli_stmt_bind_param($stmt,'siii',$text,$sid,$rid,$time);
mysqli_stmt_execute($stmt);
////////////////////////////////////
$plus_fishka = $user['fishka'] + $api_settings['fishka_mail'];
mysqli_query($connect, "UPDATE `users` SET `fishka` = '".intval($plus_fishka)."' WHERE `id` = '".intval($user['id'])."' LIMIT 1");
 // Prevent duplicate resubmission
    $_SESSION['last_mail_post'] = array('rid'=>$rid,'txt'=>$text,'time'=>$time);
    header('Location: /modules/user_mail.php?id='.$ank['id']);
    exit;
}else{
apicms_error($err);
}
}

// Edit own message while unread
$edit_id = isset($_GET['edit']) ? intval($_GET['edit']) : 0;
$edit_msg = false;
if ($edit_id>0){
    $edit_row = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `user_mail` WHERE `id` = '".$edit_id."' LIMIT 1"));
    if ($edit_row && intval($edit_row['id_sender'])==intval($user['id']) && intval($edit_row['id_recipient'])==intval($ank['id']) && ($time - intval($edit_row['time'])) <= 180){
        $edit_msg = $edit_row;
        if (isset($_POST['newtxt']) && csrf_check()){
            $newtxt = apicms_filter($_POST['newtxt']);
            if (strlen(trim($newtxt))<1) {
                apicms_error('<div class="erors"><center>Слишком короткое сообщение</center></div>');
            } elseif (strlen($newtxt)>1024) {
                apicms_error('<div class="erors"><center>Очень длинное сообщение</center></div>');
            } else {
                $stmt_e = mysqli_prepare($connect, "UPDATE `user_mail` SET `txt` = ? WHERE `id` = ? LIMIT 1");
                $eid = intval($edit_id);
                mysqli_stmt_bind_param($stmt_e,'si',$newtxt,$eid);
                mysqli_stmt_execute($stmt_e);
                header('Location: /modules/user_mail.php?id='.$ank['id']);
                exit;
            }
        }
    }
}

// mark dialog messages as viewed
mysqli_query($connect, "UPDATE `user_mail` SET `views` = '1' WHERE `id_recipient` = '".intval($user['id'])."' AND `id_sender` = '".intval($ank['id'])."'");

require_once '../design/styles/'.display_html($api_design).'/head.php';

/////////////////////////////////////////
$profile_link_other = function_exists('profile_url_by_id') ? profile_url_by_id(intval($ank['id'])) : ('/profile.php?id='.intval($ank['id']));

if ($edit_msg){
    echo "<div class='apicms_dialog'><form id='editForm' action='/modules/user_mail.php?id=".$ank['id']."&edit=".$edit_id."' method='post'>";
    echo "<div>Редактирование сообщения (доступно 3 минуты после отправки):</div>";
    echo "<textarea name='newtxt' style='width:95%'>".display_html($edit_msg['txt'])."</textarea><br />";
    echo "<input type='hidden' name='csrf_token' value='".csrf_token()."' />";
    echo "<input type='submit' value='Сохранить' /></form></div>";
}
$k_post_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `user_mail` WHERE (`id_recipient` = '".intval($user['id'])."' AND `id_sender` = '".intval($ank['id'])."') OR (`id_recipient` = '".intval($ank['id'])."' AND `id_sender` = '".intval($user['id'])."')");
$k_post_row = mysqli_fetch_assoc($k_post_result);
$k_post = $k_post_row['cnt'];
$per_page = 5;
$k_page=k_page($k_post,$per_page);
$page=page($k_page);
$start=$per_page*$page-$per_page;
if ($k_post==0)echo "<div class='erors'><center>Вы еще не вели диалогов</center></div>";
/////////////////////////////////////////
$qii=mysqli_query($connect, "SELECT * FROM `user_mail` WHERE (`id_recipient` = '".intval($user['id'])."' AND `id_sender` = '".intval($ank['id'])."') OR (`id_recipient` = '".intval($ank['id'])."' AND `id_sender` = '".intval($user['id'])."') ORDER BY time DESC LIMIT $start, $per_page");
echo "<div id='messages'>";
while ($post_mail = mysqli_fetch_assoc($qii)){
$ank2=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = ".intval($post_mail['id_sender'])." LIMIT 1"));
echo '<div class="apicms_subhead" id="msg-'.intval($post_mail['id']).'"><table width="100%" ><tr><td width="20%"><center>';
echo apicms_ava32($ank2['id']);
echo "</center></td><td width='80%'>";
$plink = function_exists('profile_url_by_id') ? profile_url_by_id(intval($ank2['id'])) : ('/profile.php?id='.intval($ank2['id']));
echo "<a href='".$plink."'>".display_html($ank2['login'])."</a> ";
echo "<span style='float:right'> ".apicms_data($post_mail['time'])." ";
echo " </span>";
$can_quote = (intval($post_mail['id_sender']) === intval($ank['id']));
if (intval($post_mail['id_sender'])===intval($user['id']) && ($time - intval($post_mail['time'])) <= 180){
    echo " <small><a href='/modules/user_mail.php?id=".$ank['id']."&edit=".$post_mail['id']."'>Редактировать</a></small>";
}
echo "</br> <b>".apicms_smiles(apicms_bb_code(apicms_br(display_html($post_mail['txt']))))."</b>";
if ($can_quote){
    echo " <small><a href='/modules/user_mail.php?id=".$ank['id']."&quote=".$post_mail['id']."'>Цитировать</a></small>";
}
echo "</td></tr></table></div>";
}
echo "</div>";
/////////////////////////////////////////
if ($user['id']){
echo "<form id='sendForm' action='/modules/user_mail.php?id=".$ank['id']."&page=".$page."&ok' method='post'>";
 echo "<div class='apicms_dialog'><center><textarea name='txt'>".display_html($quote_prefill)."</textarea><br />";
echo "<input type='hidden' name='csrf_token' value='".csrf_token()."' />";
echo "<input type='submit' value='Добавить'/></form></center></div>";
}else{
echo "<div class='apicms_content'>Извините вы неможете писать  в почту</div>";
}
// AJAX client (initialized once, outside the messages loop)
echo "<script>(function(){function init(){var sendForm=document.getElementById('sendForm');var sending=false;function toBody(fd){try{if(fd instanceof FormData){return fd}}catch(e){}var obj={};if(fd && typeof fd==='object'){obj=fd}else{obj={}}var s=[];for(var k in obj){if(Object.prototype.hasOwnProperty.call(obj,k)){s.push(encodeURIComponent(k)+'='+encodeURIComponent(obj[k]))}}return s.join('&')}function req(url,fd,cb){try{var q=url+((url.indexOf('?')>=0)?'&':'?')+'_='+(Date.now());if(window.fetch){var body=toBody(fd);var opts={method:'POST',headers:{'X-Requested-With':'XMLHttpRequest'}};if(typeof body==='string'){opts.headers['Content-Type']='application/x-www-form-urlencoded; charset=UTF-8';opts.body=body}else{opts.body=body}fetch(q,opts).then(function(r){return r.text()}).then(function(t){try{cb(JSON.parse(t))}catch(e){}});return}var x=new XMLHttpRequest();x.open('POST',q,true);x.setRequestHeader('X-Requested-With','XMLHttpRequest');var body=toBody(fd);if(typeof body==='string'){x.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');x.send(body)}else{x.send(fd)}x.onreadystatechange=function(){if(x.readyState===4){try{cb(JSON.parse(x.responseText))}catch(e){}}}}catch(e){}}function hs(el){try{el.style.backgroundColor='#fff8cc';el.style.transition='background-color 0.6s';setTimeout(function(){el.style.backgroundColor='';},3000)}catch(e){}}if(sendForm){sendForm.addEventListener('submit',function(e){e.preventDefault();if(sending){return}sending=true;var btn=sendForm.querySelector('input[type=submit]');if(btn)btn.disabled=true;var fd=new FormData(sendForm);fd.append('ajax','send');req(sendForm.action,fd,function(j){sending=false; if(btn)btn.disabled=false; if(j&&j.ok){var box=document.getElementById('messages');if(!box){box=document.body}var tmp=document.createElement('div');tmp.innerHTML=j.html;var el=tmp.firstChild;box.insertBefore(el,box.firstChild);hs(el);var ta=sendForm.querySelector('textarea[name=txt]');if(ta)ta.value='';var m=j.html.match(/id=\"msg-(\\d+)\"/);if(m){var nid=parseInt(m[1],10);if(nid>lastId)lastId=nid}poll()}else{alert('Ошибка отправки')}})});}var editForm=document.getElementById('editForm');if(editForm){editForm.addEventListener('submit',function(e){e.preventDefault();var fd=new FormData(editForm);fd.append('ajax','edit');fd.append('edit_id','".$edit_id."');req(editForm.action,fd,function(j){if(j&&j.ok){var el=document.getElementById('msg-'+j.id);if(el){var b=el.querySelector('b');if(b){b.innerHTML=j.html}hs(el)}}else{alert('Ошибка сохранения')}})})}var lastId=0;var els=document.querySelectorAll('#messages .apicms_subhead[id^=msg-]');for(var i=0;i<els.length;i++){var m=els[i].id.match(/msg-(\\d+)/);if(m){var id=parseInt(m[1],10);if(id>lastId)lastId=id}}function poll(){var data={'ajax':'poll','last_id':String(lastId)};var url=sendForm?sendForm.action:window.location.pathname;req(url,data,function(j){if(j&&j.ok&&j.items&&j.items.length){var box=document.getElementById('messages');if(!box){box=document.body}for(var i=0;i<j.items.length;i++){var tmp=document.createElement('div');tmp.innerHTML=j.items[i];var mm=j.items[i].match(/id=\"msg-(\\d+)\"/);if(mm){var mid=parseInt(mm[1],10);if(document.getElementById('msg-'+mid)){continue;}}var el=tmp.firstChild;box.insertBefore(el,box.firstChild);hs(el)}if(j.last_id&&j.last_id>lastId){lastId=j.last_id}}})}poll();setInterval(poll,1000)}if(document.readyState==='loading'){document.addEventListener('DOMContentLoaded',init)}else{init()}})();</script>";
echo "<script>try{Element.prototype.scrollIntoView=function(){}}catch(e){}</script>";
/////////////////////////////////////////
if ($k_page > 1){
echo '<div class="apicms_subhead"><center>';
str('/modules/user_mail.php?id='.$ank['id'].'&',$k_page,$page); // генерируем постраничную навигацию
echo '</center></div>';
}
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
