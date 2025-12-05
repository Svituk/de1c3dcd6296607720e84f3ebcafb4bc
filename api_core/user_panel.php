<?php

if (!empty($user) && !empty($user['id'])) {

global $connect;
$new_mail_result = mysqli_query($connect, "SELECT COUNT(`id`) as cnt FROM `user_mail` WHERE `id_recipient` = '".intval($user['id'])."' AND `views` = '0'");
$new_mail_row = mysqli_fetch_assoc($new_mail_result);
$new_mail = $new_mail_row['cnt'];
if ($new_mail==0)$new_mail=NULL;
else $new_mail = ' <small> +'.$new_mail.' </small> ';

$sys_new_mail_result = mysqli_query($connect, "SELECT COUNT(`id`) as cnt FROM `api_system` WHERE `id_user` = '".intval($user['id'])."' AND `read` = '0'");
$sys_new_mail_row = mysqli_fetch_assoc($sys_new_mail_result);
$sys_new_mail = $sys_new_mail_row['cnt'];
if ($sys_new_mail==0)$sys_new_mail=NULL;
else $sys_new_mail = ' <small> +'.$sys_new_mail.' </small> ';

echo '<div class="headmenu"><table width="100%" border="0" cellpadding="0" cellspacing="0">';
echo '<td><a href="/profile.php?id='.$user['id'].'" >';
echo apicms_ava40($user['id']);
echo '</a> <a class="headmenulink" href="/modules/user_menu.php"><img src="/design/styles/'.display_html($api_design).'/user_menu/ui_menu.png" alt=""></a></a> <a class="headmenulink" href="/modules/new_mail.php?id='.$user['id'].'"><img src="/design/styles/'.display_html($api_design).'/user_menu/mail_open.png" alt=""> <span id="up_mail">'.$new_mail.'</span></a> <a class="headmenulink" href="/modules/sys_mail.php"><img src="/design/styles/'.display_html($api_design).'/user_menu/sys_mail.png" alt=""> <span id="up_sys">'.$sys_new_mail.'</span></a> </td>';
echo '<td align="right"><a href="/log_out.php" class="headbut">Выйти</a></td>';
echo '</tr></table></div>';
echo <<<'JS'
<script>(function(){function init(){var pm=0,ps=0;var m=document.getElementById("up_mail"),s=document.getElementById("up_sys");function n(el){var t=el?el.textContent:"";var a=t.match(/\+(\d+)/);return a?parseInt(a[1],10):0}pm=n(m);ps=n(s);var A=null;function playFile(){try{if(!A){A=new Audio();var canMp3=A.canPlayType&&A.canPlayType('audio/mpeg');var src=canMp3?'/design/styles/default/user_menu/oh-oh-icq-sound.mp3':'/design/styles/default/user_menu/oh-oh-icq-sound.wav';A.src=src;A.preload='auto';A.volume=0.6}A.currentTime=0;A.play().catch(function(){fallbackTone()});}catch(e){fallbackTone()}}function fallbackTone(){try{var C=window.AudioContext||window.webkitAudioContext;if(!C)return;var ctx=new C();var g=ctx.createGain();g.gain.value=0.06;g.connect(ctx.destination);function tone(freq,dur,when){var o=ctx.createOscillator();o.type='triangle';o.frequency.value=freq;o.connect(g);o.start(when);o.stop(when+dur)}var now=ctx.currentTime;tone(880,0.18,now);tone(1320,0.14,now+0.18);tone(990,0.12,now+0.35);}catch(e){}}function beep(){playFile()}function req(url,cb){try{var q=url+((url.indexOf('?')>=0)?'&':'?')+'_='+(Date.now());if(window.fetch){fetch(q,{headers:{"X-Requested-With":"XMLHttpRequest"}}).then(function(r){return r.text()}).then(function(t){try{cb(JSON.parse(t))}catch(e){cb(null)}});return}var x=new XMLHttpRequest();x.open('GET',q,true);x.setRequestHeader('X-Requested-With','XMLHttpRequest');x.onreadystatechange=function(){if(x.readyState===4){try{cb(JSON.parse(x.responseText))}catch(e){cb(null)}}};x.send(null)}catch(e){cb(null)}}var urls=["/panel_counts.php","/modules/panel_counts.php","panel_counts.php"];function u(){var i=0;function go(){req(urls[i],function(j){if(!j||!j.ok){i++;if(i<urls.length){go()}return}if(m){m.textContent=j.mail>0?(" "+"+"+j.mail+" "):""}if(s){s.textContent=j.sys>0?(" "+"+"+j.sys+" "):""}if(j.mail>pm||j.sys>ps){beep()}pm=j.mail;ps=j.sys;})}go()}u();setInterval(u,1000)}if(document.readyState==='loading'){document.addEventListener('DOMContentLoaded',init)}else{init()}})();</script>
JS;
}else{
echo '<div class="headmenu"><table width="100%" border="0" cellpadding="0" cellspacing="0">';
echo '<td> <a href="/" ><img src="/design/styles/'.display_html($api_design).'/panel_logo.png" alt=""></a> </td>';
echo '<td align="right"><a href="/auth.php" class="headbut">Войти</a><a href="/reg.php" class="headbut">Создать профиль</a></td>';
echo '</tr></table></div>';
///////  можно убрать строку ниже будет лучше индексировать поисковиками
echo '<div class="apicms_content"><div class="descr">Процесс регистрации не займет у вас много времени, зато позволит по достойнству оценить возможности нашей CMS.</div></div>';
///////
}
////////////////////////////////////////
?>
