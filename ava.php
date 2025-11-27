<?php 

/////////////////подключаем ядро и шапку
////////////////////////////////////////
$title = 'Загрузка аватарки';
require_once 'api_core/apicms_system.php';
require_once 'design/styles/'.htmlspecialchars($api_design).'/head.php';
////////////////////////////////////////
# авторизовался
if ($user['id']){
echo '<div id="text">';
////////////////////////////////////////
global $connect;
$user_r = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '".intval($user['id'])."'");
$users = mysqli_fetch_array($user_r);
////////////////////////////////////////
# Вывод аватара
echo '<div class="apicms_subhead"><center>';
echo apicms_ava64($user['id']);
echo '</center></div>';
	
if (isset($_FILES['file'])){
if (preg_match('#\.jpe?g$#i',$_FILES['file']['name']) && $imgc=@imagecreatefromjpeg($_FILES['file']['tmp_name'])){
if (imagesx($imgc)>1 || imagesy($imgc)>256){
				$img_x=imagesx($imgc);
				$img_y=imagesy($imgc);

				if ($img_x==$img_y)
				{
					$dstW=256; // ширина
					$dstH=256; // высота 
				}
				elseif ($img_x>$img_y)
				{
					$prop=$img_x/$img_y;
					$dstW=256;
					$dstH=ceil($dstW/$prop);
				}else{
					$prop=$img_y/$img_x;
					$dstH=256;
					$dstW=ceil($dstH/$prop);
				}

				$screen=imagecreatetruecolor($dstW, $dstH);
				imagecopyresampled($screen, $imgc, 0, 0, 0, 0, $dstW, $dstH, $img_x, $img_y);
				imagedestroy($imgc);
				$avs=glob($_SERVER['DOCUMENT_ROOT'].'/files/ava/'.$user['id'].'*');
				if ($avs)
				{
					foreach ($avs as $value)
					{
						@chmod($value,0777);
						@unlink($value);
					}
				}
				imagejpeg($screen,$_SERVER['DOCUMENT_ROOT'].'/files/ava/'.$user['id'].'.jpg',100);
				@chmod($_SERVER['DOCUMENT_ROOT'].'/files/ava/'.$user['id'].'.jpg',0777);
				imagedestroy($screen);
}else{
copy($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/files/ava/'.$user['id'].'.jpg');
}
$err .= '<div class="erors"><center>Аватар успешно установлен</center></div>';
}
elseif (preg_match('#\.gif$#i',$_FILES['file']['name']) && $imgc=@imagecreatefromgif($_FILES['file']['tmp_name']))
{
$avs=glob($_SERVER['DOCUMENT_ROOT'].'/files/ava/'.$user['id'].'*');
if ($avs)
{
foreach ($avs as $value)
{
@chmod($value,0777);
@unlink($value);
}
}

copy($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/files/ava/'.$user['id'].'.gif');
@chmod($_SERVER['DOCUMENT_ROOT'].'/files/ava/'.$user['id'].'.gif',0777);

$err .= '<div class="erors"><center>Аватар успешно установлен</center></div>';
}
elseif (preg_match('#\.png$#i',$_FILES['file']['name']) && $imgc=@imagecreatefrompng($_FILES['file']['tmp_name']))
{
if (imagesx($imgc)>256 || imagesy($imgc)>256)
{

					$img_x=imagesx($imgc);
					$img_y=imagesy($imgc);
					if ($img_x==$img_y)
					{
					$dstW=256; // ширина
					$dstH=256; // высота 
					}
					elseif ($img_x>$img_y)
					{
					$prop=$img_x/$img_y;
					$dstW=256;
					$dstH=ceil($dstW/$prop);
					}
					else
					{
					$prop=$img_y/$img_x;
					$dstH=256;
					$dstW=ceil($dstH/$prop);
					}

					$screen=ImageCreate($dstW, $dstH);
					imagecopyresampled($screen, $imgc, 0, 0, 0, 0, $dstW, $dstH, $img_x, $img_y);
					imagedestroy($imgc);

					$avs=glob($_SERVER['DOCUMENT_ROOT'].'/files/ava/'.$user['id'].'*');
					if ($avs)
					{
						foreach ($avs as $value)
						{
							@chmod($value,0777);
							@unlink($value);
						}
					}


					imagepng($screen,$_SERVER['DOCUMENT_ROOT'].'/files/ava/'.$user['id'].'.png');
					@chmod($_SERVER['DOCUMENT_ROOT'].'/files/ava/'.$user['id'].'.png',0777);
					imagedestroy($screen);
}else{
copy($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/files/ava/$user[id].png");
}

$err .= '<div class="erors"><center>Аватар успешно установлен</center></div>';
}else{
$err .= '<div class="erors"><center>Неверный формат</center></div>';
}
}
echo '</div>';
apicms_error($err);
////////////////////////////////////////
echo '<div class="apicms_subhead"><center><div id="text"><form method="post" enctype="multipart/form-data" action="">
<a><input type="file" name="file" accept="image/*,image/gif,image/png,image/jpeg" /></a>
<input value="Загрузить" type="submit" /></form></div></center></div>';
////////////////////////////////////////
# окончилась сессия авторизации
} else {
echo '<div class="erors">Извините у вас нет прав для загрузки аватара</div>';
}
////////////////////////////////////////
require_once 'design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>