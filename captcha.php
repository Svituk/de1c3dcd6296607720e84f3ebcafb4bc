<?php
require_once 'api_core/apicms_system.php';
session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");

$_SESSION['captcha']=rand(100,999);

$word = intval($_SESSION['captcha']);

$word = "$word";

$RandImg = mt_rand(1, 5);												 // случайный фон
$img = imagecreatefrompng('design/captcha_style/'.$RandImg.'.png');
$sz = getimagesize('design/captcha_style/'.$RandImg.'.png');

$size = 19; 								 							//размер шрифта
$font = 'design/captcha_style/comic.ttf'; 					 			//шрифт

for($i = 0; $i < 4; $i++)
{
    $rndX = mt_rand(0, $sz[0]);
    $rndX1 = mt_rand(0, $sz[0]);
    $rndY = mt_rand(0, $sz[1]);
    $rndY1 = mt_rand(0, $sz[1]);
    $rndX2 = mt_rand(0, $sz[0]);
    $rndX3 = mt_rand(0, $sz[0]);
    $rndY2 = mt_rand(0, $sz[1]);
    $rndY3 = mt_rand(0, $sz[1]);
    $color = mt_rand(1000, 9999999);		 							//случайный цвет
    imageline($img, $rndX, $rndY, $rndX1, $rndY1, $color); 				// линии
    imageline($img, $rndX2, $rndY2, $rndX3, $rndY3, $color);			// линии
}

for($i = 0; $i < 3; $i++)
{
    $angle = mt_rand(-20, 20); 											//угол поворота
    if ($i == 0) $x = 5;
    else $x = $x + 12; 													//смещение по горизонтали
    $y = 23; 															//смещение по вертикали
    $color = mt_rand(1000, 9999999);
    imagettftext($img, $size, $angle, $x, $y, $color, $font, $word[$i]);
}

$im = imagecreatetruecolor(50, 20);
imagecopyresampled($im, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
header('apicms_content-type: image/png');
imagegif($img);
imagedestroy($img);

?>