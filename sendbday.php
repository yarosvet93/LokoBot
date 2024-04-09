<?php
require_once 'processing.php';
header('Content-type: text/plain; charset=utf-8');
//$chat_id_my = '287781777 Овчинников Владимир';
$morrow= strtotime("+1 day");
$date = date("m-d",$morrow);
$chat_id = '287781777';
$message ='';
$check_bday = $db->query("SELECT * FROM tb_players WHERE DATE_FORMAT(bday, '%m-%d') = '$date'");
if (!empty($check_bday)){ 
    foreach ($check_bday AS $d){ $message = $message . $d['fio'] . "\n";}
    $message = "ЗАВТРА день рождения у:\n" . $message;
    $data = http_build_query(['chat_id' => $chat_id, 'text' => $message]);
    $response = backslash_to_mysql(file_get_contents($url . "/sendMessage?" . $data));
    $db->exec("INSERT INTO tb_json (update_id, update_text) VALUES ('sendtext','$response')"); 
    }