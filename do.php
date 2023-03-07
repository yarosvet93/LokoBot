<!DOCTYPE html>
    <meta charset="UTF-8" name="viewport" content="width=device-width; initial-scale=1.0">
    <head>
        <?php
            require_once 'database.php';
            $db = new Database();
        ?>
        <style>
            <?php include 'myslyle.css'; ?>
        </style>
    </head>
    <body>
        <div class="body_box">
            <form action="input.php" target="">
                <button>Вернуться на страницу ввода</button>
            </form> 
            <?php
            if(isset($_POST['player'])){
                $player = $_POST['player'];
                if (!($player)){
                    echo "Вернись и укажи пользователя";
                }
                if (isset($_POST['count'])){
                    $add_value = "AND value_t = 0";
                } else  {
                    $add_value = "";
                }
                
                $date_start = $_POST['date_start'];  
                $date_end = $_POST['date_end']; 
                $player_select = "SELECT fsname FROM tb_players WHERE id = $player";
                $player_query = $db->query($player_select);
                echo "<h4>" . $player_query['fsname'] . "</h4>";

                $select = "SELECT fsname,date_t,value_v FROM tb_visit AS vt
                                JOIN tb_players AS p ON vt.id=p.id
                                JOIN tb_trainings AS t ON vt.id_training=t.id_poll
                                JOIN tb_value AS v ON vt.value_t=v.id_v
                                WHERE p.id='$player'
                                AND date_t BETWEEN '$date_start' AND '$date_end'" . $add_value ;
                // print_r($value_visit);
                $query = $db->query($select);
                echo '<div class="table_result">';
                echo '<table>';
                    echo '<tr>';
                        echo '<th>Дата</th>';
                        echo '<th>Присутсвие</th>';
                    echo '</tr>';
                foreach ($query AS $b){ 
                    echo "<tr>";
                                echo "<td>" . date('d.m.Y', strtotime($b['date_t'])) . "</td>";
                                echo "<td>" . $b['value_v'] . "</td>";
                            echo "</tr>";
                }
                echo '</div>'; 
            }
            if(isset($_POST['visit_d'])){
                $data = $_POST['date']; 
                $select = "SELECT fsname,date_t,value_v FROM tb_visit AS vt
                                JOIN tb_players AS p ON vt.id=p.id
                                JOIN tb_trainings AS t ON vt.id_training=t.id_poll
                                JOIN tb_value AS v ON vt.value_t=v.id_v
                                WHERE date_t = '$data'";
                $query = $db->query($select);
                echo '<div class="table_result">';
                    echo "<h4>" . date('d.m.Y', strtotime($data)). "</h4>";
                    echo '<table border="5" >';
                        echo '<tr>';
                            echo '<th>ИМЯ</th>';
                            echo '<th>Присутсвие</th>';
                        echo '</tr>';
                            foreach ($query AS $b){
                                echo "<tr>";
                                    echo "<td>" . $b['fsname'] . "</td>";
                                    echo "<td>" . $b['value_v'] . "</td>";
                                echo "</tr>";
                        }

                    echo '</table>';
                echo '</div>'; 
            }
            if(isset($_POST['all'])){
                //print_r($_POST);
                if (isset($_POST['count'])){
                    $orderby = "COUNT(vl.value_v) DESC";
                } else  {
                    $orderby = "tp.fsname";
                }
                $date_start = $_POST['date_start'];  
                $date_end = $_POST['date_end'];
                $select = " SELECT tp.fsname , COUNT(vi.value_v) AS ct FROM (
                                SELECT * FROM tb_visit AS vt 
                                    JOIN tb_trainings tt ON vt.id_training = tt.id_poll
                                    JOIN tb_value vl ON vt.value_t = vl.id_v
                                    WHERE  vt.value_t = 0 
                                    AND tt.date_t 
                                    BETWEEN '$date_start' AND '$date_end' ) AS vi
                                RIGHT JOIN tb_players tp ON vi.id = tp.id
                                GROUP BY tp.fsname
                                ORDER BY $orderby"; 
                //print_r($select);
                $query = $db->query($select);
                //print_r($query);
                echo '<div class="table_result">';
                    echo '<table>';
                        echo '<tr>';
                            echo '<th> Игрок </th>';
                            echo '<th> Всего посещений </th>';
                        echo '</tr>';
                    foreach ($query AS $b){ 
                        echo '<tr>';
                            echo '<td>' . $b['fsname'] . '</td>';
                            echo '<td>' . $b['ct'] . '</td>';
                        echo '</tr>';
                    } 
                    echo '</table>';
                echo '</div>'; 
            } 
            ?>
        </div>
    </body>
</html>