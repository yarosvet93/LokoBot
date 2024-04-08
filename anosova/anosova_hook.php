<?php
require_once 'processing.php';
header('Content-type: text/plain; charset=utf-8');
$asnwer = file_get_contents("php://input");
$update = json_decode($asnwer, TRUE);
$update_id= $update['update_id'];
if  (!(check_update_id ($update))){ 
    insert_json ($asnwer,$update_id);
}
$callback = $update['callback_query'];
$message = $update['message'];

if ($callback){
    keyboard_callback($update);
}
if ($message){
    $chat_id = $message['chat']['id'];
    $message = define_message($update);
    if ($message[0] == 'help'){
        keyboard_send ($update);
    }
    if ($message[0] == '/start'){
        keyboard_send ($update);
    }
}