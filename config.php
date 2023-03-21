<?php
 require_once(__DIR__.'/vendor/autoload.php');
 use Source\Action\Database;
 $db = new Database();
 //print_r($db);
$select = "SELECT * FROM tb_config";
$config = $db->query_once($select);
// // monday wednesday friday chat_id chat_id_my chat_id_anosova chat_id_boltovnya apitoken apitoken_anosova apitoken_lokochat time_t
$Monday = $config['monday'];
$Wednesday = $config['wednesday'];
$Friday = $config['friday'];
$chat_id_girl =  $config['chat_id_girl'];
$chat_id = $config['chat_id']; # Boltovnya
$chat_id_my =  $config['chat_id_my'];
$chat_id_anosova = $config['chat_id_anosova']; # anosova
$chat_id_treni = $config['chat_id_treni'];
$time_t = $config['time_t'];
$apiToken = $config['apitoken'];
$apiToken_Anosova = $config['apitoken_anosova'];
$apiToken_LokoChat = $config['apitoken_lokochat'];
$testurl = "https://api.telegram.org/bot$apiToken_Anosova";
$url = "https://api.telegram.org/bot$apiToken";
$rugby = "\xF0\x9F\x8F\x89";
$time_clock = "\xE2\x8F\xB0";
$plus = "\xE2\x9E\x95";
$minus = "\xE2\x9E\x96";
$pill = "\xF0\x9F\x92\x8A";
$_1 = "\x31\xE2\x83\xA3";
$_2 = "\x32\xE2\x83\xA3";
$_3 = "\x33\xE2\x83\xA3";
$_4 = "\x34\xE2\x83\xA3";
$_5 = "\x35\xE2\x83\xA3";
$_6 = "\x36\xE2\x83\xA3";
$_7 = "\x37\xE2\x83\xA3";
$_8 = "\x38\xE2\x83\xA3";
$_9 = "\x39\xE2\x83\xA3";
$_0 = "\x30\xE2\x83\xA3";
$yes = "Буду";
$no = "Нет";
$sick = "Болею";
$answer_add = "Add user in tb_players :%0A/addplayer;id;username;fname;sname;F I O %0A";
?>