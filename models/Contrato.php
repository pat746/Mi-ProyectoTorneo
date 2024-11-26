<?php

require_once 'Conexion.php';

class Contrato extends Conexion {
    private $pdo;

    public function __construct() {
        $this->pdo = parent::getConexion();
    }

    // Agregar un nuevo contrato
    public function add($params = []): bool {
        try {
            $query = "INSERT INTO Contrato (ID_Jugador, ID_Equipo, Fecha_Inicio, Fecha_Fin, Salario, Tipo_Contrato) 
                      VALUES (?, ?, ?, ?, ?, ?)";
            $cmd = $this->pdo->prepare($query);
            return $cmd->execute([
                $params['idJugador'],
                $params['idEquipo'],
                $params['fechaInicio'],
                $params['fechaFin'],
                $params['salario'],
                $params['tipoContrato']
            ]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Obtener todos los contratos usando el procedimiento almacenado
    public function getAll(): array {
        try {
            $query = "CALL ObtenerContrato()";
            $cmd = $this->pdo->prepare($query);
            $cmd->execute();
            return $cmd->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    // Obtener contrato por ID
    public function getById($idContrato) {
        try {
            $query = "CALL ObtenerContratoPorID(:idContrato)";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':idContrato', $idContrato, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    // Actualizar un contrato
    public function update($params = []): bool {
        try {
            $query = "UPDATE Contrato 
                      SET ID_Jugador = ?, ID_Equipo = ?, Fecha_Inicio = ?, Fecha_Fin = ?, Salario = ?, Tipo_Contrato = ? 
                      WHERE ID_Contrato = ?";
            $cmd = $this->pdo->prepare($query);
            return $cmd->execute([
                $params['idJugador'],
                $params['idEquipo'],
                $params['fechaInicio'],
                $params['fechaFin'],
                $params['salario'],
                $params['tipoContrato'],
                $params['idContrato']
            ]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Eliminar un contrato
    public function delete($id): bool {
        try {
            $query = "DELETE FROM Contrato WHERE ID_Contrato = ?";
            $cmd = $this->pdo->prepare($query);
            return $cmd->execute([$id]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function jugadorAsignado($idJugador) {
        try {
            $query = "SELECT COUNT(*) FROM Contrato WHERE ID_Jugador = ?";
            $cmd = $this->pdo->prepare($query);
            $cmd->execute([$idJugador]);
            $result = $cmd->fetchColumn();
            return $result > 0; // Retorna true si el jugador ya está asignado a un equipo
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    
}
?>
