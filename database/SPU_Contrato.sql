USE TorneoFutbol;

DELIMITER $$

CREATE PROCEDURE obtenerContrato()
BEGIN
    SELECT 
        c.ID_Contrato,
        j.Nombre AS Nombre_Jugador,
        e.Nombre_Equipo AS Nombre_Equipo,
        c.Fecha_Inicio,
        c.Fecha_Fin,
        c.Salario,
        c.Tipo_Contrato
    FROM 
        Contrato c
    INNER JOIN 
        Jugadores j ON c.ID_Jugador = j.ID_Jugador
    INNER JOIN 
        Equipos e ON c.ID_Equipo = e.ID_Equipo;
END $$



DELIMITER ;
/*
obtener contrato por id*/
DELIMITER $$

CREATE PROCEDURE ObtenerContratoPorID(
    IN contrato_id INT
)
BEGIN
    SELECT 
        C.ID_Contrato,
        C.ID_Jugador,
        C.ID_Equipo,
        C.Fecha_Inicio,
        C.Fecha_Fin,
        C.Salario,
        C.Tipo_Contrato,
        J.Nombre AS Nombre_Jugador,
        J.Apellido AS Apellido_Jugador,
        E.Nombre_Equipo,
        E.Ciudad AS Ciudad_Equipo
    FROM 
        Contrato C
    JOIN 
        Jugadores J ON C.ID_Jugador = J.ID_Jugador
    JOIN 
        Equipos E ON C.ID_Equipo = E.ID_Equipo
    WHERE 
        C.ID_Contrato = contrato_id;
END $$

DELIMITER ;
CALL ObtenerContratoPorID(2);

CALL ObtenerContrato();

SELECT ID_Jugador, Nombre FROM Jugadores;


