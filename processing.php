<?php
require_once 'config.php';

function send_message ($chat_id,$text){
    global $url, $db;
$data = http_build_query([ 'chat_id' => $chat_id,'text' => $text,'parse_mode' => 'HTML']);	
$response = backslash_to_mysql(file_get_contents($url . "/sendMessage?" . $data));
$db->exec("INSERT INTO tb_json (update_id, update_text) VALUES ('sendText','$response')");
} 

function forwardmessage ($chat_id,$from_chat_id,$message_id){
    global $url, $db;
$data = http_build_query([ 'chat_id' => $chat_id,'from_chat_id' => $from_chat_id,'message_id' => $message_id]);	
$response = backslash_to_mysql(file_get_contents($url . "/forwardMessage?" . $data));
$db->exec("INSERT INTO tb_json (update_id, update_text) VALUES ('forwardMessage','$response')");
} 

function send_photo ($chat_id,$photo_id){
    global $url, $db;
$data = http_build_query([ 'chat_id' => $chat_id,'photo' => $photo_id]);	
$response = backslash_to_mysql(file_get_contents($url . "/sendPhoto?" . $data));
$db->exec("INSERT INTO tb_json (update_id, update_text) VALUES ('sendPhoto','$response')");
} 

function delete_message ($chat_id,$message_id){
    global $url;
$data = http_build_query([ 'chat_id' => $chat_id,'message_id' => $message_id]);	
file_get_contents($url . "/deleteMessage?" . $data);
} 

function backslash_to_mysql ($result){
    $pattern ='/(\\\)/';
    $replacement='\\\\\\';
    return preg_replace($pattern, $replacement, $result);
}

