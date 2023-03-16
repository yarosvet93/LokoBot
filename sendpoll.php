<?php
require_once 'config.php';
require_once 'src/Messages.php';
use Source\Action\Message;
header('Content-type: text/plain; charset=utf-8');
$weekday= date('l');
$week = date('W');
switch ($weekday) {
    case 'Monday':
        $place = $Monday;
        break;
    case 'Wednesday':
        $place = $Wednesday;
        break;
    case 'Friday':
        $place = $Friday;
        break;
};

$string = date('d m Y');
$pattern = '/([0-9])([0-9]) ([0-9])([0-9]) ([0-9])([0-9])([0-9])([0-9])/i';
$replacement = '${_${1}}${_${2}} ${_${3}}${_${4}} ${_${5}}${_${6}}${_${7}}${_${8}}';
$str1 = preg_replace($pattern, $replacement, $string);
eval("\$str1 = \"$str1\";");
$options =  array("$yes $plus","$no $minus","$sick $pill") ;
$data = [
	'chat_id' => $chat_id_my,
	'question' => $str1 . '
	' . $rugby . ' Тренировка ' . $place . '
	' . $time_clock . ' ' . $time_t,
	'options' => json_encode($options),
    'is_anonymous' => 'false'
];
$url = $url . "/sendPoll?" . http_build_query($data);
$response = Message::send($url);
$update = json_decode($response, true);
$update_id = $update['result'];
$poll_id = $update['result']['poll']['id'];
$poll_message = $update['result']['message_id'];
$chat_id = $update['result']['chat']['id'];
$date_t = date('Y-m-d');
$db->exec("INSERT INTO tb_trainings (id_poll, id_poll_message, date_t, week,gender) 
VALUES ('$poll_id', '$poll_message','$date_t','$week','1')");
$db->exec("INSERT INTO tb_json (update_id, update_text) VALUES ('sendpoll','$response')"); 
?>