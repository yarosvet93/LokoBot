<?php
$config = require_once 'config.php';
$data = http_build_query([
    'text' => 'Yes - No - Stop?',
    'chat_id' => '111895196'
]);

// Create keyboard
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
            ]
        ]
    ]
]);

$url = $url . "/sendMessage?{$data}&reply_markup={$keyboard}";
$res = @file_get_contents($url);

$db->exec("INSERT INTO update_json (update_text) VALUES ('$res')");

//$select = "SELECT * FROM update_json";
//$config = $db->query_once($select);
//print_r ($config);