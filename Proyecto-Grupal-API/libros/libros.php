<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Methods: PUT, POST, DELETE, GET, OPTIONS');
    header('Access-Control-Max-Age: 3600');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Origin, Authorization, X-Requested-With');

    include_once '../config/database.php';

    $database = new DatabasesConexion();
    $conn = $database->obtenerConn();


    $request_method = $_SERVER["REQUEST_METHOD"];

    switch ($request_method){

        case 'PUT':
            http_response_code(200);
            actualizarLibro();
            break;

        case 'POST':            
            insertarLibro();
            break;
                
        case 'DELETE':
            http_response_code(200);
            borrarLibro();
            break;
                    
        case 'GET':
                if (!empty($_GET["idLibro"])){
                    $idLibro = intval($_GET["idLibro"]);
                    obtenerLibro($idLibro);
                }
                else{
                    obtenerLibros();
                }
            break;
                                            
        case 'OPTIONS':
            http_response_code(200);
            break;
                            
        default:
            http_response_code(200);
            break;


    }

//idLibro	título	autor	editorial	descripción	precio	estado	idProveedor	Libros_KeynersTeam

    function obtenerLibros(){
        
        global $conn;

            $query = "SELECT * FROM `Libros_KeynersTeam`";
            $stm = $conn->prepare($query);
            $stm->execute();
    
            $resultado = $stm->fetchAll(PDO::FETCH_ASSOC);
    
            echo json_encode($resultado);
        
    }

//idLibro	título	autor	editorial	descripción	precio	estado	idProveedor	Libros_KeynersTeam

    function obtenerLibro($idLibro){
        global $conn;

            $query = "SELECT * FROM `Libros_KeynersTeam` where  `idLibro`=?";
            $stm = $conn->prepare($query);            
            $stm->bindParam(1, $idLibro);
            $stm->execute();
    
            $resultado = $stm->fetchAll(PDO::FETCH_ASSOC);
    
            echo json_encode($resultado);
        
    
    }

//idLibro	título	autor	editorial	descripción	precio	estado	idProveedor	Libros_KeynersTeam

    function insertarLibro(){
        global $conn;
        $data = json_decode(file_get_contents("php://input"));
        
        $query = "INSERT INTO `Libros_KeynersTeam` ( `titulo`, `autor`, `editorial`,`descripcion`, `precio`, `estado`, `idProveedor` ) 
        values ( :titulo, :autor, :editorial, :descripcion, :precio, :estado, :idProveedor)";
        $stm = $conn->prepare($query);                    
        $stm->bindParam(":titulo", $data->titulo);
        $stm->bindParam(":autor", $data->autor);
        $stm->bindParam(":editorial", $data->editorial); 
        $stm->bindParam(":descripcion", $data->descripcion);
        $stm->bindParam(":precio", $data->precio);
        $stm->bindParam(":estado", $data->estado);
        $stm->bindParam(":idProveedor", $data->idProveedor);
        

        if($stm->execute()){
            
            echo json_encode(array("message" => "Libro registrado correctamente", "code" => "success"));
        }else{
            
            echo json_encode(array("message" => "El libro no se logró registrar", "code" => "danger"));
        }

    }

//idLibro	título	autor	editorial	descripción	precio	estado	idProveedor	Libros_KeynersTeam

    function actualizarLibro(){
        global $conn;
        $data = json_decode(file_get_contents("php://input"));
        
        $query = "UPDATE `Libros_KeynersTeam` SET `titulo`= :titulo, `autor`=:autor, `editorial`= :editorial, `descripcion`=:descripcion, `precio`= :precio, `estado`=:estado, `idProveedor`=:idProveedor where `idLibro`=:idLibro";

        $stm = $conn->prepare($query);
        $stm->bindParam(":idLibro", $data->idLibro);            
        $stm->bindParam(":titulo", $data->titulo);
        $stm->bindParam(":autor", $data->autor);
        $stm->bindParam(":editorial", $data->editorial); 
        $stm->bindParam(":descripcion", $data->descripcion);
        $stm->bindParam(":precio", $data->precio);
        $stm->bindParam(":estado", $data->nombre);
        $stm->bindParam(":idProveedor", $data->idProveedor);
        if($stm->execute()){
            
            echo json_encode(array("message" => "Libro modificado correctamente", "code" => "success"));
        }else{
            
            echo json_encode(array("message" => "El libro no se logró modificar", "code" => "danger"));
        }

    }

//idLibro	título	autor	editorial	descripción	precio	estado	idProveedor	Libros_KeynersTeam

    function borrarLibro(){
        global $conn;
        $data = json_decode(file_get_contents("php://input"));
        
        $query = "DELETE FROM `Libros_KeynersTeam` where `idLibro`=:idLibro";

        $stm = $conn->prepare($query);            
        $stm->bindParam(":idLibro", $data->idLibro);

        if($stm->execute()){
            
            echo json_encode(array("message" => "Libro eliminado correctamente", "code" => "success"));
        }else{
            
            echo json_encode(array("message" => "El libro no se logró eliminar", "code" => "danger"));
        }
    }



?>