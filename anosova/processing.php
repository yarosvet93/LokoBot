<?php
require_once 'config.php';

function check_update_id ($update){
    global $db;
    $update_id= $update['update_id'];
    $check_update = $db->query_once("SELECT update_id FROM update_json WHERE update_id = '$update_id'");
    return $check_update;
}

function backslash_to_mysql ($result){
    $pattern ='/(\\\)/';
    $replacement='\\\\\\';
    $file = preg_replace($pattern, $replacement, $result);
    return $file;

}

function insert_json ($json_str, $update_id = NULL ){
    global $db;
    $json_str_result = backslash_to_mysql($json_str);
    $db->exec("INSERT INTO update_json (update_id, update_text) VALUES ('$update_id','$json_str_result')");    
}

function keyboar_select ($level){
    if ($level =='1'){
        $keyboard = json_encode([
            "inline_keyboard" => [
                [
                    [
                        "text" => "Yes",
                        "callback_data" => "yes"
                    ],
                    [
                        "text" => "No",
                        "callback_data" => "no"
                    ],
                    [
                        "text" => "Stop",
                        "callback_data" => "stop"
                    ],
                    [
                        "text" => "Next",
                        "callback_data" => "next"
                    ]
                ]
            ]
        ]);
    }
    if ($level =='2'){
        $keyboard = json_encode([
            "inline_keyboard" => [
                [
                    [
                        "text" => "Yes",
                        "callback_data" => "yes"
                    ],
                    [
                        "text" => "No",
                        "callback_data" => "no"
                    ],
                    [
                        "text" => "Back",
                        "callback_data" => "back"
                    ]
                ]
            ]
        ]);
    }
    return $keyboard;
}

function define_message($update)  {
        $text = $update['message'];
        $start = '/start';
        $str1 = "help";
        $str2 = "addplayer";
        $str3 = "test";
        //$str4 = "add";
        $str5 = "disable";
        $str6 = "enable";
        $str7 = "date";
        $array = array("$start", "$str1", "$str2", "$str3","$str5", "$str6", "$str7");
        $pieces = explode(";", $text['text']);
        return $pieces;
    }

function keyboard_callback ($update) {
    global $url;
    $callback = $update['callback_query'];
    $chat_id = $callback['from']['id'];
    $message_id = $callback['message']['message_id'];
    $back_data = $callback['data'];
    //STOP

    if ($back_data === 'stop') {
        $data = http_build_query([
            'text' => 'Пока долбоеб!',
            'chat_id' => $chat_id,
            'message_id' => $message_id
        ]);
        $alter_res = @file_get_contents( $url . "/editMessageText?{$data}");
    }
    
    if ($back_data === 'yes') {
        $data = http_build_query([
            'text' => 'Yes',
            'chat_id' => $chat_id
        ]);
        $url = $url . "/sendMessage?" . $data;
        file_get_contents($url);
    }
    
    if ($back_data === 'no') {
        $data = http_build_query([
            'text' => 'no',
            'chat_id' => $chat_id
        ]);
        $url = $url . "/sendMessage?" . $data;
        file_get_contents($url);
    }
    
    if ($back_data === 'next') {
        $data = http_build_query([
            'text' => 'Yes2 - No2 - Back?',
            'chat_id' => $chat_id,
            'message_id' => $message_id
        ]);
        $keyboard = keyboar_select('2');
        $url = $url . "/editMessageText?{$data}&reply_markup={$keyboard}";
        $res = @file_get_contents($url);
        return $res;
    }
    if ($back_data === 'back') {
        $data = http_build_query([
            'text' => 'Yes - No - Stop -Next?',
            'chat_id' => $chat_id,
            'message_id' => $message_id
        ]);
        $keyboard = keyboar_select('1');
        $url = $url . "/editMessageText?{$data}&reply_markup={$keyboard}";
        $res = @file_get_contents($url);
        return $res;
    }
}

function keyboard_send ($update) {
    $chat_id = $update['message']['chat']['id'];
    global $url;
    $data = http_build_query([
        'text' => 'Yes - No - Stop -Next?',
        'chat_id' => $chat_id
    ]);
    
    // Create keyboard
    $keyboard = keyboar_select('1');
    
    $url = $url . "/sendMessage?{$data}&reply_markup={$keyboard}";
    $res = @file_get_contents($url);
    insert_json ($res);
    return $res;      
}

?>