<?php
require_once 'processing.php';
header('Content-type: text/plain; charset=utf-8');
$file_id = 'AgACAgIAAxkBAAIGYWfINylJgb7kaRZ3pSA-v8CtGdxfAAKe6jEbEQNJSg41dYli-pepAQADAgADeQADNgQ';
#$chat_id = '111895196';
send_photo($chat_id,$file_id);
$data = "Мужчины, напоминаю о возносах!\n".
"Оплата до 15 числа ‼️\n\n" . 
"Сумма - 2500р/месяц\n\n" . 
"500р/месяц*\n\n\n" . 
"Отправлять на ТБАНК\n\n" . 
"💳 по номеру карты: 👇\n" .
"<code>           2200 7001 5281 2763</code>\n\n" . 
"📎 или через сайт: 👇\n" . 
'https://www.tbank.ru/rm/r_lfwAHXWqDG.nlkeHfkEwA/UTHN534456' . "\n\n" . 
"☎️ или по телефону👇 (можно через СБП):\n" .
"<code>           +79265533337</code> \n".
"на имя Роман Игоревич О.\n\n" .
"В сообщении указывайте\n" .
"от кого ( Фамилия Имя )\n\n" .
"*<i>для болеющих больше недели, или не посещающих членов клуба</i>\n";
send_message($chat_id, $data);