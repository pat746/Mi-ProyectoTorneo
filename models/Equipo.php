<?php

require_once 'Conexion.php';

class Equipo extends Conexion {
    private $pdo;

    public function __construct() {
        $this->pdo = parent::getConexion();  // Establecemos la conexión con la base de datos
    }

    // Agregar un nuevo equipo
    public function add($params = []): bool {
        try {
            $query = "INSERT INTO Equipos (Nombre_Equipo, Ciudad, Año_Fundación, Estadio_ID) 
                      VALUES (?, ?, ?, ?)";
            $cmd = $this->pdo->prepare($query);
            return $cmd->execute([
                $params['nombreEquipo'],
                $params['ciudad'],
                $params['anioFundacion'],
                $params['estadioId']
            ]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Obtener todos los equipos con información de su estadio utilizando el procedimiento almacenado
    public function getAll(): array {
        try {
            $query = "CALL ObtenerEquiposConEstadio()";  // Procedimiento almacenado
            $cmd = $this->pdo->prepare($query);
            $cmd->execute();

            return $cmd->fetchAll(PDO::FETCH_ASSOC);  // Devuelve todos los equipos con los estadios
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    // Obtener equipo por ID
    public function getById($idEquipo) {
        try {
            $query = "SELECT 
                        e.ID_Equipo,
                        e.Nombre_Equipo,
                        e.Ciudad,
                        e.Año_Fundación,
                        e.Estadio_ID,
                        es.Nombre_Estadio
                      FROM Equipos e
                      LEFT JOIN Estadio es ON e.Estadio_ID = es.ID_Estadio
                      WHERE e.ID_Equipo = :idEquipo";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':idEquipo', $idEquipo, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    // Actualizar información de un equipo
    public function update($params = []): bool {
        try {
            // Verificar si el equipo con ID_Equipo existe
            $queryCheck = "SELECT COUNT(*) FROM Equipos WHERE ID_Equipo = ?";
            $cmdCheck = $this->pdo->prepare($queryCheck);
            $cmdCheck->execute([$params['idEquipo']]);
            $exists = $cmdCheck->fetchColumn();

            if ($exists == 0) {
                // Si el equipo no existe, retornar false
                error_log('No existe un equipo con el ID: ' . $params['idEquipo']);
                return false;
            }

            // Realizar la actualización si el equipo existe
            $query = "UPDATE Equipos 
                    SET Nombre_Equipo = ?, Ciudad = ?, Año_Fundación = ?, Estadio_ID = ? 
                    WHERE ID_Equipo = ?";
            $cmd = $this->pdo->prepare($query);

            $success = $cmd->execute([
                $params['nombreEquipo'],
                $params['ciudad'],
                $params['anioFundacion'],
                $params['estadioId'],
                $params['idEquipo']
            ]);

            return $cmd->rowCount() > 0;
        } catch (Exception $e) {
            error_log('Error en actualización: ' . $e->getMessage());
            return false;
        }
    }

    // Eliminar un equipo por ID
    public function delete($idEquipo): bool {
        try {
            $query = "DELETE FROM Equipos WHERE ID_Equipo = ?";
            $cmd = $this->pdo->prepare($query);
            return $cmd->execute([$idEquipo]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Obtener todos los estadios
    public function getAllEstadios() {
        $query = "SELECT * FROM estadio"; // Suponiendo que tienes una tabla de estadios
        $result = $this->pdo->prepare($query);
        $result->execute();  // Ejecutamos la consulta
        return $result->fetchAll(PDO::FETCH_ASSOC);  // Devolvemos todos los estadios
    }

    // Obtener estadios disponibles
    public function getEstadiosDisponibles() {
        $query = "SELECT * FROM estadio WHERE ID_Estadio NOT IN (SELECT Estadio_ID FROM equipos)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener equipos por torneo
    public function getEquiposPorTorneo($idTorneo) {
        try {
            $query = "SELECT ID_Equipo, Nombre_Equipo FROM equipos WHERE ID_Torneo = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(1, $idTorneo, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna los equipos asociados al torneo
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];  // En caso de error
        }
    }
}
?>