function poll_answer_proc ($update){
    global $db, $yes, $no, $sick, $url;
    $poll = $update['poll_answer'];
    $poll_id = $poll['poll_id'];
    $user_id = $poll['user']['id'];
    $username = $poll['user']['username'];
    $first_name = $poll['user']['first_name'];
    $last_name = $poll['user']['last_name'];
    $poll_answer = $poll['option_ids'][0];
    if ($poll_answer === null){ $poll_answer = 9;}
    //check user in Players Table
    $select_user_check= "SELECT id FROM tb_players WHERE id_user = " . $user_id ;
    $query = $db->query_once($select_user_check);
    // id for visit table
    $id = $query['id'];
    if (!($id)){
        switch ($poll_answer){
            case 0: $status = $yes; break;
            case 1: $status = $no; break;
            case 2: $status = $sick; break;
            case 9: $status = "Retrack Vote"; break;
        }
        $data = "userid = {$user_id}\n" .
                "username = {$username}\n" .
                "Имя = {$first_name}\n" .
                "Фамилия = {$last_name}\n" . 
                "Тренировка = {$status}\n";
        $data = http_build_query([
            'chat_id' => '111895196',
            'text' => $data
        ]);
        file_get_contents($url . "/sendmessage?" . $data);
        exit;
    }
    // add user in tb_visit or change vote
    $select_user = $db->query_once("SELECT id FROM tb_visit WHERE id_training = '$poll_id' AND id = '$id'");
    $select_training =  $db->query_once("SELECT id_poll FROM tb_trainings WHERE id_poll = '$poll_id'");
    if ($select_user['id']){
        $db->exec("UPDATE tb_visit SET value_t = '$poll_answer' 
        WHERE id_training = '$poll_id' AND id = '$id'");
    }else {
        if ($select_training['id_poll']){
            $db->exec("INSERT INTO tb_visit (id, id_training, value_t) 
                VALUES ('$id' , '$poll_id' , '$poll_answer')");
        }
    } 
}


function message_proc ($update){
    global $db, $url;
    $message = $update['message'];
    $chat_id = $message['chat']['id'];
    $start = '/start';
    $str1 = "help";
    $str2 = "addplayer";
    $str3 = "get-user";
    //$str4 = "add";
    $str5 = "disable";
    $str6 = "enable";
    $str7 = "date";
    $array = array("$start", "$str1", "$str2", "$str3","$str5", "$str6", "$str7");
    $pieces = explode(";", $message['text']);
    $check_admin = $message['from']['id'];
    $check_user = $message['from']['id'];
    if ( !(in_array($pieces[0], $array)) and !(strstr($chat_id, '-100'))){
        
        $data = "Неправильно введены данные.\n".
            "Если хочешь указать свою дату рождения, то надо вводить:\n" . 
            "date;YYYY-MM-DD\n" . 
            "date; - дикертива ввода даты (точка с запятой)\n" . 
            "YYYY - год\n" . 
            "MM - месяц\n" . 
            "DD -день\n";

        send_message($check_user,$data);
    }

         
    // if ($pieces[0] == $str4){
    //     $fio = $pieces[1];
    //     $user_id = $update['message']['from']['id'];
    //     $username = $update['message']['from']['username'];
    //     $first_name = $update['message']['from']['first_name'];
    //     $last_name = $update['message']['from']['last_name'];
    //     $check_user = $db->query_once("SELECT id FROM tb_players WHERE id_user = '$user_id'");
    //     $id = $check_user['id'];
    //     if (!($id)){
    //         $db->exec("INSERT INTO tb_players (id_user, username, fname, sname, fio) 
    //             VALUES ('$user_id' , '$username' , '$first_name' , '$last_name' , '$fio')"); 
    //         file_get_contents($url . "/sendmessage?chat_id=" . $user_id . "&text= СПС! Добавил.)");  
    //     } else {
    //         file_get_contents($url . "/sendmessage?chat_id=" . $user_id . "&text=Ты уже есть в Базе !)");
    //     }
    // }
    if ($pieces[0] == $str3 and  $check_admin == '111895196'){
        // $user_get = $db->query("SELECT * FROM tb_players");
        // $user_get_all = '';
        // foreach ($user_get AS $user){ 
        //     $user_get_all .= $user['id_user'];
        //     $user_get_all .= ' - ';
        //     $user_get_all .= $user['fio'];
        //     $user_get_all .= "\n";
        // } 
        // send_message($check_admin,$user_get_all); 

    }
    if ($pieces[0] == $str2 and  $check_admin == '111895196'){
        $user_id = $pieces[1];
        $username = $pieces[2];
        $first_name = $pieces[3];
        $last_name = $pieces[4];
        $fio = $pieces[5];
        $fi = $pieces[6];
        $db->exec("INSERT INTO tb_players (id_user, username, fname, sname, fio, fsname) 
        VALUES ('$user_id' , '$username' , '$first_name' , '$last_name' , '$fio', '$fi')");   
    }
    //  Print help
    if ($pieces[0] == $str1 and  $check_admin == '111895196'){
        $data = "Add user in tb_players:\n" . 
                "Addplayer;id;username;fname;sname;Фамилия Имя Отчество;Фамилия Имя";
                send_message($chat_id,$data);
    }

    //if ($pieces[0] == $str3){
    //    $name = $update['message']['from']['first_name'];
    //    $db->exec("INSERT INTO tb_json (update_id, update_text) VALUES ('test','$name')"); 
    // }
    if ($pieces[0] == $str5 and  $check_admin == '111895196'){
        $db->exec("UPDATE tb_config SET enabled_poll = 0 WHERE chat_id_my = '111895196'") ;
    }
    if ($pieces[0] == $str6 and  $check_admin == '111895196'){
        $db->exec("UPDATE tb_config SET enabled_poll = 1 WHERE chat_id_my = '111895196'") ;
    }

    if ($pieces[0] ==  $str7){
        $bday = $pieces[1];
        $check_bday = $db->query_once("SELECT bday FROM tb_players WHERE id_user = '$check_user'");
        $check_bday_t = $check_bday['bday']; 
        if (!empty($check_bday_t)) {
            send_message($check_user, "Твоя дата рождения:" . $check_bday_t . " !!!\nЧтобы изменить, напиши @yarosvet93");
        }else{
            if (preg_match("/(\d{4})-(\d{2})-(\d{2})/", $bday, $matches)) {
                if (checkdate($matches[2], $matches[3], $matches[1])) {
                    $db->exec("UPDATE tb_players SET bday ='$bday' WHERE id_user = '$check_user'");
                    send_message($check_user,"твоя дата рождения: " . $bday . " добавлена!!! ");                       
                } else {
                    send_message($check_user,"твоя дата рождения выходит за рамки календаря");  
                }
            } else {
                send_message($check_user,"твоя дата рождения не в формате YYYY-MM-DD"); 
            }
            

            
        }
    }
}

?>
