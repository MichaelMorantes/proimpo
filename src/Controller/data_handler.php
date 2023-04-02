<?php

require_once __DIR__ . '/../Model/model.php';

class data_handler
{
    private $model;

    // Crea una instancia de la clase model.
    public function __construct()
    {
        $this->model = new model();
    }

    // función que se utiliza para leer registros de la base de datos mediante el uso de la función executeQuery de la clase model.
    public function read()
    {
        return $this->model->executeQuery($this->getQuery("Select"));
    }

    // función que se utiliza para insertar nuevos registros en la base de datos. Primero valida los datos recibidos por medio de la función validation y luego inserta los datos en la base de datos mediante el uso de la función executeUpdate de la clase model.
    public function insert($params)
    {
        $valid = $this->validation($params);
        if ($valid !== true) {
            return $valid;
        }
        unset($params['id']);
        unset($params['action']);

        $result = $this->model->executeUpdate($this->getQuery("Insert"), $params);

        if ($result) {
            return array('success', 'Se ha agregado el nuevo registro');
        }

        return array('error', 'Se ha producido un error al insertar el registro');
    }

    // función que se utiliza para calcular una comisión a partir de los registros existentes en la base de datos y luego guardar el resultado en la base de datos. Primero realiza la consulta de todos los registros mediante la función executeQuery de la clase model, luego calcula la comisión de cada registro y guarda el resultado mediante la función executeUpdate de la clase model.
    public function calculate($params)
    {
        $tasa_comision = 0.10;
        $comision_cliente = 5000;
        $comision = 0;
        $result;

        $records = $this->model->executeQuery($this->getQuery("Select"));

        foreach ($records as $record) {
            // Comisión = (Ventas del mes * Tasa de comisión) + (Clientes nuevos * Tasa de comisión por cliente)
            $record["comision"] = ($record['ventas'] * $tasa_comision) + ($record['clientes_nuevos'] * $comision_cliente);

            unset($record['nombre']);
            unset($record['cargo']);
            unset($record['inicio_cargo']);
            unset($record['clientes_nuevos']);
            unset($record['observacion']);
            unset($record['ventas']);

            $result = $this->model->executeUpdate($this->getQuery("Calculate"), $record);
        }

        if ($result) {
            return array('success', 'Se ha calculado la comision');
        }

        return array('error', 'Se ha producido un error al calcular la comision');
    }

    // función que se utiliza para eliminar registros de la base de datos. Primero valida los datos recibidos por medio de la función validation y luego elimina los datos de la base de datos mediante el uso de la función executeUpdate de la clase model.
    public function delete($params)
    {
        $valid = $this->validation($params);
        if ($valid !== true) {
            return $valid;
        }
        unset($params['action']);

        $result = $this->model->executeUpdate($this->getQuery("Delete"), $params);

        if ($result) {
            return array('success', 'Se ha eliminado el registro');
        }

        return array('error', 'Se ha producido un error al eliminar el registro');
    }

    // función que se utiliza para validar los datos recibidos antes de insertar o actualizar en la base de datos. Retorna un mensaje de advertencia si los datos no son válidos.
    private function validation($params){
        $respuesta = true;

        switch ($params['action']) {
            case 'INSERT':
                if (trim($params['nombre']) == "") {
                    return array("warning", "Nombre del vendedor es obligatorio");
                } else if (trim($params['cargo']) == "") {
                    return array("warning", "Cargo es obligatorio");
                } else if (trim($params['inicio_cargo']) == "") {
                    return array("warning", "Fecha de inicio en el cargo es obligatorio");
                } else if (trim($params['ventas']) == "") { 
                    return array("warning", "Ventas del mes actual es obligatorio");
                } else if (is_numeric(trim($params['ventas'])) === false) {
                    return array("warning", "Ventas del mes actual solo acepta numeros");
                } else if (trim($params['ventas']) < 0) {
                    return array("warning", "Ventas del mes actual solo acepta numeros positivos"); 
                } else if (trim($params['clientes_nuevos']) == "") {
                    return array("warning", "Clientes nuevos es obligatorio");
                } else if (is_numeric(trim($params['clientes_nuevos'])) === false) {
                    return array("warning", "Clientes nuevos solo acepta numeros");
                } else if (trim($params['clientes_nuevos']) < 0) {
                    return array("warning", "Clientes nuevos solo acepta numeros positivos");
                }
                break;
            case 'UPDATE':
                if (trim($params['id']) == "") {
                    return array("warning", "Campo no encontrado");
                } else if (trim($params['nombre']) == "") {
                    return array("warning", "Nombre del vendedor es obligatorio");
                } else if (trim($params['cargo']) == "") {
                    return array("warning", "Cargo es obligatorio");
                } else if (trim($params['inicio_cargo']) == "") {
                    return array("warning", "Fecha de inicio en el cargo es obligatorio");
                } else if (trim($params['ventas']) == "") { 
                    return array("warning", "Ventas del mes actual es obligatorio");
                } else if (is_numeric(trim($params['ventas'])) === false) {
                    return array("warning", "Ventas del mes actual solo acepta numeros");
                } else if (trim($params['ventas']) < 0) {
                    return array("warning", "Ventas del mes actual solo acepta numeros positivos"); 
                } else if (trim($params['clientes_nuevos']) == "") {
                    return array("warning", "Clientes nuevos es obligatorio");
                } else if (is_numeric(trim($params['clientes_nuevos'])) === false) {
                    return array("warning", "Clientes nuevos solo acepta numeros");
                } else if (trim($params['clientes_nuevos']) < 0) {
                    return array("warning", "Clientes nuevos solo acepta numeros positivos");
                }
                break;
            case 'DELETE':
                if (trim($params['id']) == "") {
                    return array("warning", "Campo no encontrado");
                }
                break;
            default:
                return false;
                break;
        }

        return $respuesta;
    }

    private function getQuery($query)
    {
        #Obtener query
        $content = file_get_contents(__DIR__ . "/../Database/$query.sql");
        #Verificar el contenido del query
        if (!is_string($content)) {
            return '';
        }
        return $content;
    }
}
