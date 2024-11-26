<?php

require_once 'Conexion.php';

class Jugador extends Conexion {
    private $pdo;

    public function __construct() {
        $this->pdo = parent::getConexion();
    }

    // Agregar un nuevo jugador
    public function add($params = []): bool {
        try {
            $query = "INSERT INTO Jugadores (Nombre, Apellido, Fecha_Nacimiento, Posición, Nacionalidad) 
                      VALUES (?, ?, ?, ?, ?)";
            $cmd = $this->pdo->prepare($query);
            return $cmd->execute([
                $params['nombre'],
                $params['apellido'],
                $params['fechaNacimiento'],
                $params['posicion'],
                $params['nacionalidad']
            ]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Obtener todos los jugadores
    public function getAll(): array {
        try {
            $query = "SELECT * FROM Jugadores";
            $cmd = $this->pdo->prepare($query);
            $cmd->execute();
            return $cmd->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    // Obtener jugador por ID
    public function getById($idJugador) {
        $query = "SELECT * FROM Jugadores WHERE ID_Jugador = :idJugador";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':idJugador', $idJugador, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar información de un jugador
    public function update($params = []): bool {
        try {
            // Verificar si el jugador con ID_Jugador existe
            $queryCheck = "SELECT COUNT(*) FROM Jugadores WHERE ID_Jugador = ?";
            $cmdCheck = $this->pdo->prepare($queryCheck);
            $cmdCheck->execute([$params['idJugador']]);
            $exists = $cmdCheck->fetchColumn();
            
            if ($exists == 0) {
                return false;
            }
    
            // Actualizar información del jugador
            $query = "UPDATE Jugadores 
                      SET Nombre = ?, Apellido = ?, Fecha_Nacimiento = ?, Posición = ?, Nacionalidad = ? 
                      WHERE ID_Jugador = ?";
            $cmd = $this->pdo->prepare($query);
            return $cmd->execute([
                $params['nombre'],
                $params['apellido'],
                $params['fechaNacimiento'],
                $params['posicion'],
                $params['nacionalidad'],
                $params['idJugador']
            ]);
        } catch (Exception $e) {
            error_log('Error en actualización: ' . $e->getMessage());
            return false;
        }
    }

    // Eliminar un jugador por ID
    public function delete($idJugador): bool {
        try {
            $query = "DELETE FROM Jugadores WHERE ID_Jugador = ?";
            $cmd = $this->pdo->prepare($query);
            return $cmd->execute([$idJugador]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    // En el modelo Jugador.php


    // Método para obtener jugadores sin equipo
    public function getJugadoresSinEquipo() {
        $sql = "SELECT * FROM jugadores WHERE ID_Equipo IS NULL";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para verificar si un jugador ya tiene contrato
    public function verificarJugadorAsignado($idJugador) {
        $sql = "SELECT * FROM contratos WHERE ID_Jugador = :idJugador";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':idJugador', $idJugador, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getJugadoresPorEquipo($idEquipo): array {
        try {
            // Consulta que une las tablas Jugadores y Contrato
            $query = "
                SELECT j.ID_Jugador,j.Nombre, c.ID_Equipo
                FROM jugadores j
                INNER JOIN contrato c ON j.ID_Jugador = c.ID_Jugador
                WHERE c.ID_Equipo = :idEquipo
            ";
    
            $cmd = $this->pdo->prepare($query);
            $cmd->bindParam(':idEquipo', $idEquipo, PDO::PARAM_INT);
            $cmd->execute();
            
            return $cmd->fetchAll(PDO::FETCH_ASSOC);  // Devuelve los resultados
        } catch (Exception $e) {
            // Manejo de errores
            error_log($e->getMessage());
            return [];
        }
    }
    
}





?>
