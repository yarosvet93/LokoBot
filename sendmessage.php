<?php
require_once 'processing.php';
header('Content-type: text/plain; charset=utf-8');
//$chat_id_my = '287781777';
$chat_id = '111895196';
$message = 'Тестирую';
send_message($chat_id,$message);