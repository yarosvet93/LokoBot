<?php
require_once 'config.php';
//require_once 'database.php';
header('Content-type: text/plain; charset=utf-8');
$chatId = $chat_id;
$asnwer = file_get_contents("php://input");
$update = json_decode($asnwer, TRUE);
$update_id =$update['update_id'];
//проверям на дупликаты update_id
$check_update = $db->query_once("SELECT update_id FROM tb_json WHERE update_id = '$update_id'");
if  (!($check_update['update_id'])){ 
    $db->exec("INSERT INTO tb_json (update_id, update_text) VALUES ('$update_id','$asnwer')"); 
    //file_get_contents($url."/sendmessage?chat_id=" . $chat_id_my . "&text=Привет:" );
    // processing message (text)
    if ($update['message']){
        $text = $update['message'];
        $chat_id = $text['chat']['id'];
        $str1 = "help";
        $str2 = "addplayer";
        $str3 = "test";
        //$str3 = "stopnextday";
        //
        // остановить опрос 
        // удалить опрос
        // не создавать опрос на следующий день
        //
        $pieces = explode(";", $text['text']);
    //file_get_contents($url."/sendmessage?chat_id=" . $chat_id . "&text=  это 1 СООБЩЕНИЕ " . $asnwer);
    // add user in tb_players
    $check_admin = $text['from']['id'];
    if ($pieces[0] == $str2 and  $check_admin == '111895196'){
            $user_id = $pieces[1];
            $username = $pieces[2];
            $first_name = $pieces[3];
            $last_name = $pieces[4];
            $fio = $pieces[5];
        $db->exec("INSERT INTO tb_players (id_user, username, fname, sname, fio) 
        VALUES ('$user_id' , '$username' , '$first_name' , '$last_name' , '$fio')");   
        }
        //  Print help
        if ($pieces[0] == $str1 and  $check_admin == '111895196'){
            file_get_contents($url . "/sendmessage?chat_id=" . $chat_id . "
            &text= Add user in tb_players :%0Aaddplayer;id;username;fname;sname;F I O %0A;"); 
        }

        //if ($pieces[0] == $str3){
        //    $name = $update['message']['from']['first_name'];
        //    $db->exec("INSERT INTO tb_json (update_id, update_text) VALUES ('test','$name')"); 
        // }
    }

    if ($update['poll_answer']) {
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
            $data = [
                'chat_id' => $chat_id,
                'text' => 'Дружочек, ты не добавлен в базу:
                username = ' . $username . '
                Имя = ' . $first_name . '
                Фамилия = ' . $last_name . '
                Будешь ли на тренивке: ' . $status . '
                ____напиши @yarosvet93 свои ФИО !!!!'
            ];
            file_get_contents($url . "/sendmessage?" . http_build_query($data));
            
            $data = [
                'chat_id' => '111895196',
                'text' => 'userid =  ' . $user_id . '
                username = ' . $username . '
                Имя = ' . $first_name . '
                Фамилия = ' . $last_name
            ];
            file_get_contents($url . "/sendmessage?" . http_build_query($data));

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
}
unset($asnwer);
unset($update);
?>