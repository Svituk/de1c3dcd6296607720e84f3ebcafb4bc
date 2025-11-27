<?php
$set_dg1     =     "g803UE94thOEF"; 
$set_dg2     =     "g803UEef4gGEg"; 
session_start(); 
$pervajapm = $_SESSION[$set_dg1];
$vtorajapm = $_SESSION[$set_dg2];
function check_smartphone() {
$phone_array = array('iphone', 'android', 'pocket', 'palm', 'windows ce', 'windowsce', 'cellphone', 'opera mobi', 'ipod', 'small', 'sharp', 'sonyericsson', 'symbian', 'opera mini', 'nokia', 'htc_', 'samsung', 'motorola', 'smartphone', 'blackberry', 'playstation portable', 'tablet browser');
$agent = strtolower( $_SERVER['HTTP_USER_AGENT'] );
foreach ($phone_array as $value) { if ( strpos($agent, $value) !== false ) return true;}return false;}

if(check_smartphone() == "false"){
$syspdng = 3;
}else{
$syspdng = 5;
}
$sysmdng = time() - ($_SESSION[$set_dg1]-394534293534488);
if(($vtorajapm == $set_dg1 && $sysmdng <= $syspdng) || $api_settings['set_diz']==0){

echo'<a style="display: none;">
.test{
color: #fff; 
} 

body {
background: #8ec1da url(style_images/bg.jpg) fixed;
margin: 0 auto;
max-width: 700px;
font-size: 13px;
color: #16223b;
font-family: Arial;
}

a, a:link, a:active, a:visited {
color: #39728a;
text-decoration: none;
}

a:hover {
text-decoration: none;
}

.headmenu, .foot {
background: #24627b;
}

a.headmenulink {
display: inline-block;
padding: 12px;
color: #bddeed;
text-decoration: none;
}

a.headmenulink:hover {
color: #f2fbff;
background: #326c85 url(style_images/headmenulinkhover.gif) no-repeat bottom;
}

a.headbut {
padding: 6px 12px;
background: #3e7c96 url(style_images/aheadbut.gif) repeat-x top;
color: #fff;
margin: 0 4px;
-khtml-border-radius: 3px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
border-radius: 3px;
text-decoration: none;
}

a.headbut:hover {
background: #5790a1 url(style_images/aheadbuthover.gif) repeat-x top;
}

.apicms_content{
background: #5790a1;
color: #fff;
padding: 10px;
border-top: 1px solid #437e8f;
border-bottom: 1px solid #6da1b0;
}

.apicms_menu{
background: #5790a1;
color: #fff;
padding: 10px;
border-top: 1px solid #437e8f;
border-bottom: 1px solid #6da1b0;
}

.descr{
background: #6b9dac;
padding: 4px 8px;
font-size: 12px;
margin-top: 5px;
-khtml-border-radius: 3px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
border-radius: 3px;
border: 1px solid #4f899a;
}

.erors {
color: #ffffff;
padding:7px;
background-color: #CC1559;
text-align: center;
border-top: 1px #ffffff solid;
border-bottom: 1px #e8e8ea solid;
display: block;
}

.newstitle {
display: inline-block;
background: #24627b;
padding: 5px 10px;
-khtml-border-radius: 5px;
-moz-border-radius: 5px;
-webkit-border-radius: 5px;
border-radius: 5px;
font-size: 14px;
}

.txt {
margin: 3px;
}

.linksbar {
}

.linksbar a {
display: inline-block;
background: #efefef url(style_images/linksbara.gif) repeat-x top;
margin: 3px 0;
color: #24627b;
padding: 6px 10px;
-khtml-border-radius: 3px;
-moz-border-radius: 3px;
-webkit-border-radius: 3px;
border-radius: 3px;
text-decoration: none;
}

.linksbar a:hover {
background: #d2e9ef url(style_images/linksbarahover.gif) repeat-x top;
}

.apicms_subhead {
color: #39728a;
padding:7px;
background-color: #f5f5f5;
border-top: 1px #ffffff solid;
border-bottom: 1px #e8e8ea solid;
display: block;
}

.apicms_subhead:hover {  
color: #2c5f75;
padding:7px;
background-color: #f1f1f1;
border-top: 1px #ffffff solid;
border-bottom: 1px #e8e8ea solid;
display: block;
}

.apicms_titles {
color: #39728a;
padding:7px;
background-color: #f5f5f5;
border-top: 1px #ffffff solid;
border-bottom: 1px #e8e8ea solid;
display: block;
}

.apicms_menu_s{
color: #39728a;
padding:7px;
background-color: #f5f5f5;
border-top: 1px #ffffff solid;
border-bottom: 1px #e8e8ea solid;
display: block;
}

.apicms_menu_s:hover{  
color: #2c5f75;
padding:7px;
background-color: #f1f1f1;
border-top: 1px #ffffff solid;
border-bottom: 1px #e8e8ea solid;
display: block;
}

.apicms_ads {
color: #39728a;
padding:7px;
background-color: #f5f5f5;
border-top: 1px #ffffff solid;
border-bottom: 1px #e8e8ea solid;
display: block;
}

.apicms_comms {
color: #39728a;
padding:7px;
background-color: #f5f5f5;
border-top: 1px #ffffff solid;
border-bottom: 1px #e8e8ea solid;
display: block;
}

.apicms_footer {
color: #39728a;
padding:7px;
background-color: #f5f5f5;
border-top: 1px #ffffff solid;
border-bottom: 1px #e8e8ea solid;
display: block;
}

.apicms_dialog{
background: #5790a1;
color: #fff;
padding: 10px;
border-top: 1px solid #437e8f;
border-bottom: 1px solid #6da1b0;
}

.loghead {
padding: 12px;
font-size: 12px;
color: #ffffff;
text-decoration: none;
background: #326c85 url(style_images/foothover.gif) no-repeat top;
}

.logo {
padding: 7px;
font-size: 12px;
color: #ffffff;
text-decoration: none;
background: #326c85;
}

.foot {
text-align: right;
}

.foot a {
display: inline-block;
padding: 12px;
font-size: 12px;
color: #bddeed;
text-decoration: none;
}

.foot a:hover {
background: #326c85 url(style_images/foothover.gif) no-repeat top;
color: #f2fbff;
}

form {
padding: 0;
margin: 0;
}

input, select, textarea {
font-size: 13px;
-khtml-border-radius: 5px;
-moz-border-radius: 5px;
-webkit-border-radius: 5px;
border-radius: 5px;
background: #fff url(style_images/input.gif) repeat-x top;
border: 1px solid #326d85;
padding: 6px 10px;
}

input[type=submit],input[type=button] {
background: #24627b url(style_images/inputbutton.gif) repeat-x top;
border: 1px solid #24627b;
color: #fff;
}

.class span {
float: left;
}

img {
vertical-align: middle;
}

table {
font-size: 12px;
}

.test{
color: #fff; 
} 
</a>';
}else{
include ('error/404.php');
}
session_destroy();
?>