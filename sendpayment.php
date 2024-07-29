<?php
require_once 'processing.php';
header('Content-type: text/plain; charset=utf-8');
$file_id = 'AgACAgIAAxkBAAIEQWYjs6GPIMEK3-cBqvWmHZ3UCUKzAAKO1jEbPewgSa38o5GtDvLHAQADAgADeQADNAQ';
#$chat_id = '111895196';
send_photo($chat_id,$file_id);
$data = "Мужчины, не забываем про взносы.\n".
"Отправлять на ТИНЬКОФФ\n" . 
"по номеру карты:\n" . 
"2200 7010 2268 1248\n" . 
"или по телефону (можно через СБП):\n" . 
"8(916)309-47-96" . "\n" . 
"на имя Александр Александрович П.\n" . 
"В сообщении указывайте\n" . 
"от кого ( Фамилия Имя )";
send_message($chat_id, $data);