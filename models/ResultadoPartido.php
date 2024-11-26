<?php

error_reporting(E_ALL); // Activa todos los niveles de errores
ini_set('display_errors', 1); // Muestra los errores en pantalla


require_once 'Conexion.php';

class ResultadoPartido extends Conexion {
    private $pdo;

    public function __construct() {
        $this->pdo = parent::getConexion();
    }

    // Agregar un nuevo resultado
    public function add($params = []): bool {
        try {
            $query = "INSERT INTO resultados_partidos (ID_Partido, Goles_Local, Goles_Visitante) 
                      VALUES (?, ?, ?)";
            $cmd = $this->pdo->prepare($query);
            return $cmd->execute([
                $params['idPartido'],
                $params['golesLocal'] ?? 0,
                $params['golesVisitante'] ?? 0
            ]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Obtener todos los resultados
    public function getAll(): array
    {
        try {
            $query = "SELECT * FROM resultados_partidos";
            $cmd = $this->pdo->prepare($query);
            $cmd->execute();

            // Obtén los resultados
            $resultados = $cmd->fetchAll(PDO::FETCH_ASSOC);

            return $resultados;
        } catch (\Throwable $th) {
            // Lanza una excepción con el mensaje de error
            throw new Exception("Error al obtener los resultados: " . $th->getMessage());
        }
    }


    // Obtener resultado por ID
    public function getById($idPartido) {
        $query = "SELECT * FROM resultados_partidos WHERE ID_Partido = :idPartido";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':idPartido', $idPartido, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar un resultado
    public function update($params = []): bool {
        try {
            $query = "UPDATE resultados_partidos 
                      SET Goles_Local = ?, Goles_Visitante = ? 
                      WHERE ID_Partido = ?";
            $cmd = $this->pdo->prepare($query);
            return $cmd->execute([
                $params['golesLocal'],
                $params['golesVisitante'],
                $params['idPartido']
            ]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Eliminar un resultado
    public function delete($idPartido): bool {
        try {
            $query = "DELETE FROM resultados_partidos WHERE ID_Partido = ?";
            $cmd = $this->pdo->prepare($query);
            return $cmd->execute([$idPartido]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}

?>
