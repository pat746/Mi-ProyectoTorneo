USE TorneoFutbol;
DELIMITER $$

CREATE PROCEDURE ObtenerDetallesPartidos()
BEGIN
    SELECT 
        P.ID_Partido AS PartidoID,
        P.Fecha AS FechaPartido,
        EL.Nombre_Equipo AS EquipoLocal,
        EV.Nombre_Equipo AS EquipoVisitante,
        RP.Goles_Local AS GolesLocal,
        RP.Goles_Visitante AS GolesVisitante,
        E.Nombre_Estadio AS Estadio,
        T.Nombre_Torneo AS Torneo,
        T.Temporada AS Temporada,
        A.Nombre AS ArbitroNombre,
        A.Apellido AS ArbitroApellido,
        CONCAT(J.Nombre, ' ', J.Apellido) AS Goleador,
        GP.Goles AS GolesJugador
    FROM 
        Partidos P
    LEFT JOIN Resultados_Partidos RP ON P.ID_Partido = RP.ID_Partido
    LEFT JOIN Equipos EL ON P.ID_Equipo_Local = EL.ID_Equipo
    LEFT JOIN Equipos EV ON P.ID_Equipo_Visitante = EV.ID_Equipo
    LEFT JOIN Estadio E ON P.ID_Estadio = E.ID_Estadio
    LEFT JOIN Torneo T ON P.ID_Torneo = T.ID_Torneo
    LEFT JOIN Árbitro A ON P.ID_Árbitro = A.ID_Árbitro
    LEFT JOIN Goles_Partidos GP ON P.ID_Partido = GP.ID_Partido
    LEFT JOIN Jugadores J ON GP.ID_Jugador = J.ID_Jugador
    ORDER BY P.Fecha ASC;
END$$

DELIMITER ;
CALL ObtenerDetallesPartidos();

