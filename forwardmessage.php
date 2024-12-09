<?php
require_once 'processing.php';
header('Content-type: text/plain; charset=utf-8');
$date_t = date('Y-m-d');
$chat_id = '-1001553901498';
$chat_id_loco = '-1001677847049';
$query = $db->query_once("SELECT id_poll_message FROM tb_trainings WHERE date_t = '$date_t'");
$message_id = $query['id_poll_message'];
forwardmessage($chat_id_loco,$chat_id,$message_id);