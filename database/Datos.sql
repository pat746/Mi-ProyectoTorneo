USE TorneoFutbol;
-- Insertar datos en la tabla Estadio

INSERT INTO Estadio (Nombre_Estadio, Capacidad, Ciudad, Año_Inauguración)
VALUES 
('Estadio Nacional', 45000, 'Lima', 1952),
('Camp Nou', 99354, 'Barcelona', 1957),
('Santiago Bernabéu', 81044, 'Madrid', 1947);

-- Insertar datos en la tabla Equipos
INSERT INTO Equipos (Nombre_Equipo, Ciudad, Año_Fundación, Estadio_ID)
VALUES 
('Barcelona', 'Barcelona', 1899, 2),
('Real Madrid', 'Madrid', 1902, 3),
('Sporting Cristal', 'Lima', 1955, 1);

-- Insertar datos en la tabla Jugadores
INSERT INTO Jugadores (Nombre, Apellido, Fecha_Nacimiento, Posición, Nacionalidad)
VALUES 
('Lionel', 'Messi', '1987-06-24', 'Delantero', 'Argentina'),
('Cristiano', 'Ronaldo', '1985-02-05', 'Delantero', 'Portugal'),
('Paolo', 'Guerrero', '1984-01-01', 'Delantero', 'Perú');

-- Insertar datos en la tabla Contrato
INSERT INTO Contrato (ID_Jugador, ID_Equipo, Fecha_Inicio, Fecha_Fin, Salario, Tipo_Contrato)
VALUES 
(1, 1, '2023-07-01', '2025-06-30', 35000000, 'Profesional'),
(2, 2, '2023-07-01', '2025-06-30', 40000000, 'Profesional'),
(3, 3, '2023-01-01', '2024-12-31', 500000, 'Profesional');

-- Insertar datos en la tabla Torneo
INSERT INTO Torneo (Nombre_Torneo, Temporada, Tipo_Torneo, Pais)
VALUES 
('Champions League', '2023-2024', 'Internacional', 'Europa'),
('Liga 1', '2023', 'Nacional', 'Perú');

-- Insertar datos en la tabla Árbitro
INSERT INTO Árbitro (Nombre, Apellido, Nacionalidad, Experiencia)
VALUES 
('Pierluigi', 'Collina', 'Italia', 15),
('Victor', 'Carrillo', 'Perú', 10);

-- Insertar datos en la tabla Equipos_Torneo
INSERT INTO Equipos_Torneo (ID_Equipo, ID_Torneo)
VALUES 
(1, 1),
(2, 1),
(3, 2);

-- Insertar datos en la tabla Partidos
INSERT INTO Partidos (Fecha, ID_Equipo_Local, ID_Equipo_Visitante, ID_Torneo, ID_Árbitro, ID_Estadio)
VALUES 
('2023-10-15', 1, 2, 1, 1, 2),
('2023-11-05', 3, 1, 2, 2, 1);

-- Insertar datos en la tabla Resultados_Partidos
INSERT INTO Resultados_Partidos (ID_Partido, Goles_Local, Goles_Visitante)
VALUES 
(1, 3, 1),
(2, 2, 2);

-- Insertar datos en la tabla Goles_Partidos
INSERT INTO Goles_Partidos (ID_Partido, ID_Jugador, Goles)
VALUES 
(1, 1, 2),
(1, 2, 1),
(2, 3, 1),
(2, 1, 1);

-- Insertar datos en la tabla Estadisticas_Partidos
INSERT INTO Estadisticas_Partidos (ID_Partido, ID_Jugador, Asistencias, Faltas, Tarjetas_Amarillas, Tarjetas_Rojas)
VALUES 
(1, 1, 1, 2, 0, 0),
(1, 2, 0, 1, 1, 0),
(2, 3, 2, 3, 1, 0),
(2, 1, 0, 1, 0, 0);
