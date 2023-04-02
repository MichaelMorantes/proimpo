<?php
header('Content-Type: text/html;charset=utf-8');
class model
{
    #Parametros de Conexion db 
    private const dbdsn = "mysql:dbname=proimpo;host=127.0.0.1";
    private const dbuser = "root";
    private const dbpass = "";

    public function getConnection()
    {
        #Configuraciones extra para parametrizar la informacion
        $options = [
            PDO::ATTR_CASE => PDO::CASE_LOWER,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_ORACLE_NULLS => PDO::NULL_TO_STRING,
        ];

        #Conexion a la base de datos
        try {
            return new PDO(self::dbdsn, self::dbuser, self::dbpass, $options);
        } catch (PDOException $e) {
            return null;
        }
    }

    #Funcion dinamica que asigna los valores de las variables a los placeholders
    private function bindParams($stid, $params, $withType = false)
    {
        foreach ($params as $key => &$value) {
            #Verifico si no requiere tipo de dato
            if (!$withType) {
                $stid->bindParam($key, $value);
                continue;
            }
            #Verifico el tipo de dato
            switch (gettype($value)) {
                case 'integer':
                    $type = PDO::PARAM_INT;
                    break;
                case 'bool':
                    $type = PDO::PARAM_BOOL;
                    break;
                case 'string':
                    $type = PDO::PARAM_STR;
                    break;
                case 'NULL':
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    continue 2;
            }
            #asigno la variable con tipo de dato
            $stid->bindParam($key, $value, $type);
        }
    }

    public function doPing()
    {
        $conn = $this->getConnection();

        if (null === $conn) {
            return false;
        }

        return true;
    }

    #Funcion dinamica de los querys tipo select
    public function executeQuery($query, $params = [])
    {
        #conexion
        $conn = $this->getConnection();

        #verifico la conexion
        if (null === $conn) {
            return [];
        }

        #preparo el statment y hago la asignacion de tipos
        $stid = $conn->prepare($query);
        $this->bindParams($stid, $params);

        #Ejecucion de query y retorno de errores para testeo
        try {
            $stid->execute();
        } catch (Exception $e) {
            // var_dump($params);
            // echo "\n";
            // var_dump($stid->errorInfo());
            return [];
        }

        #fetch asociativo de la informacion retornada
        $rows = $stid->fetchAll(PDO::FETCH_ASSOC);

        return is_array($rows) ? $rows : [];
    }

    #Funcion dinamica de los query tipo delete, update, insert
    public function executeUpdate($query, $params = [])
    {
        $conn = $this->getConnection();

        if (null === $conn) {
            return false;
        }

        $stid = $conn->prepare($query);
        $this->bindParams($stid, $params);
        // var_dump($stid->debugDumpParams());
        try {
            $stid->execute();
        } catch (Exception $e) {
            // var_dump($params);
            // echo "\n";
            // var_dump($stid->errorInfo());
            return false;
        }

        return true;
    }
}
