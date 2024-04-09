<?php
require_once 'config.php';
header('Content-type: text/plain; charset=utf-8');
//$chat_id_my = '287781777';
$file_id = 'AgACAgIAAx0CXJ6nugACEm1kFHnirgLN21ztdn96c4UZvHAjjgAC8cUxG8HTqEhEoBHwY4L2NgEAAwIAA3MAAy8E';
//S$chat_id = '111895196';
$data = http_build_query([ 'chat_id' => $chat_id,'photo' => $file_id]);	
$response = file_get_contents($url . "/sendMessage?" . $data);
$db->exec("INSERT INTO tb_json (update_id, update_text) VALUES ('sendPhoto','$response')"); 
$data = "Мужчины, не забываем про взносы.\n".
"Отправлять на ТИНЬКОФФ\n" . 
"по номеру карты:\n" . 
"2200 7010 2268 1248\n" . 
"или по телефону (можно через СБП):\n" . 
"8(916)309-47-96" . "\n" . 
"на имя Александр Александрович П.\n" . 
"В сообщении указывайте\n" . 
"от кого ( Фамилия Имя )";
$data = http_build_query([ 'chat_id' => $chat_id,'text' => $file_id]);	
$response = file_get_contents($url . "/sendMessage?" . $data);
$db->exec("INSERT INTO tb_json (update_id, update_text) VALUES ('sendtext','$response')");