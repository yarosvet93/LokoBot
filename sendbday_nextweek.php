<?php
require_once 'processing.php';
header('Content-type: text/plain; charset=utf-8');
//$chat_id_my = '267638282 Овчинников Владимир';
$nextweek= strtotime("+7 day");
$date_nextweek = date("m-d",$nextweek);
$date = date("m-d");
$chat_ids = array ("111895196" ,"267638282" ,"287781777","261332126");
$message ='';

$check_bday = $db->query("SELECT * FROM tb_players WHERE DATE_FORMAT(bday, '%m-%d') between '$date' and '$date_nextweek'");
if (!empty($check_bday)){ 
    foreach ($check_bday AS $d){ $message = $message . $d['fio'] . " - " . $d['bday'] ."\n";}
    $message = "На следущей неделе день рождения у:\n" . $message;
    foreach ($chat_ids as $chat_id) {
        $data = http_build_query(['chat_id' => $chat_id, 'text' => $message]);
        $response = backslash_to_mysql(file_get_contents($url . "/sendMessage?" . $data));
        $db->exec("INSERT INTO tb_json (update_id, update_text) VALUES ('sendbday_week','$response')"); 
        print_r($response);
        sleep(1);
    }
}