<?php
session_start();
$code = str_pad((string)mt_rand(0, 999), 3, '0', STR_PAD_LEFT);
$_SESSION['captcha'] = $code;
header('Content-Type: image/png');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
$w = 50; $h = 27;
$im = imagecreatetruecolor($w, $h);
$bg = imagecolorallocate($im, 240, 240, 240);
$fg = imagecolorallocate($im, 30, 30, 30);
$noise1 = imagecolorallocate($im, 200, 200, 200);
imagefilledrectangle($im, 0, 0, $w, $h, $bg);
for ($i=0; $i<10; $i++) {
    imageline($im, mt_rand(0,$w), mt_rand(0,$h), mt_rand(0,$w), mt_rand(0,$h), $noise1);
}
$font = 5;
$tw = imagefontwidth($font) * 3;
$th = imagefontheight($font);
$x = (int)(($w - $tw)/2);
$y = (int)(($h - $th)/2);
imagestring($im, $font, $x, $y, $code, $fg);
imagepng($im);
imagedestroy($im);
