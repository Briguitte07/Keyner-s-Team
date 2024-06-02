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

            $query = "SELECT `*` FROM `Libros_KeynersTeam`";
            $stm = $conn->prepare($query);
            $stm->execute();
    
            $resultado = $stm->fetchAll(PDO::FETCH_ASSOC);
    
            echo json_encode($resultado);
        
    }

//idLibro	título	autor	editorial	descripción	precio	estado	idProveedor	Libros_KeynersTeam

    function obtenerLibro($idLibro){
        global $conn;

            $query = "SELECT `*` FROM `Libros_KeynersTeam` where  `idLibro`=?";
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
        
        $query = "INSERT INTO `Libros_KeynersTeam` ( `título`, `autor`, `editorial`,`descripción`, `precio`, `estado` ) 
        values ( :título, :autor, :editorial, :descripción, :precio, :estado)";
        $stm = $conn->prepare($query);                    
        $stm->bindParam(":título", $data->título);
        $stm->bindParam(":autor", $data->autor);
        $stm->bindParam(":editorial", $data->editorial); 
        $stm->bindParam(":descripción", $data->descripción);
        $stm->bindParam(":precio", $data->precio);
        $stm->bindParam(":estado", $data->nombre);
        

        if($stm->execute()){
            
            echo json_encode(array("message" => "Datos ingresados correct", "code" => "success"));
        }else{
            
            echo json_encode(array("message" => "Datos ingresados incorrect", "code" => "danger"));
        }

    }

//idLibro	título	autor	editorial	descripción	precio	estado	idProveedor	Libros_KeynersTeam

    function actualizarLibro(){
        global $conn;
        $data = json_decode(file_get_contents("php://input"));
        
        $query = "UPDATE `Libros_KeynersTeam` SET `título`= :título, `autor`=:autor, `editorial`= :editorial, `descripción`=:descripción, `precio`= :precio, `estado`=:estado, where `idLibro`=:idLibro";

        $stm = $conn->prepare($query);
        $stm->bindParam(":idLibro", $data->idLibro);            
        $stm->bindParam(":título", $data->título);
        $stm->bindParam(":autor", $data->autor);
        $stm->bindParam(":editorial", $data->editorial); 
        $stm->bindParam(":descripción", $data->descripción);
        $stm->bindParam(":precio", $data->precio);
        $stm->bindParam(":estado", $data->nombre);
        if($stm->execute()){
            
            echo json_encode(array("message" => "Datos actualizados correct", "code" => "success"));
        }else{
            
            echo json_encode(array("message" => "Datos actualizados incorrect", "code" => "danger"));
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
            
            echo json_encode(array("message" => "Datos eliminados correct", "code" => "success"));
        }else{
            
            echo json_encode(array("message" => "Datos eliminados incorrect", "code" => "danger"));
        }
    }



?>