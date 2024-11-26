<?php

require_once 'Conexion.php';

class Torneo extends Conexion {
    private $pdo;

    public function __construct() {
        $this->pdo = parent::getConexion();
    }

    // Agregar un nuevo torneo
    public function add($params = []): bool {
        try {
            $query = "INSERT INTO Torneo (Nombre_Torneo, Temporada, Tipo_Torneo, Pais) 
                      VALUES (?, ?, ?, ?)";
            $cmd = $this->pdo->prepare($query);
            return $cmd->execute([
                $params['nombreTorneo'],
                $params['temporada'],
                $params['tipoTorneo'],
                $params['pais']
            ]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Obtener todos los torneos
    public function getAll(): array {
        try {
            $query = "SELECT * FROM Torneo";
            $cmd = $this->pdo->prepare($query);
            $cmd->execute();
            return $cmd->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    // Método para obtener torneo por ID
    public function getById($idTorneo) {
        $query = "SELECT * FROM Torneo WHERE ID_Torneo = :idTorneo";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':idTorneo', $idTorneo, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    

    // Actualizar información de un torneo
    public function update($params = []): bool {
        try {
            // Verificar si el torneo con ID_Torneo existe
            $queryCheck = "SELECT COUNT(*) FROM Torneo WHERE ID_Torneo = ?";
            $cmdCheck = $this->pdo->prepare($queryCheck);
            $cmdCheck->execute([$params['idTorneo']]);
            $exists = $cmdCheck->fetchColumn();
            
            if ($exists == 0) {
                // Si el torneo no existe, retornar false
                return false;
            }
    
            // Realizar la actualización si el torneo existe
            $query = "UPDATE Torneo 
                      SET Nombre_Torneo = ?, Temporada = ?, Tipo_Torneo = ?, Pais = ? 
                      WHERE ID_Torneo = ?";
            $cmd = $this->pdo->prepare($query);
            
            $success = $cmd->execute([
                $params['nombreTorneo'],
                $params['temporada'],
                $params['tipoTorneo'],
                $params['pais'],
                $params['idTorneo']
            ]);
    
            // Verificar si se actualizó alguna fila
            if ($cmd->rowCount() > 0) {
                return true;  // Actualización exitosa
            } else {
                return false;  // No se actualizó ninguna fila
            }
        } catch (Exception $e) {
            error_log('Error en actualización: ' . $e->getMessage());
            return false;
        }
    }
    

    
    

    // Eliminar un torneo por ID
    public function delete($idTorneo): bool {
        try {
            $query = "DELETE FROM Torneo WHERE ID_Torneo = ?";
            $cmd = $this->pdo->prepare($query);
            return $cmd->execute([$idTorneo]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Obtener estadísticas relacionadas con los partidos de un torneo
    public function getTournamentDetails(): array {
        try {
            $query = "CALL ObtenerDetallesPartidos()"; // Llamar al procedimiento almacenado
            $cmd = $this->pdo->prepare($query);
            $cmd->execute();
            return $cmd->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }
}

?>