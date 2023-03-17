<?php
require_once 'config.php';
require_once 'src/Messages.php';
require_once 'src/Poll.php';
use Source\Action\Message;
use Source\Action\Poll;
header('Content-type: text/plain; charset=utf-8');
$date_t = date('Y-m-d');
//$date_t = date("Y-m-d", strtotime("-1 day"));
//echo $date_t;
///// исправить чтобы брал только опросы для тренировок /////

//echo $select_training ;
$query = $db->query("SELECT id_poll_message FROM tb_trainings WHERE date_t = '$date_t'");
foreach ($query AS $training) {
  $data = [
    'chat_id' => $chat_id_my,
    'message_id' => $training['id_poll_message']
  ];	
$url1 =  $url . "/stopPoll?" . http_build_query($data);
$response = Message::send($url1);
$db->exec("INSERT INTO tb_json (update_id, update_text) VALUES ('closepoll','$response')"); 
$update = json_decode($response, TRUE);
$total_voter_count = $update['result']['total_voter_count'];
$id = $update['result']['id'];
$db->exec("UPDATE tb_trainings SET total_voter_count  = '$total_voter_count'  WHERE id_poll = '$id' "); 

}
//file_get_contents($url."/stopPoll?chat_id=" . $chat_id . "&message_id=");
//$URIstop_poll = "https://api.telegram.org/bot" + $token + "/stopPoll?chat_id=" + $chat_id + "&message_id=" + $poolId
?>