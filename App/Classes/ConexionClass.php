<?php

namespace App\Classes;

use Exception;
use mysqli;
use mysqli_result;

require_once __DIR__ . '/../../config/database.php';

class Conexion
{
    private $host;
    private $usuario;
    private $password;
    private $bd;
    private $conexion;

    public function __construct()
    {

        // Buscar las credenciales de la BDD
        $config = require __DIR__ . '/../../config/database.php';
    
        $this->host = $config['host'];
        $this->usuario = $config['username'];
        $this->password = $config['password'];
        $this->bd = $config['dbname'];

        // $this->conectar();
    }

    // Método para conectar
    private function conect()
    {
        $this->conexion = new mysqli(
            $this->host,
            $this->usuario,
            $this->password,
            $this->bd
        );

        if ($this->conexion->connect_error) {
            die("❌ Er  ror de conexión: " . $this->conexion->connect_error);
        }
    }

    // Obtener la conexión
    private function getConnection()
    {
        return $this->conexion;
    }

    // Cerrar conexión
    private function closeConnection()
    {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }

    // Funcion global para ejecutar queries
    public function executeQuery(string $query, array $params = [])
    {

        // 1. Conectar
        $this->conect();
        $conn = $this->getConnection();

        // 2. Preparar statement
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            $error = $conn->error;
            $this->closeConnection();
            throw new Exception("Error Al Preparar La Consulta: $error");
        }

        // 3. Si hay parámetros, enlazarlos
        if (!empty($params)) {
            $types = "";

            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= "i";
                } elseif (is_float($param)) {
                    $types .= "d";
                } else {
                    $types .= "s";
                }
            }

            $stmt->bind_param($types, ...$params);
        }

        // 4. Ejecutar
        if (!$stmt->execute()) {
            $error = $stmt->error;
            $stmt->close();
            $this->closeConnection();
            throw new Exception("Error al ejecutar la consulta: $error");
        }

        // 5. Si es SELECT, obtener resultados
        $result = $stmt->get_result();

        if ($result instanceof mysqli_result) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            $this->closeConnection();
            return $data;
        }

        // 6. Si no es SELECT, devolver true
        $stmt->close();
        $this->closeConnection();
        return true;
    }
}
