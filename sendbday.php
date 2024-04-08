<?php
require_once 'config.php';
require_once 'src/Messages.php';
use Source\Action\Message;
header('Content-type: text/plain; charset=utf-8');
//$chat_id_my = '287781777 Овчинников Владимир';
$morrow= strtotime("+1 day");
$date = date("m-d",$morrow);
$chat_id = '287781777';
$message ='';
$check_bday = $db->query("SELECT * FROM tb_players WHERE DATE_FORMAT(bday, '%m-%d') = '$date'");
if (!empty($check_bday)){
    foreach ($check_bday AS $d){
        $message = $message . $d['fio'] . "\n";
    }
    $message = 'ЗАВТРА день рождения у:' . "\n" . $message;
    $data = [
        'chat_id' => $chat_id,
        'text' => $message
    ];
    $url2 = $url . "/sendMessage?" . http_build_query($data);
    $response = Message::send($url2);
    $db->exec("INSERT INTO tb_json (update_id, update_text) VALUES ('sendtext','$response')"); 
    }