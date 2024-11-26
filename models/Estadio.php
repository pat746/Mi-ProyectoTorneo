<?php

require_once 'Conexion.php';

class Estadio extends Conexion {
    private $pdo;

    public function __construct() {
        $this->pdo = parent::getConexion();
    }

    // Agregar un nuevo estadio
    public function add($params = []): bool {
        try {
            $query = "INSERT INTO Estadio (Nombre_Estadio, Capacidad, Ciudad, Año_Inauguración) 
                      VALUES (?, ?, ?, ?)";
            $cmd = $this->pdo->prepare($query);
            return $cmd->execute([
                $params['nombreEstadio'],
                $params['capacidad'],
                $params['ciudad'],
                $params['anoInauguracion']
            ]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Obtener todos los estadios
    public function getAll(): array {
        try {
            $query = "SELECT * FROM Estadio";
            $cmd = $this->pdo->prepare($query);
            $cmd->execute();
            return $cmd->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    // Obtener estadio por ID
    public function getById($idEstadio) {
        $query = "SELECT * FROM Estadio WHERE ID_Estadio = :idEstadio";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':idEstadio', $idEstadio, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar estadio
    public function update($params = []): bool {
        try {
            $queryCheck = "SELECT COUNT(*) FROM Estadio WHERE ID_Estadio = ?";
            $cmdCheck = $this->pdo->prepare($queryCheck);
            $cmdCheck->execute([$params['idEstadio']]);
            $exists = $cmdCheck->fetchColumn();
            
            if ($exists == 0) {
                return false;  // Estadio no existe
            }

            $query = "UPDATE Estadio 
                      SET Nombre_Estadio = ?, Capacidad = ?, Ciudad = ?, Año_Inauguración = ? 
                      WHERE ID_Estadio = ?";
            $cmd = $this->pdo->prepare($query);
            $success = $cmd->execute([
                $params['nombreEstadio'],
                $params['capacidad'],
                $params['ciudad'],
                $params['anoInauguracion'],
                $params['idEstadio']
            ]);

            return $cmd->rowCount() > 0;
        } catch (Exception $e) {
            error_log('Error en actualización: ' . $e->getMessage());
            return false;
        }
    }

    // Eliminar un estadio
    public function delete($idEstadio): bool {
        try {
            $query = "DELETE FROM Estadio WHERE ID_Estadio = ?";
            $cmd = $this->pdo->prepare($query);
            return $cmd->execute([$idEstadio]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}

?>
