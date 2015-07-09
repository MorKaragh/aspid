<?php
/**
 * Created by PhpStorm.
 * User: tookuk
 * Date: 15.06.15
 * Time: 20:45
 */
ini_set("display_errors",1);
error_reporting(E_ALL);

class CoreDAO {


    var $connection;
    var $username = "meworyru_strike";
    var $password = "ntktajyBD";
    var $dbname = "meworyru_strike";
    var $host = "pg.sweb.ru";
    var $pdo;

    public function __construct(){
        $this->pdo = new PDO("pgsql:dbname=$this->dbname;host=$this->host", $this->username, $this->password);
    }

    public function __destruct(){
        $this->connection = null;
    }

    public function execSimpleQuery($sql){
        $this->connect();
        if($this->connection != null){
            $result = pg_exec($this->connection, $sql);
            $this->disconnect();
            return $result;
        } else die("not connected to database!");
    }

    public function execQuery($sql, $params){
        $result = array();
        $q = $this->pdo->prepare($sql);
        $q->execute($params);
        while ($row = $q->fetch(PDO::FETCH_BOTH)){
            array_push($result,$row);
        }
        return $result;
    }

    /**
     * prepare query
     * */
    public function execStatement($sql,$params){
        $this->connect();
        $result = pg_prepare($this->connection, 'myStmt', $sql);
        pg_execute($this->connection, 'myStmt', $params);
        $this->disconnect();
        return $result;
    }


    public function execUpdate($sql,$params){
        $q = $this->pdo->prepare($sql);
        $q->execute($params);
    }

    /**
     * connect to database
     **/
    protected function connect(){
        $this->connection = pg_connect("host=pg.sweb.ru port=5432 dbname=meworyru_strike user=$this->username password=$this->password")
        or die("can not connect to database!");
    }

    /**
     * close connection
     */
    protected function disconnect(){
        if(!pg_close($this->connection)){
            die("could not close connection!");
        };
    }

    /**
     * returns error
     **/
    private function get_error(){
        return pg_last_error ($this->connection);
    }


    public function debugLog($whatToLog){
        $sql = "INSERT INTO debug(txt) VALUES (:value)";
        try {
            $pdo = $this->pdo;
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $q = $pdo->prepare($sql);
            $q->execute(array(':value'=>$whatToLog));
        }catch(Exception $e) {
            echo 'Exception -> ';
            var_dump($e->getMessage());
        }
    }

    public function execInsert($sql,$params){
        try {

            $pdo = $this->pdo;
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $q = $pdo->prepare($sql);
            $q->execute($params);
        }catch(Exception $e) {
            echo 'Exception -> ';
            var_dump($e->getMessage());
        }
    }

    public function doReturn($msg, $err){
        echo '
        {
         "message" : "'.$msg.'",
         "error" : "'.$err.'"
        }';
        exit;
    }

}