<?php

require_once 'Conexion.php';

class Goles extends Conexion {
    private $pdo;

    public function __construct() {
        $this->pdo = parent::getConexion();
    }

    // Agregar un nuevo registro de goles
    public function add($params = []): bool {
        try {
            $query = "INSERT INTO Goles_Partidos (ID_Partido, ID_Jugador, Goles) 
                      VALUES (?, ?, ?)";
            $cmd = $this->pdo->prepare($query);
            return $cmd->execute([
                $params['idPartido'],
                $params['idJugador'],
                $params['goles'] ?? 0
            ]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    
    // Método en el modelo Goles para obtener los goles y el nombre del jugador
    public function getAll() {
        $query = "
            SELECT goles.ID_Goles, goles.ID_Partido, goles.Goles, jugadores.Nombre
            FROM Goles_Partidos AS goles
            JOIN Jugadores AS jugadores ON goles.ID_Jugador = jugadores.ID_Jugador
        ";
    
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devuelve todos los goles con el nombre del jugador
    }
    


    // Obtener registro por ID
    public function getById($idGoles) {
        try {
            $query = "SELECT * FROM Goles_Partidos WHERE ID_Goles = :idGoles";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':idGoles', $idGoles, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    // Actualizar un registro
    public function update($params = []): bool {
        try {
            $query = "UPDATE Goles_Partidos 
                      SET ID_Partido = ?, ID_Jugador = ?, Goles = ? 
                      WHERE ID_Goles = ?";
            $cmd = $this->pdo->prepare($query);
            return $cmd->execute([
                $params['idPartido'],
                $params['idJugador'],
                $params['goles'],
                $params['idGoles']
            ]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Eliminar un registro
    public function delete($idGoles): bool {
        try {
            $query = "DELETE FROM Goles_Partidos WHERE ID_Goles = ?";
            $cmd = $this->pdo->prepare($query);
            return $cmd->execute([$idGoles]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}

?>
