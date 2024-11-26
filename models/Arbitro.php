<?php

require_once 'Conexion.php';

class Arbitro extends Conexion {
    private $pdo;

    public function __construct() {
        $this->pdo = parent::getConexion();
    }

    // Agregar un nuevo árbitro
    public function add($params = []): bool {
        try {
            $query = "INSERT INTO Árbitro (Nombre, Apellido, Nacionalidad, Experiencia) 
                      VALUES (?, ?, ?, ?)";
            $cmd = $this->pdo->prepare($query);
            return $cmd->execute([
                $params['nombre'],
                $params['apellido'],
                $params['nacionalidad'],
                $params['experiencia']
            ]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Obtener todos los árbitros
    public function getAll(): array {
        try {
            $query = "SELECT * FROM Árbitro";
            $cmd = $this->pdo->prepare($query);
            $cmd->execute();
            return $cmd->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    // Obtener árbitro por ID
    public function getById($idArbitro) {
        $query = "SELECT * FROM Árbitro WHERE ID_Árbitro = :idArbitro";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':idArbitro', $idArbitro, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar información de un árbitro
    public function update($params = []): bool {
        try {
            // Verificar si el árbitro con ID_Árbitro existe
            $queryCheck = "SELECT COUNT(*) FROM Árbitro WHERE ID_Árbitro = ?";
            $cmdCheck = $this->pdo->prepare($queryCheck);
            $cmdCheck->execute([$params['idArbitro']]);
            $exists = $cmdCheck->fetchColumn();
            
            if ($exists == 0) {
                // Si el árbitro no existe, retornar false
                return false;
            }
    
            // Realizar la actualización si el árbitro existe
            $query = "UPDATE Árbitro 
                      SET Nombre = ?, Apellido = ?, Nacionalidad = ?, Experiencia = ? 
                      WHERE ID_Árbitro = ?";
            $cmd = $this->pdo->prepare($query);
            
            $success = $cmd->execute([
                $params['nombre'],
                $params['apellido'],
                $params['nacionalidad'],
                $params['experiencia'],
                $params['idArbitro']
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

    // Eliminar un árbitro por ID
    public function delete($idArbitro): bool {
        try {
            $query = "DELETE FROM Árbitro WHERE ID_Árbitro = ?";
            $cmd = $this->pdo->prepare($query);
            return $cmd->execute([$idArbitro]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
?>
