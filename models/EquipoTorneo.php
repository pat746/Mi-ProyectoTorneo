<?php

require_once 'Conexion.php';

class EquiposTorneo extends Conexion {
    private $pdo;

    public function __construct() {
        $this->pdo = parent::getConexion();
    }

    // Agregar un equipo al torneo
    public function add($params = []): bool {
        try {
            $query = "INSERT INTO Equipos_Torneo (ID_Equipo, ID_Torneo) 
                      VALUES (?, ?)";
            $cmd = $this->pdo->prepare($query);
            return $cmd->execute([
                $params['idEquipo'],
                $params['idTorneo']
            ]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Obtener todos los equipos que participan en un torneo
    public function getAllByTorneo($idTorneo): array {
        try {
            $query = "CALL ObtenerEquiposPorTorneo(?)";
            $cmd = $this->pdo->prepare($query);
            $cmd->execute([$idTorneo]);
    
            // Agregar depuración para verificar si se está obteniendo algún dato
            $equipos = $cmd->fetchAll(PDO::FETCH_ASSOC);
            if (empty($equipos)) {
                error_log("No se encontraron equipos para el torneo con ID: " . $idTorneo);
            }
            return $equipos;
        } catch (Exception $e) {
            error_log("Error en getAllByTorneo: " . $e->getMessage());
            return [];
        }
    }
    
    // Eliminar equipo de un torneo
    public function delete($idEquipo, $idTorneo): bool {
        try {
            $query = "DELETE FROM Equipos_Torneo WHERE ID_Equipo = ? AND ID_Torneo = ?";
            $cmd = $this->pdo->prepare($query);
            return $cmd->execute([$idEquipo, $idTorneo]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Actualizar los datos de relación de un equipo en un torneo
    public function update($idEquipo, $idTorneo, $params): bool {
        try {
            $query = "UPDATE Equipos_Torneo SET ID_Equipo = ?, ID_Torneo = ? 
                      WHERE ID_Equipo_Torneo = ?";
            $cmd = $this->pdo->prepare($query);
            return $cmd->execute([
                $params['idEquipo'],
                $params['idTorneo'],
                $idEquipo // Aquí asumo que `ID_Equipo_Torneo` es el campo clave primaria.
            ]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    // Obtener equipos registrados en un torneo
public function getEquiposRegistrados($idTorneo): array {
    try {
        $query = "SELECT e.ID_Equipo, e.Nombre_Equipo 
                  FROM Equipos_Torneo et
                  JOIN Equipos e ON et.ID_Equipo = e.ID_Equipo
                  WHERE et.ID_Torneo = ?";
        $cmd = $this->pdo->prepare($query);
        $cmd->execute([$idTorneo]);

        $equipos = $cmd->fetchAll(PDO::FETCH_ASSOC);
        if (empty($equipos)) {
            error_log("No se encontraron equipos registrados para el torneo con ID: " . $idTorneo);
        }
        return $equipos;
    } catch (Exception $e) {
        error_log("Error en getEquiposRegistrados: " . $e->getMessage());
        return [];
    }
}

}
?>
