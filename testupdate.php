<?php
require_once 'config.php';
//require_once 'database.php';
header('Content-type: text/plain; charset=utf-8');

$url = 'https://api.telegram.org/bot/getUpdates?offset=-1';

$asnwer = '{"update_id":434276469,"poll_answer":{"poll_id":"5208886158485881335","user":{"id":111895196,"is_bot":false,"first_name":"u042fu0440u043eu0441u0432u0435u0442","last_name":"u041du043eu0432u0438u043au043eu0432","username":"yarosvet93","language_code":"ru","is_premium":true},"option_ids":[2]}}';
$update = json_decode($asnwer, TRUE);
$poll = $update['poll_answer'];
$poll_id = $poll['poll_id'];
$user_id = $poll['user']['id'];
$username = $poll['user']['username'];
$first_name = $poll['user']['first_name'];
$last_name = $poll['user']['last_name'];
$poll_answer = $poll['option_ids'][0];
if ($poll_answer === null){ $poll_answer = 9;}
//print_r ($poll_answer);

$select_user_check= "SELECT id FROM tb_players WHERE id_user = " . $user_id ;
    $query = $db->query_once($select_user_check);
    // id for visit table
    $id = $query['id'];
//print_r ($id);
$select_user = $db->query_once("SELECT id FROM tb_visit WHERE id_training = '$poll_id' AND id = '$id'");
$select_training =  $db->query_once("SELECT id_poll FROM tb_trainings WHERE id_poll = '$poll_id'");
//print_r ($select_training['id_poll']);
 if ($select_user['id']){
     $db->exec("UPDATE tb_visit SET value_t = '$poll_answer' 
     WHERE id_training = '$poll_id' AND id = '$id'");
 }else {
     if ($select_training['id_poll']){
         $db->exec("INSERT INTO tb_visit (id, id_training, value_t) 
             VALUES ('$id' , '$poll_id' , '$poll_answer')");
    }
 } 

?>