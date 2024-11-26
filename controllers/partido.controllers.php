<?php
error_reporting(E_ALL); // Activa todos los niveles de errores
ini_set('display_errors', 1); // Muestra los errores en pantalla

require_once '../models/Partido.php';

class PartidoController {
    private $partidoModel;

    public function __construct() {
        $this->partidoModel = new Partido();
    }

    public function obtenerPartidos($id_torneo) {
        return $this->partidoModel->obtenerPartidos($id_torneo);
    }

    public function obtenerDetallesPartidos($idPartido) {
        return $this->partidoModel->obtenerDetallesPartidos($idPartido);
    }

    public function obtenerGoles($partidoId)
    {
        return $this->partidoModel->obtenerGoles($partidoId);
    }

    public function agregarPartido($params) {
        try {
            return $this->partidoModel->add($params);
        } catch (Exception $e) {
            error_log("Error al agregar partido: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerPartidoPorId($idPartido) {
        return $this->partidoModel->getById($idPartido);
    }

    public function actualizarPartido($params) {
        try {
            return $this->partidoModel->update($params);
        } catch (Exception $e) {
            error_log("Error al actualizar partido: " . $e->getMessage());
            return false;
        }
    }

    public function eliminarPartido($idPartido) {
        try {
            return $this->partidoModel->delete($idPartido);
        } catch (Exception $e) {
            error_log("Error al eliminar partido: " . $e->getMessage());
            return false;
        }
    }

    // Función para obtener equipos registrados
    public function obtenerEquiposRegistrados($idTorneo) {
        try {
            $sql = "
                SELECT DISTINCT ID_Equipo_Local AS ID_Equipo
                FROM Partidos
                WHERE ID_Torneo = :idTorneo
                UNION
                SELECT DISTINCT ID_Equipo_Visitante AS ID_Equipo
                FROM Partidos
                WHERE ID_Torneo = :idTorneo;
            ";

            $stmt = $this->partidoModel->getConexion()->prepare($sql);
            $stmt->bindParam(':idTorneo', $idTorneo, PDO::PARAM_INT);
            $stmt->execute();

            $equiposRegistrados = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $equiposRegistrados[] = $row['ID_Equipo'];
            }

            return array_unique($equiposRegistrados);
        } catch (Exception $e) {
            error_log("Error al obtener equipos registrados: " . $e->getMessage());
            return [];
        }
    }
    public function obtenerPartidosPorTorneo($idTorneo) {
        return $this->partidoModel->obtenerPartidosPorTorneo($idTorneo);
    }
    public function agregarGoles($params)
    {
        return $this->partidoModel->addGoles($params);
    }
    public function agregarResultados($params2)
    {
        return $this->partidoModel->addResultados($params2);
    }
}

// Lógica de solicitud según la acción
if (isset($_GET['action'])) {
    $partidoController = new PartidoController();

    switch ($_GET['action']) {
        case 'obtenerPartidos':

            // tomamos el iD_partido 
            $ID_Partido = $_GET['ID_Torneo'];
            $partidos = $partidoController->obtenerPartidos($ID_Partido);
            echo json_encode(empty($partidos) ? ['error' => 'No se encontraron partidos.'] : $partidos);
            break;

        case 'obtenerDetallesPartidos':
            if (isset($_GET['ID_Partido'])) {
                $idPartido = intval($_GET['ID_Partido']);
                $detalles = $partidoController->obtenerDetallesPartidos($idPartido);
                echo json_encode(empty($detalles) ? ['error' => 'No se encontraron detalles de partidos.'] : $detalles);
            } else {
                echo json_encode(['error' => 'ID de partido no proporcionado.']);
            }
            break;

            case 'agregarPartido':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Validación de datos
                    if (isset($_POST['ID_Estadio'], $_POST['ID_Árbitro'], $_POST['ID_Torneo'], $_POST['ID_Equipo_Local'], $_POST['ID_Equipo_Visitante'], $_POST['Fecha'])) {
                        $params = [
                            'idEstadio' => $_POST['ID_Estadio'],
                            'idArbitro' => $_POST['ID_Árbitro'],
                            'idTorneo' => $_POST['ID_Torneo'],
                            'idEquipoLocal' => $_POST['ID_Equipo_Local'],
                            'idEquipoVisitante' => $_POST['ID_Equipo_Visitante'],
                            'fechaHora' => $_POST['Fecha'],
                        ];
                        $success = $partidoController->agregarPartido($params);
                        if ($success) {
                            header('Location: http://localhost/campeonato/public/Partido/ListarPartido.php');
                            exit;
                        } else {
                            echo "No se pudo agregar el partido.";
                        }
                    } else {
                        echo "Faltan datos en la solicitud.";
                    }
                }
                break;
            

        case 'obtenerPartido':
            if (isset($_GET['ID_Partido'])) {
                $idPartido = intval($_GET['ID_Partido']);
                $partido = $partidoController->obtenerPartidoPorId($idPartido);
                echo json_encode($partido ? $partido : ['error' => 'Partido no encontrado.']);
            } else {
                echo json_encode(['error' => 'ID de partido no proporcionado.']);
            }
            break;

        case 'editarPartido':
            if (isset($_GET['ID_Partido'])) {
                $idPartido = intval($_GET['ID_Partido']);
                $partido = $partidoController->obtenerPartidoPorId($idPartido);
                if ($partido) {
                    include 'views/editarPartido.php';  // Aquí es mejor separar las vistas
                } else {
                    echo json_encode(['error' => 'Partido no encontrado.']);
                }
            } else {
                echo json_encode(['error' => 'ID de partido no proporcionado.']);
            }
            break;

        case 'actualizarPartido':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Validación de datos
                if (isset($_POST['ID_Partido'], $_POST['ID_Árbitro'], $_POST['ID_Torneo'], $_POST['ID_Estadio'], $_POST['ID_Equipo_Local'], $_POST['ID_Equipo_Visitante'], $_POST['Fecha'])) {
                    $params = [
                        'idPartido' => $_POST['ID_Partido'],
                        'idArbitro' => $_POST['ID_Árbitro'],
                        'idTorneo' => $_POST['ID_Torneo'],
                        'idEstadio' => $_POST['ID_Estadio'],
                        'idEquipoLocal' => $_POST['ID_Equipo_Local'],
                        'idEquipoVisitante' => $_POST['ID_Equipo_Visitante'],
                        'fechaHora' => $_POST['Fecha'],
                    ];
                    $resultado = $partidoController->actualizarPartido($params);
                    echo json_encode(['success' => $resultado, 'message' => $resultado ? 'Partido actualizado correctamente' : 'Hubo un error al actualizar el partido.']);
                } else {
                    echo json_encode(['error' => 'Faltan datos para actualizar el partido.']);
                }
            }
            break;

