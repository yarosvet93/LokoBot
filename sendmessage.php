<?php
require_once 'config.php';
require_once 'src/Messages.php';
use Source\Action\Message;
header('Content-type: text/plain; charset=utf-8');
//$chat_id_my = '287781777';
$chat_id = '111895196';
$message = 'Тестирую';
$data = [
	'chat_id' => $chat_id,
    'text' => $message
];
$url2 = $url . "/sendMessage?" . http_build_query($data);
$response = Message::send($url2);
$db->exec("INSERT INTO tb_json (update_id, update_text) VALUES ('sendtext','$response')"); 
