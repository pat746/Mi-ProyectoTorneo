USE TorneoFutbol;

DELIMITER //

CREATE PROCEDURE ObtenerEquiposConEstadio()
BEGIN
    SELECT 
        e.ID_Equipo,
        e.Nombre_Equipo,
        e.Ciudad,
        e.Año_Fundación,
        e.Estadio_ID,
        es.Nombre_Estadio
    FROM 
        Equipos e
    LEFT JOIN 
        Estadio es ON e.Estadio_ID = es.ID_Estadio;
END //

DELIMITER ;

CALL ObtenerEquiposConEstadio();
select*from equipos;
select*from jugadores;
select*from estadio;
select*from Árbitro;


UPDATE Equipos
SET Estadio_ID = 1
WHERE ID_Equipo = (SELECT ID_Equipo FROM Equipos WHERE Nombre_Equipo = 'Barcelona');
