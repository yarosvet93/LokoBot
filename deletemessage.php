<?php
require_once 'processing.php';
header('Content-type: text/plain; charset=utf-8');
$chat_id = '-1001592280069';
$message_id = '972';

delete_message ($chat_id,$message_id);