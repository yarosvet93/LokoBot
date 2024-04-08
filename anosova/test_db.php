<?php
require_once 'database.php';
$db = new Database();

$check_update = $db->query_once("SELECT update_text FROM update_json WHERE id IN (127,128,129)");
$update = json_decode($check_update['update_text']);
print_r($update);


?>