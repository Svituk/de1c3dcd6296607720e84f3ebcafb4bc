<?php


$title = 'Ошибка 304';
require_once '../api_core/apicms_system.php';
 // Correct 304: no body should be sent
 http_response_code(304);
 header('X-Robots-Tag: noindex, nofollow');
 header('Content-Type: text/html; charset=UTF-8');
 exit;
?>
