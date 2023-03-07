<?php
require_once 'config.php';
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
	'chat_id' => $chat_id,
	'question' => $str1 . '
	' . $rugby . ' Тренировка ' //. $place . '
	 . $time_clock . ' ' . $time_t,
	'options' => json_encode($options),
    'is_anonymous' => 'false'
];
$url = "https://api.telegram.org/bot$apiToken/sendPoll?" . http_build_query($data);
$curl_handle=curl_init();
curl_setopt($curl_handle, CURLOPT_URL, $url);
curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_USERAGENT, 'LocoBot');
$response = curl_exec($curl_handle);
curl_close($curl_handle);
$update = json_decode($response, true);
$poll_id = $update['result']['poll']['id'];
$poll_message = $update['result']['message_id'];
$chat_id = $update['result']['chat']['id'];
$date_t = date('Y-m-d');
$db->exec("INSERT INTO tb_trainings (id_poll, id_poll_message, date_t, week) 
VALUES ('$poll_id', '$poll_message','$date_t','$week')");
?>
