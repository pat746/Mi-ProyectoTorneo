USE TorneoFutbol;

DELIMITER $$

CREATE PROCEDURE ObtenerEquiposPorTorneo(
    IN torneo_id INT
)
BEGIN
    SELECT 
        ET.ID_Equipo_Torneo,
        ET.ID_Equipo,
        E.Nombre_Equipo,
        ET.ID_Torneo,
        T.Nombre_Torneo
    FROM 
        Equipos_Torneo ET
    JOIN 
        Equipos E ON ET.ID_Equipo = E.ID_Equipo
    JOIN 
        Torneo T ON ET.ID_Torneo = T.ID_Torneo
    WHERE 
        ET.ID_Torneo = torneo_id;
END $$

DELIMITER ;
Call ObtenerEquiposPorTorneo(1);
select*from torneo;
select*from Equipos;
select*from resultados_partidos;
select*from goles_partidos;