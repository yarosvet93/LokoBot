<?php
namespace Source\Action;

class Message {

    static function send($url){
        $curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, 'LocoBot');
        $response = curl_exec($curl_handle);
        curl_close($curl_handle);
        return $response;
    }


    static function getJsonMessage($response){

        $update = json_decode($response, true);
        $poll_id = $update['result']['poll']['id'];
        $poll_message = $update['result']['message_id'];
        $chat_id = $update['result']['chat']['id'];
        return array(
            'poll_id' => $poll_id,
            'poll_message' => $poll_message,
            'chat_id ' => $chat_id
        );
    }
}

?>