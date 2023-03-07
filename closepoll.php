<?php
require_once 'config.php';
header('Content-type: text/plain; charset=utf-8');
$date_t = date('Y-m-d');
//$date_t = date("Y-m-d", strtotime("-1 day"));
//echo $date_t;
        ///// исправить чтобы брал только опросы для тренировок /////

//echo $select_training ;
$query = $db->query("SELECT id_poll_message FROM tb_trainings WHERE date_t = '$date_t'");
foreach ($query AS $training) {
 //  print_r ($training['id_poll_message']);
 $url = "https://api.telegram.org/bot$apiToken/stopPoll?chat_id=" . $chat_id . "&message_id=" . $training['id_poll_message'];
 echo $training['id_poll_message'] ;
 $curl_handle=curl_init();
 curl_setopt($curl_handle, CURLOPT_URL, $url);
 curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
 curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($curl_handle, CURLOPT_USERAGENT, 'LocoBot');
 curl_exec($curl_handle);
 curl_close($curl_handle);
}
//file_get_contents($url."/stopPoll?chat_id=" . $chat_id . "&message_id=");
//$URIstop_poll = "https://api.telegram.org/bot" + $token + "/stopPoll?chat_id=" + $chat_id + "&message_id=" + $poolId
?>