<?php
require_once 'processing.php';
header('Content-type: text/plain; charset=utf-8');
$chatId = $chat_id;
// Получаем обновления
$asnwer = file_get_contents("php://input");
// Конвертируем json в массив (TRUE)
$update = json_decode($asnwer, TRUE);
// Экранируем backslash в json, для вставки в MySQL
$asnwer = backslash_to_mysql($asnwer);
$update_id =$update['update_id'];
// проверям на дупликаты update_id
$check_update = $db->query_once("SELECT update_id FROM tb_json WHERE update_id = '$update_id'");
if  (!($check_update['update_id'])){
    // если не NULL, то записываем в базу
    $db->exec("INSERT INTO tb_json (update_id, update_text) VALUES ('$update_id','$asnwer')");
    // если пришло сообщение
    if ($update['message']){
        message_proc ($update);
    }
    if ($update['poll_answer']) {
        poll_answer_proc ($update);
    }
}
// unset($asnwer);
// unset($update);
?>