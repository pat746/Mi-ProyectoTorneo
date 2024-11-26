USE TorneoFutbol;

DELIMITER $$

CREATE PROCEDURE GenerarTablaGoleadores()
BEGIN
    SELECT 
        ROW_NUMBER() OVER (ORDER BY SUM(g.Goles) DESC) AS Posicion, -- Ranking
        CONCAT(j.Nombre, ' ', j.Apellido) AS Jugador, -- Nombre completo del jugador
        e.Nombre_Equipo AS Equipo, -- Equipo del jugador
        SUM(g.Goles) AS G, -- Suma total de goles del jugador
        SUM(es.Asistencias) AS A, -- Suma total de asistencias del jugador
        ROUND(AVG(es.Asistencias * 0.5 + g.Goles), 1) AS Calificacion -- Calificación simple basada en goles y asistencias
    FROM 
        Jugadores j
    INNER JOIN 
        Contrato c ON j.ID_Jugador = c.ID_Jugador
    INNER JOIN 
        Equipos e ON c.ID_Equipo = e.ID_Equipo
    INNER JOIN 
        Goles_Partidos g ON j.ID_Jugador = g.ID_Jugador
    LEFT JOIN 
        Estadisticas_Partidos es ON g.ID_Partido = es.ID_Partido AND j.ID_Jugador = es.ID_Jugador
    GROUP BY 
        j.ID_Jugador, j.Nombre, j.Apellido, e.Nombre_Equipo
    ORDER BY 
        G DESC;
END$$

DELIMITER ;
 

CALL GenerarTablaGoleadores();