<?php

require_once 'Conexion.php';

class Posiciones extends Conexion {
    private $pdo;

    public function __construct() {
        $this->pdo = parent::getConexion();
    }

    // Generar la tabla de posiciones
    public function generarTablaPosiciones($IdTorneo) {
        try {
            // Llamar al procedimiento almacenado
            $query = "SELECT 
                        e.Nombre_Equipo AS Equipo,
                        COUNT(p.ID_Partido) AS PJ,
                        SUM(CASE 
                                WHEN rp.Goles_Local > rp.Goles_Visitante AND p.ID_Equipo_Local = e.ID_Equipo THEN 1
                                WHEN rp.Goles_Visitante > rp.Goles_Local AND p.ID_Equipo_Visitante = e.ID_Equipo THEN 1
                                ELSE 0 
                            END) AS G,
                        SUM(CASE 
                                WHEN rp.Goles_Local = rp.Goles_Visitante THEN 1 
                                ELSE 0 
                            END) AS E,
                        SUM(CASE 
                                WHEN rp.Goles_Local < rp.Goles_Visitante AND p.ID_Equipo_Local = e.ID_Equipo THEN 1
                                WHEN rp.Goles_Visitante < rp.Goles_Local AND p.ID_Equipo_Visitante = e.ID_Equipo THEN 1
                                ELSE 0 
                            END) AS P,
                        SUM(CASE 
                                WHEN p.ID_Equipo_Local = e.ID_Equipo THEN rp.Goles_Local
                                WHEN p.ID_Equipo_Visitante = e.ID_Equipo THEN rp.Goles_Visitante
                                ELSE 0 
                            END) AS GF,
                        SUM(CASE 
                                WHEN p.ID_Equipo_Local = e.ID_Equipo THEN rp.Goles_Visitante
                                WHEN p.ID_Equipo_Visitante = e.ID_Equipo THEN rp.Goles_Local
                                ELSE 0 
                            END) AS GC,
                        SUM(CASE 
                                WHEN p.ID_Equipo_Local = e.ID_Equipo THEN ABS(rp.Goles_Local - rp.Goles_Visitante)
                                WHEN p.ID_Equipo_Visitante = e.ID_Equipo THEN ABS(rp.Goles_Visitante - rp.Goles_Local)
                                ELSE 0 
                            END) AS DG,
                        (SUM(CASE 
                                WHEN rp.Goles_Local > rp.Goles_Visitante AND p.ID_Equipo_Local = e.ID_Equipo THEN 1
                                WHEN rp.Goles_Visitante > rp.Goles_Local AND p.ID_Equipo_Visitante = e.ID_Equipo THEN 1
                                ELSE 0 
                            END) * 3) +
                        (SUM(CASE 
                                WHEN rp.Goles_Local = rp.Goles_Visitante THEN 1 
                                ELSE 0 
                            END)) AS PTS
                    FROM 
                        Equipos e
                    LEFT JOIN 
                        Partidos p ON e.ID_Equipo = p.ID_Equipo_Local OR e.ID_Equipo = p.ID_Equipo_Visitante
                    LEFT JOIN 
                        Resultados_Partidos rp ON p.ID_Partido = rp.ID_Partido
                    WHERE 
                        p.ID_Torneo = ?
                    GROUP BY 
                        e.ID_Equipo
                    ORDER BY 
                        PTS DESC, DG DESC, GF DESC;
                    ";
            $cmd = $this->pdo->prepare($query);
            $cmd->bindParam(1, $IdTorneo, PDO::PARAM_INT);  // Asignar el ID del torneo
            $cmd->execute();

            // Obtener los resultados
            $resultados = $cmd->fetchAll(PDO::FETCH_ASSOC);

            return $resultados;
        } catch (Exception $e) {
            error_log('Error al generar la tabla de posiciones: ' . $e->getMessage());
            return [];
        }
    }
}

?>
