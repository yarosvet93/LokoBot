<?php


Class Database {

    private $link;

    public function __construct()
    {
      $this->connect();
    }

    private function connect ()
    {
        $config = require_once 'connect.php';
        $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['db_name'] . ';charset=' . $config['charset'];
        $this->link = new PDO($dsn, $config['username'], $config['password']);

    }

    public function exec($sql)
    {
        $sth = $this->link->prepare($sql);
        return $sth->execute();
    }

    public function query($sql)
    {
        $sth = $this->link->prepare($sql);
        $sth->execute();
        $result = $sth->fetchALL(PDO::FETCH_ASSOC);
        if ($result === false){
            return[];
        }
        return $result;
    }

    public function query_once($sql)
    {
        $sth = $this->link->prepare($sql);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        if ($result === false){
            return[];
        }
        return $result;
    }

    
}

// $db = new Database();
// $user = $db->query("SELECT * FROM tb_players");
// echo "<pre>";
// print_r ($user);

//  $config = require_once 'connect.php';
//         $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['db_name'] . ';charset=' . $config['charset'];
//         $link = new PDO($dsn, $config['username'], $config['password']);
//         $sth = $link->prepare("SELECT * FROM tb_players");
//         $sth->execute();
//         echo "<pre>";
        
//         while ($result = $sth->fetch(PDO::FETCH_ASSOC)){
//             print_r ($result);

//         }






       ?>