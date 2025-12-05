<?php

////////////////////////////////////////
global $connect;

// Safe COUNT helper: returns 0 if query fails
if (!function_exists('safe_count_sql')){
	function safe_count_sql($connect, $sql){
		try{
			$res = mysqli_query($connect, $sql);
			if ($res){
				$row = mysqli_fetch_assoc($res);
				return isset($row['cnt']) ? intval($row['cnt']) : 0;
			}
		} catch (\Throwable $e) {
			// ignore and return 0
		}
		return 0;
	}
}

$k_p_news = safe_count_sql($connect, "SELECT COUNT(*) as cnt FROM `news`");
$k_n_news = safe_count_sql($connect, "SELECT COUNT(*) as cnt FROM `news` WHERE `time` > '".(time()-86400)."'");
if ($k_n_news==0) $k_n_news=NULL;
else $k_n_news = ' <sup><font color=#FF4500>+'.$k_n_news.'</font></sup>';
echo "<a class='apicms_menu_s' href='/modules/all_news.php' > <strong><img src='/design/styles/".display_html($api_design)."/menu/news.png' alt=''> Новости <span style='float:right'> <small>".$k_p_news." ".$k_n_news."</small> </span></strong></a>";
////////////////////////////////////////
echo '<div class="apicms_menu">Общение и обсуждения</div>';
////////////////////////////////////////
$k_p_chat = safe_count_sql($connect, "SELECT COUNT(*) as cnt FROM `mini_chat`");
$k_n_chat = safe_count_sql($connect, "SELECT COUNT(*) as cnt FROM `mini_chat` WHERE `time` > '".(time()-86400)."'");
if ($k_n_chat==0) $k_n_chat=NULL;
else $k_n_chat = ' <sup><font color=#FF4500>+'.$k_n_chat.'</font></sup>';
echo "<a class='apicms_menu_s' href='/mini_chat/' > <strong><img src='/design/styles/".display_html($api_design)."/menu/mini.png' alt=''> Мини-чат <span style='float:right'> <small>".$k_p_chat." ".$k_n_chat."</small> </span></strong></a>";
////////////////////////////////////////
$k_p_guest_t = safe_count_sql($connect, "SELECT COUNT(*) as cnt FROM `guest`");
$k_n_guest_t = safe_count_sql($connect, "SELECT COUNT(*) as cnt FROM `guest` WHERE `time` > '".(time()-86400)."'");
if ($k_n_guest_t==0) $k_n_guest_t=NULL;
else $k_n_guest_t = '<sup><font color=#FF4500> +'.$k_n_guest_t.'</font></sup>';
echo "<a class='apicms_menu_s' href='/guest/' > <strong><img src='/design/styles/".display_html($api_design)."/menu/guest.png' alt=''> Гостевая <span style='float:right'> <small>".$k_p_guest_t." ".$k_n_guest_t."</small> </span></strong></a>";
////////////////////////////////////////
$k_p_forum_t = safe_count_sql($connect, "SELECT COUNT(*) as cnt FROM `api_forum_theme`");
$k_n_forum_t = safe_count_sql($connect, "SELECT COUNT(*) as cnt FROM `api_forum_theme` WHERE `time` > '".(time()-86400)."'");
if ($k_n_forum_t==0) $k_n_forum_t=NULL;
else $k_n_forum_t = '<sup><font color=#FF4500> +'.$k_n_forum_t.'</font></sup>';
$k_p_forum_p = safe_count_sql($connect, "SELECT COUNT(*) as cnt FROM `api_forum_post`");
$k_n_forum_p = safe_count_sql($connect, "SELECT COUNT(*) as cnt FROM `api_forum_post` WHERE `time` > '".(time()-86400)."'");
if ($k_n_forum_p==0) $k_n_forum_p=NULL;
else $k_n_forum_p = '<sup><font color=#FF4500> +'.$k_n_forum_p.'</font></sup>';
echo "<a class='apicms_menu_s' href='/api_forum/' > <strong><img src='/design/styles/".display_html($api_design)."/menu/forum.png' alt=''> Форум <span style='float:right'> <small>".$k_p_forum_t." ".$k_n_forum_t." / ".$k_p_forum_p." ".$k_n_forum_p."</small> </span></strong></a>";
include_once 'last_themes.php';
////////////////////////////////////////
$k_p_lib_t = safe_count_sql($connect, "SELECT COUNT(*) as cnt FROM `api_lib_article`");
$k_n_lib_t = safe_count_sql($connect, "SELECT COUNT(*) as cnt FROM `api_lib_article` WHERE `time` > '".(time()-86400)."'");
if ($k_n_lib_t==0) $k_n_lib_t=NULL;
else $k_n_lib_t = '<sup><font color=#FF4500> +'.$k_n_lib_t.'</font></sup>';
$k_p_lib_p = safe_count_sql($connect, "SELECT COUNT(*) as cnt FROM `api_lib_cat`");
$k_n_lib_p = safe_count_sql($connect, "SELECT COUNT(*) as cnt FROM `api_lib_cat` WHERE `time` > '".(time()-86400)."'");
if ($k_n_lib_p==0) $k_n_lib_p=NULL;
else $k_n_lib_p = '<sup><font color=#FF4500> +'.$k_n_lib_p.'</font></sup>';
echo "<a class='apicms_menu_s' href='/api_lib/' > <strong><img src='/design/styles/".display_html($api_design)."/menu/library.png' alt=''> Библиотека <span style='float:right'> <small>".$k_p_lib_t." ".$k_n_lib_t." / ".$k_p_lib_p." ".$k_n_lib_p."</small> </span></strong></a>";

?>
