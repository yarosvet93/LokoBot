<?php
require_once 'config.php';
$URIupdates = "https://api.telegram.org/bot" . $apiToken . "/GetUpdates";
$update_id = NULL;
$file = file_get_contents($URIupdates);
$pattern ='/(\\\)/';
$replacement='\\\\\\';
$file = preg_replace($pattern, $replacement, $file);
$db->exec("INSERT INTO update_json (update_id, update_text) VALUES ('$update_id','$file')");
print_r($file);
?>