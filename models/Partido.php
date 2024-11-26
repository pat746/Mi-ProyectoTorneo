<?php

require_once 'Conexion.php';

class Partido extends Conexion {
    private $pdo;

    public function __construct() {
        $this->pdo = parent::getConexion();
    }  

    // Ejecutar el procedimiento para obtener partidos
    public function obtenerPartidos($idTorneo) {
        try {
            //$query = "CALL ObtenerPartidos()";  // Llamar al procedimiento almacenado
            $query = "
                    SELECT 
                        P.ID_Partido AS PartidoID,
                        P.Fecha AS FechaPartido,
                        EL.Nombre_Equipo AS EquipoLocal,
                        EV.Nombre_Equipo AS EquipoVisitante,
                        T.Nombre_Torneo AS Torneo,
                        T.Temporada AS Temporada,
                        A.Nombre AS ArbitroNombre,
                        A.Apellido AS ArbitroApellido,
                        E.Nombre_Estadio AS Estadio
                    FROM 
                        Partidos P
                    LEFT JOIN Equipos EL ON P.ID_Equipo_Local = EL.ID_Equipo
                    LEFT JOIN Equipos EV ON P.ID_Equipo_Visitante = EV.ID_Equipo
                    LEFT JOIN Torneo T ON P.ID_Torneo = T.ID_Torneo
                    LEFT JOIN Árbitro A ON P.ID_Árbitro = A.ID_Árbitro
                    LEFT JOIN Estadio E ON P.ID_Estadio = E.ID_Estadio
                    WHERE T.ID_Torneo = ?
                    ORDER BY P.Fecha ASC";
            $cmd = $this->pdo->prepare($query);
            $cmd->bindParam(1, $idTorneo, PDO::PARAM_INT); 
            $cmd->execute();
            return $cmd->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function obtenerGoles($idPartido)
    {
        try {
            // Llamar al procedimiento almacenado pasando el ID del partido
            $query = "CALL ObtenerDetallesPartido(:idPartido)";
            $cmd = $this->pdo->prepare($query);
            $cmd->bindParam(':idPartido', $idPartido, PDO::PARAM_INT);
            $cmd->execute();
            return $cmd->fetchAll(PDO::FETCH_ASSOC); // Obtener todos los registros
        } catch (Exception $e) {
            error_log("Error al obtener detalles de partido: " . $e->getMessage());
            return [];
        }
    }

    // Ejecutar el procedimiento para obtener los detalles de los partidos
    public function obtenerDetallesPartidos($idPartido) {
        try {
            // Llamar al procedimiento almacenado pasando el ID del partido
            $query = "CALL ObtenerDetallesPartido(:idPartido)";
            $cmd = $this->pdo->prepare($query);
            $cmd->bindParam(':idPartido', $idPartido, PDO::PARAM_INT);
            $cmd->execute();
            return $cmd->fetchAll(PDO::FETCH_ASSOC); // Obtener todos los registros
        } catch (Exception $e) {
            error_log("Error al obtener detalles de partido: " . $e->getMessage());
            return [];
        }
    }

    // Agregar un nuevo partido
    public function add($params = []): bool {
        try {
            $sql = "INSERT INTO Partidos (ID_Estadio, ID_Equipo_Local, ID_Equipo_Visitante, Fecha, ID_Torneo, ID_Árbitro) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $params['idEstadio'],
                $params['idEquipoLocal'],
                $params['idEquipoVisitante'],
                $params['fechaHora'],
                $params['idTorneo'],
                $params['idArbitro']
            ]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    

    // Obtener partido por ID
    public function getById($idPartido) {
        try {
            $query = "SELECT * FROM Partidos WHERE ID_Partido = :idPartido";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':idPartido', $idPartido, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    // Actualizar partido
    public function update($params = []): bool {
        try {
            $queryCheck = "SELECT COUNT(*) FROM Partidos WHERE ID_Partido = ?";
            $cmdCheck = $this->pdo->prepare($queryCheck);
            $cmdCheck->execute([$params['idPartido']]);
            $exists = $cmdCheck->fetchColumn();
            
            if ($exists == 0) {
                return false;  // Partido no existe
            }

            $query = "UPDATE Partidos 
                      SET ID_Estadio = ?, ID_Equipo_Local = ?, ID_Equipo_Visitante = ?, Fecha = ?, 
                          ID_Torneo = ?, ID_Árbitro = ? 
                      WHERE ID_Partido = ?";
            $cmd = $this->pdo->prepare($query);
            $success = $cmd->execute([
                $params['idEstadio'],
                $params['idEquipoLocal'],
                $params['idEquipoVisitante'],
                $params['fechaHora'],
                $params['idTorneo'],
                $params['idArbitro'],
                $params['idPartido']
            ]);

            return $cmd->rowCount() > 0;
        } catch (Exception $e) {
            error_log('Error en actualización: ' . $e->getMessage());
            return false;
        }
    }

    // Eliminar un partido
    public function delete($idPartido): bool {
        try {
            $query = "DELETE FROM Partidos WHERE ID_Partido = ?";
            $cmd = $this->pdo->prepare($query);
            return $cmd->execute([$idPartido]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    public function obtenerPartidosPorTorneo($idTorneo) {
        try {
            $sql = "SELECT * FROM Partidos WHERE ID_Torneo = :idTorneo";
            $stmt = $this->getConexion()->prepare($sql);
            $stmt->bindParam(':idTorneo', $idTorneo, PDO::PARAM_INT);
            $stmt->execute();
            
            $partidos = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $partidos[] = $row;
            }
    
            return $partidos;
        } catch (Exception $e) {
            error_log("Error al obtener partidos por torneo: " . $e->getMessage());
            return [];
        }
    }
    
    public function addGoles($params)
    {
        try {

            // Preparar la consulta para el jugador local
            $queryLocal = "INSERT INTO goles_partidos (ID_Partido, ID_Jugador, Goles) 
                        VALUES (?,?,?)";

            $stmtLocal = $this->pdo->prepare($queryLocal);
            $localResult = $stmtLocal->execute([
                $params['id_partido'],
                $params['local']['jugadorLocal'],
                $params['local']['golesLocal']
            ]);

            // Preparar la consulta para el jugador visitante
            $queryVisitante = "INSERT INTO goles_partidos (ID_Partido, ID_Jugador, Goles) 
                            VALUES (?,?,?)";

            $stmtVisitante = $this->pdo->prepare($queryVisitante);
            $visitanteResult = $stmtVisitante->execute([
                $params['id_partido'],
                $params['visitante']['jugadorVisitante'],
                $params['visitante']['golesVisitante']
            ]);

            if($stmtLocal || $stmtVisitante)
            {
                return true;
            }
        } catch (InvalidArgumentException $e) {
            error_log("Error en los parámetros: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("Error al insertar en la base de datos: " . $e->getMessage());
            return false;
        }
    }

    public function addResultados($params)
    {
        try {
            // Primero, verificamos si el id_partido ya existe en la base de datos
            $queryCheck = "SELECT Goles_Local, Goles_Visitante FROM resultados_partidos WHERE ID_Partido = ?";
            $cmdCheck = $this->pdo->prepare($queryCheck);
            $cmdCheck->execute([$params['id_partido']]);
            $result = $cmdCheck->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                // Si el partido ya existe, sumamos los goles existentes con los nuevos
                $newGolesLocal = $result['Goles_Local'] + $params['goles_local'];
                $newGolesVisitante = $result['Goles_Visitante'] + $params['goles_visitante'];

                // Actualizamos el resultado con los nuevos goles
                $queryUpdate = "UPDATE resultados_partidos SET Goles_Local = ?, Goles_Visitante = ? WHERE ID_Partido = ?";
                $cmdUpdate = $this->pdo->prepare($queryUpdate);
                $cmdUpdate->execute([$newGolesLocal, $newGolesVisitante, $params['id_partido']]);
            } else {
                // Si el partido no existe, insertamos un nuevo registro
                $queryInsert = "INSERT INTO resultados_partidos (ID_Partido, Goles_Local, Goles_Visitante) 
                                VALUES (?, ?, ?)";
                $cmdInsert = $this->pdo->prepare($queryInsert);
                $cmdInsert->execute([$params['id_partido'], $params['goles_local'], $params['goles_visitante']]);
            }
        } catch (\Throwable $th) {       
            echo "Error al agregar resultados: " . $th->getMessage();
            return false;
        }
    }
}
?>
