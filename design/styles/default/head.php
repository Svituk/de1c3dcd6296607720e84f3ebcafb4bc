<?php

////////////////////////////////////////

$set_dg1     =     "g803UE94thOEF"; 
$set_dg2     =     "g803UEef4gGEg"; 
session_start();
$_SESSION[$set_dg1] = time()+394534293534488;
$_SESSION[$set_dg2] = $set_dg1;

if (!headers_sent()){
    header('Cache-control: no-cache');
}
// Ensure safe defaults
$api_design = isset($api_design) && $api_design ? $api_design : (isset($api_settings['style']) && $api_settings['style'] ? $api_settings['style'] : 'default');

// Guard user vars to avoid undefined index warnings
$is_user = !empty($user);
$user_level = $is_user && isset($user['level']) ? intval($user['level']) : 0;
$user_id = $is_user && isset($user['id']) ? intval($user['id']) : 0;

echo '<?xml version="1.0" encoding="utf-8" core="api"?>
<meta HTTP-EQUIV="Expires" CONTENT="0"> 
<meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>';
////////////////////////////////////////
// Use root-relative paths so design loads regardless of host variable
echo '<link rel="shortcut icon" href="/design/styles/'.htmlspecialchars($api_design).'/favicon.ico"/>';
////////////////////////////////////////
echo '<link rel="stylesheet" href="/design/styles/'.htmlspecialchars($api_design).'/style.php" type="text/css"/>';
////////////////////////////////////////
if ($_SERVER['PHP_SELF']=='/index.php'){
echo '<title>'.$api_settings['title'].'</title></head><body>';
echo '<meta name="keywords" content="'.$api_settings['Keywords'].'">';
echo '<meta name="description" content="'.$api_settings['Description'].'">';
echo '<meta name="revisit" content="'.$api_settings['revisit'].' minutes">';
echo '<meta name="Generator" content="APICMS v.3.0, http://apicms.ru" />'; ///// не убирайте это для определения сервисами CMS
echo '<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8"/>';
echo '<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>';
echo '<meta http-equiv="Content-Style-Type" content="text/css" />';
}else{
echo '<title>'.$title.'</title></head><body>';
echo '<meta name="keywords" content="'.$api_settings['Keywords'].'">';
echo '<meta name="description" content="'.$api_settings['Description'].'">';
echo '<meta name="revisit" content="'.$api_settings['revisit'].' minutes">';
echo '<meta name="Generator" content="APICMS v.3.0, http://apicms.ru" />'; ///// не убирайте это для определения сервисами CMS
echo '<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8"/>';
echo '<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>';
echo '<meta http-equiv="Content-Style-Type" content="text/css" />';
}
if (isset($apicms_errors) && is_array($apicms_errors)) { foreach($apicms_errors as $e){ echo $e; } $apicms_errors = array(); }
echo '<div class="logo"><center><a href="/"><img src="/design/styles/'.$api_design.'/style_images/logo.png" height="35"/></a></center></div>';

if (file_exists(''.$_SERVER['DOCUMENT_ROOT'].'/install/') && $user_level==1){
echo '<div class="erors">Внимание обнаружена папка install нарушение безопасности! Удалите папку с сервера!</div>';
}

///////////////////записываем активность
if ($user_id && $_SERVER['PHP_SELF']!='/index.php'){
global $connect;
mysqli_query($connect, "UPDATE `users` SET `activity` = '$time', `my_place` = '".mysqli_real_escape_string($connect, htmlspecialchars($title))."' WHERE `id` = '".intval($user_id)."' LIMIT 1");
}
include_once H.'/api_core/ads_up.php';
////////////////////////////////////////
include_once H.'/api_core/user_panel.php';
////////////////////////////////////////
if ($_SERVER['PHP_SELF']!='/index.php'){
echo '<div class="apicms_titles"><center>'.htmlspecialchars($title).'</center></div>';
}
////////////////////////////////////////
?>
