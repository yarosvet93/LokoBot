<?php
require_once 'config.php';
header('Content-type: text/plain; charset=utf-8');
//$chat_id_my = '287781777';
$chat_id = '111895196';
$message = 'Тестирую';
$data = http_build_query([
	'chat_id' => $chat_id,
    'text' => $message
]);
$response = file_get_contents($url . "/sendMessage?" . $data);
$db->exec("INSERT INTO tb_json (update_id, update_text) VALUES ('sendtext','$response')"); 
