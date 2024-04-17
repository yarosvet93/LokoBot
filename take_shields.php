<?php
require_once 'config.php';
$roma = '18';
$vova = '13';
$date = date('YYYY-MM-DD');
$username_roma = "@Roman_Ovchinnikov_osteo_massage";
$username_vova = "@Ovchinnikov_Vladimir"; 
$username = $db->query_once("SELECT * FROM tb_visit AS v
JOIN tb_trainings AS t ON v.id=t.id
WHERE date_t = '$date'");
print_r ($username);
?>