            case 'eliminarPartido':
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
                    $idPartido = intval($_POST['id']);
                    $success = $partidoController->eliminarPartido($idPartido);
                    if ($success) {
                        header('Location: http://localhost/campeonato/public/Partido/ListarPartido.php');
                        exit; // Detener la ejecución después de la redirección
                    } else {
                        echo "No se pudo eliminar el partido.";
                    }
                } else {
                    echo "Faltan datos en la solicitud.";
                }
                break;
            
            

        // Nueva acción para obtener los equipos registrados
        case 'obtenerEquiposRegistrados':
            if (isset($_GET['ID_Torneo'])) {
                $idTorneo = intval($_GET['ID_Torneo']);
                $equiposRegistrados = $partidoController->obtenerEquiposRegistrados($idTorneo);
                echo json_encode($equiposRegistrados);
            } else {
                echo json_encode(['error' => 'ID_Torneo no proporcionado.']);
            }
            break;
        case 'agregarResultado':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['partidoId'])) {
                    $params = [
                        'id_partido' => $_POST['partidoId'],
                        'local' => [
                            'golesLocal' => $_POST['golesLocal'],
                            'jugadorLocal' => $_POST['jugadorLocal'],
                        ],
                        'visitante' => [
                            'golesVisitante' => $_POST['golesVisitante'],
                            'jugadorVisitante' => $_POST['jugadorVisitante'],
                        ]
                    ];

                    $params2 = [
                        "id_partido" => $_POST['partidoId'],
                        "goles_visitante" => $_POST['golesVisitante'],
                        "goles_local" => $_POST['golesLocal']
                    ];
                    $success = $partidoController->agregarGoles($params);
                    $success2 = $partidoController->agregarResultados($params2);
                    
                    
                    if ($success) {
                        header('Location: http://localhost/campeonato/public/Partido/ListarPartido.php');
                        exit;
                    } else {
                        echo "No se pudo agregar el resultado.";
                    }
                } else {
                    echo "Faltan datos en la solicitud.";
                }
            }
            case 'obtenerPartidosPorTorneo':
                if (isset($_GET['ID_Torneo'])) {
                    $idTorneo = intval($_GET['ID_Torneo']);
    
                    $partidos = $partidoController->obtenerPartidosPorTorneo($idTorneo);
    
                    echo json_encode(empty($partidos) ? ['error' => 'No se encontraron partidos para el torneo.'] : $partidos);
                } else {
                    echo json_encode(['error' => 'ID_Torneo no proporcionado.']);
                }
                break;
            case 'obtenerGoles':
                if(isset($_GET['ID_Partido']))
                {
                    $ID_Partido = intval($_GET['ID_Partido']);
                    $goles = $partidoController->obtenerGoles($ID_Partido);
    
                    echo json_encode(empty($goles)? ['error' => 'No se encontraron goles para el partido.'] : $goles);
                }
                break; 
            default:
                echo json_encode(['error' => 'Acción no válida.']);
                break;

    }
}
?>
