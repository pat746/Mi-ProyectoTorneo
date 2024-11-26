CREATE DATABASE TorneoFutbol;

-- Usar la base de datos creada
USE TorneoFutbol;

-- Crear tabla Estadio
CREATE TABLE Estadio (
    ID_Estadio INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_Estadio VARCHAR(100) NOT NULL,
    Capacidad INT,
    Ciudad VARCHAR(100),
    Año_Inauguración YEAR
);

-- Crear tabla Equipos
CREATE TABLE Equipos (
    ID_Equipo INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_Equipo VARCHAR(100) NOT NULL,
    Ciudad VARCHAR(100),
    Año_Fundación YEAR,
    Estadio_ID INT,
    FOREIGN KEY (Estadio_ID) REFERENCES Estadio(ID_Estadio) ON DELETE SET NULL
);

-- Crear tabla Jugadores
CREATE TABLE Jugadores (
    ID_Jugador INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(50) NOT NULL,
    Apellido VARCHAR(50) NOT NULL,
    Fecha_Nacimiento DATE,
    Posición VARCHAR(50),
    Nacionalidad VARCHAR(50)
);

-- Crear tabla Contrato (relaciona jugadores con equipos)
CREATE TABLE Contrato (
    ID_Contrato INT AUTO_INCREMENT PRIMARY KEY,
    ID_Jugador INT,
    ID_Equipo INT,
    Fecha_Inicio DATE,
    Fecha_Fin DATE,
    Salario DECIMAL(10, 2),
    Tipo_Contrato VARCHAR(50),
    FOREIGN KEY (ID_Jugador) REFERENCES Jugadores(ID_Jugador) ON DELETE CASCADE,
    FOREIGN KEY (ID_Equipo) REFERENCES Equipos(ID_Equipo) ON DELETE CASCADE
);

-- Crear tabla Torneo (para torneos como La Liga, Champions League, etc.)
CREATE TABLE Torneo (
    ID_Torneo INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_Torneo VARCHAR(100),
    Temporada VARCHAR(10),
    Tipo_Torneo VARCHAR(50),
    Pais VARCHAR(50)
);

-- Crear tabla Árbitro
CREATE TABLE Árbitro (
    ID_Árbitro INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(50),
    Apellido VARCHAR(50),
    Nacionalidad VARCHAR(50),
    Experiencia INT -- años de experiencia
);

-- Crear tabla Equipos_Torneo (relaciona equipos con torneos)
CREATE TABLE Equipos_Torneo (
    ID_Equipo_Torneo INT AUTO_INCREMENT PRIMARY KEY,
    ID_Equipo INT,
    ID_Torneo INT,
    FOREIGN KEY (ID_Equipo) REFERENCES Equipos(ID_Equipo) ON DELETE CASCADE,
    FOREIGN KEY (ID_Torneo) REFERENCES Torneo(ID_Torneo) ON DELETE CASCADE
);

-- Crear tabla Partidos (para almacenar información básica de los partidos)
CREATE TABLE Partidos (
    ID_Partido INT AUTO_INCREMENT PRIMARY KEY,
    Fecha DATE,
    ID_Equipo_Local INT,
    ID_Equipo_Visitante INT,
    ID_Torneo INT,
    ID_Árbitro INT,
    ID_Estadio INT,
    FOREIGN KEY (ID_Equipo_Local) REFERENCES Equipos(ID_Equipo) ON DELETE CASCADE,
    FOREIGN KEY (ID_Equipo_Visitante) REFERENCES Equipos(ID_Equipo) ON DELETE CASCADE,
    FOREIGN KEY (ID_Torneo) REFERENCES Torneo(ID_Torneo) ON DELETE CASCADE,
    FOREIGN KEY (ID_Árbitro) REFERENCES Árbitro(ID_Árbitro) ON DELETE SET NULL,
    FOREIGN KEY (ID_Estadio) REFERENCES Estadio(ID_Estadio) ON DELETE SET NULL
);

-- Crear tabla Resultados_Partidos (para almacenar los resultados finales de los partidos)
CREATE TABLE Resultados_Partidos (
    ID_Partido INT PRIMARY KEY,
    Goles_Local INT DEFAULT 0,
    Goles_Visitante INT DEFAULT 0,
    FOREIGN KEY (ID_Partido) REFERENCES Partidos(ID_Partido) ON DELETE CASCADE
);

-- Crear tabla Goles_Partidos (para registrar los goles de cada jugador en cada partido)
CREATE TABLE Goles_Partidos (
    ID_Goles INT AUTO_INCREMENT PRIMARY KEY,
    ID_Partido INT,
    ID_Jugador INT,
    Goles INT,
    FOREIGN KEY (ID_Partido) REFERENCES Partidos(ID_Partido) ON DELETE CASCADE,
    FOREIGN KEY (ID_Jugador) REFERENCES Jugadores(ID_Jugador) ON DELETE CASCADE
);

-- Crear tabla Estadisticas_Partidos (para registrar estadísticas de cada jugador en cada partido)
CREATE TABLE Estadisticas_Partidos (
    ID_Estadistica INT AUTO_INCREMENT PRIMARY KEY,
    ID_Partido INT,
    ID_Jugador INT,
    Asistencias INT DEFAULT 0,
    Faltas INT DEFAULT 0,
    Tarjetas_Amarillas INT DEFAULT 0,
    Tarjetas_Rojas INT DEFAULT 0,
    FOREIGN KEY (ID_Partido) REFERENCES Partidos(ID_Partido) ON DELETE CASCADE,
    FOREIGN KEY (ID_Jugador) REFERENCES Jugadores(ID_Jugador) ON DELETE CASCADE
);



