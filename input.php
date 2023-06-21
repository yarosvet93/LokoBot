<!DOCTYPE html>
    <meta charset="UTF-8" name="viewport" content="width=device-width; initial-scale=1.0">
    <head>
        <?php
            header('Content-type: charset=utf-8');
        ?>
        <style>
            <?php include 'myslyle.css'; ?>
        </style>
    </head>
    <body>
        <div class="body_box">

            <form class="form_action" action="index.php" target="">
                <button class="button_all">Вернуться на главную</button>
            </form> 
            <form class="form_action" action="do.php" method="post"> 
                <p>Выбери игрока и период 'ОТ' и 'ДО'</p>
                <div class="select_date">
                    <select class="select" name="player">
                        <option value=""></option>
                            <?php
                                require_once 'database.php';
                                $db = new Database();
                                $fio = "SELECT id, fsname FROM tb_players where id IN (SELECT DISTINCT(id) FROM tb_visit) ORDER BY fsname";
                                $user = $db->query($fio);
                                foreach ($user AS $a){
                                    echo "<option value=" . $a['id'] .">" . $a['fsname'] . "</option>";
                                }
                        ?>
                    </select>
                </div>
                <div class="select_date">
                    <input id="date" type="date" value="2023-01-09" name="date_start">
                </div>
                <div class="select_date">
                    <input id="date" type="date" value="<?php echo date('Y-m-d'); ?>" name="date_end">
                </div>
                <div class="select_date">
                    <input class="button_all" type="submit" name="submit" value="Показать">
                </div>
                <div>
                    <input type="checkbox" id="count" name="count">
                    <label for="Сортировка">только когда посещал</label>
                </div>
            </form>

            <form class="form_action" action="do.php" method="post">
                <p>Посмотреть день тренировки</p>
                <div class="select_date">
                    <input id="date" type="date" value="<?php echo date('Y-m-d'); ?>" name="date">
                </div>
                <div class="select_date">
                    <input class="button_all" type="submit" name="visit_d" value="Показать">
                </div>
            </form>

            <form class="form_action" action="do.php" method="post">

                    <p>Посмотреть статистику пощений за период</p>
                    <div class="select_date">
                        <input class='center' id="date" type="date" value="2023-01-09" name="date_start">
                    </div>
                    <div class="select_date">
                        <input class='center' id="date" type="date" value="<?php echo date('Y-m-d'); ?>" name="date_end">
                    </div>
                    <div class="select_date">
                        <input class="button_all" type="submit" name="all" value="Показать">
                    </div>
                    <div class="select_date">
                        <input type="checkbox" id="count" name="count">
                        <label for="Сортировка">Cортировать по посещениям</label>
                    </div>


                
            </form> 
        </div>

        
    </body>
</html>

