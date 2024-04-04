<?php
require_once 'config.php';

#$check_enabled = $db->query_once("SELECT enabled_poll FROM tb_config");
#if  ($enabled_poll == 1 ) { 
#    echo $enabled_poll; }

if  ($enabled_poll == 0 ) { $db->exec("UPDATE tb_config SET enabled_poll = 1 WHERE chat_id_my = '111895196'") ;}