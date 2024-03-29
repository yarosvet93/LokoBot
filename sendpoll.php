<?php
require_once 'config.php';
require_once 'src/Messages.php';
require_once 'src/Poll.php';
use Source\Action\Message;
use Source\Action\Poll;
header('Content-type: text/plain; charset=utf-8');
$data = [
	'chat_id' => $chat_id,
	'question' => Poll::getPollQuestion(),
	'options' => Poll::getPollOption(),
    'is_anonymous' => 'false'
];
$url = $url . "/sendPoll?" . http_build_query($data);
$response = Message::send($url);
$get = Poll::getJsonPoll($response);
$poll_id = $get['poll_id'];
$poll_message = $get['poll_message'];
$chat_id = $get['chat_id'];
$date_t = date('Y-m-d');
//$date_t = date("Y-m-d", strtotime("-1 day"));
$week = date('W');
$db->exec("INSERT INTO tb_trainings (id_poll, id_poll_message, date_t, week,gender) 
VALUES ('$poll_id', '$poll_message','$date_t','$week','1')");
$db->exec("INSERT INTO tb_json (update_id, update_text) VALUES ('sendpoll','$response')"); 
?>