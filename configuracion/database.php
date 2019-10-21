<?php
class database {
    private $conexion;
    private $connection;

    public function database(){	}

    public static function conexion()
    {
        $dbsystem='mysql';
        $host='mysql';
        $dbname='bayental_app';
        $dsn=$dbsystem.':host='.$host.';dbname='.$dbname;
        $username='bay';
        $passwd='bayental2019';
        $connection = null;
        $params = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        try {
            $connection = new PDO($dsn, $username, $passwd, $params);
        } catch (PDOException $pdoException) {
            $connection = null;
            echo 'Error al establecer la conexión: '.$pdoException;
            exit;
        }
        
        //return $conexion;
        return $connection;
    }

    public static function conexion_251()
    {
        $dbsystem='mysql';
        $host='mysql';
        $dbname='bdrimac';
        $dsn=$dbsystem.':host='.$host.';dbname='.$dbname;
        $username='bay';
        $passwd='bayental2019';
        $connection = null;
        $params = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        try {
            $connection = new PDO($dsn, $username, $passwd, $params);
        } catch (PDOException $pdoException) {
            $connection = null;
            echo 'Error al establecer la conexión: '.$pdoException;
            exit;
        }
        
        //return $conexion;
        return $connection;
    }
    
    public function disconnect(){
        $conexion = null;
        //$connection = null;
    }
}
?>