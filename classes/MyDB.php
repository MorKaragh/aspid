<?php

class MyDB {

    var $connection;
    var $username;
    var $password = "ntktajyBD";
    var $dbname = "meworyru_strike";
    var $host = "localhost";


    /**
     * constructor by user and password
     * */
    function __construct() {
        $this->password = "ntktajyBD";
        $this->username = "meworyru_strike";
    }
    /**
     * destructor. DESTROOOOY!!!
     * */
    function __destruct(){
        $this->connection = null;
    }

    /**
     * run query and return result set
     * */
    function query($sql){
        if($this->connection != null){
            $result = pg_exec($this->connection, $sql);
            return $result;
        } else die("not connected to database!");
    }

    /**
     * get a single value from database
     **/
    function get_single_value($sql,$params){
        if($this->connection != null){
            pg_prepare($this->connection, "getting_single_value", $sql);
            $result = pg_execute($this->connection, "getting_single_value", $params);
            $row = pg_fetch_array($result);
            return $row[0];
        } else {
            die("NO CONNECTION!");
        }
    }

    /**
     * prepare query
     * */
    function prepare_stmt($sql,$queryname){
        if($this->connection != null){
            $result = pg_prepare($this->connection, $queryname, $sql);
            return $result;
        } else die("not connected to database!");
    }


    /**
     * execute prepared query
     * */
    function execute_stmt($queryname, $params){
        if($this->connection != null){
            $result = pg_execute($this->connection, $queryname, $params);
            return $result;
        } else die("not connected to database!");
    }

    /**
     * parametrized query
     **/
    function p_query($sql,$params){
        if($this->connection != null){
            $result = pg_query_params($this->connection, $sql, $params);
            return $result;
        } else die("not connected to database!");

    }


    /**
     * connect to database
     **/
    function connect(){
        $this->connection = pg_connect("host=pg.sweb.ru port=5432 dbname=meworyru_strike user=$this->username password=$this->password")
        or die("can not connect to database!");
    }

    /**
     * close connection
     */
    function disconnect(){
        if(!pg_close($this->connection)){
            die("could not close connection!");
        };
    }

    /**
     * test query
     */
    function test_query(){
        if($this->connection != null){
            $result = pg_exec($this->connection, "SELECT 'lololo' AS tst");
            $row = pg_fetch_array($result);
            return $row['tst'];
        } else {
            die("NO CONNECTION!");
        }
    }

    /**
     * returns error
     **/
    function get_error(){
        return pg_last_error ($this->connection);
    }

    /**
     * keep errors
     * */
    function errconcat($v){
        if(get_error() != null){
            return $v.get_error();
        } else {
            return $v;
        }
    }


    function connect_pdo(){
        $this->pdo = new PDO("pgsql:dbname=meworyru_strike;host=pg.sweb.ru", $this->username, $this->password )
        or die("can not connect PDO to database!");
    }

    function disconnect_pdo(){
        $this->pdo = null;
    }

    function get_pdo(){
        return $this->pdo;
    }

    function prepare_and_execute_pdo($sql, $params){
        if($this->pdo != null){
            $q = $this->pdo->prepare($sql);
            $q->execute($params);
            return $q;
        }
    }

    /*
    function connect_pdo(){
        $dbname = "mewory";
        $host = "localhost";
        $username="postgres";
        $password="123321";
        $d = new PDO("pgsql:dbname=$dbname;host=$host", $username, $password );
        return $d;
    }

    function test_ins(){
        $dtb = $this->connect_pdo();
        echo "lllllol";
        $q = $dtb->prepare("insert into persons(id,short_name) values(:dd,:nm)");
        //$q->bindValue(":nm",);
        $q->execute(array(123,"Tookook"));
    }
    */

}

?>