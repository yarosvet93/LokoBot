<?php
require_once 'config.php';
header('Content-type: text/plain; charset=utf-8');
$roma = '18';
$vova = '13';
$date = date('Y-m-d');
$message = '';
$username_roma = "@Roman_Ovchinnikov_osteo_massage";
$username_vova = "@Ovchinnikov_Vladimir"; 
#$username = $db->query("SELECT id FROM tb_visit AS v JOIN tb_trainings AS t ON v.id_training=t.id_poll WHERE date_t = '$date' AND ( value_t = 13 OR id = 18 )");

$message = $username_roma . "\n" . $username_vova . "\n" . "нужны сегодня щиты ?";
$chat_id = '111895196';
$data = http_build_query([
	'chat_id' => $chat_id,
    'text' => $message
]);
$response = file_get_contents($url . "/sendMessage?" . $data);
?>