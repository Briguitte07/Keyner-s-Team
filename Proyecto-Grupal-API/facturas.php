<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Methods: PUT, POST, DELETE, GET, OPTIONS');
    header('Access-Control-Max-Age: 3600');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Origin, Authorization, X-Requested-With');

    include_once '../config/database.php';

    $database = new DatabasesConexion();
    $db = $database->obtenerConn();


    $request_method = $_SERVER["REQUEST_METHOD"];

    switch ($request_method){

        case 'PUT':
            http_response_code(200);
            actualizarFactura();
            break;

        case 'POST':            
            insertarFactura();
            break;
                
        case 'DELETE':
            http_response_code(200);
            borrarFactura();
            break;
                    
        case 'GET':
                if (!empty($_GET["idFactura"])){
                    $idFactura = intval($_GET["idFactura"]);
                    obtenerFactura($idFactura);
                }
                else{
                    obtenerFacturas();
                }
            break;
                                            
        case 'OPTIONS':
            http_response_code(200);
            break;
                            
        default:
            http_response_code(200);
            break;


    }

//idFactura	idUsuario	idLibro	nombreUsuario	fecha	título	cantidad	totalPagar	Factura_KeynersTeam

    function obtenerFacturas(){
        
        global $db;

            $query = "SELECT `*` FROM `Factura_KeynersTeam`";
            $stm = $db->prepare($query);
            $stm->execute();
    
            $resultado = $stm->fetchAll(PDO::FETCH_ASSOC);
    
            echo json_encode($resultado);
        
    }

    function obtenerFactura($idFactura){
        global $db;

            $query = "SELECT `*` FROM `Factura_KeynersTeam` where  `idFactura`=?";
            $stm = $db->prepare($query);            
            $stm->bindParam(1, $idFactura);
            $stm->execute();
    
            $resultado = $stm->fetchAll(PDO::FETCH_ASSOC);
    
            echo json_encode($resultado);
        
    
    }

//idFactura	idUsuario	idLibro	nombreUsuario	fecha	título	cantidad	totalPagar	Factura_KeynersTeam

    function insertarFactura(){
        global $db;
        $data = json_decode(file_get_contents("php://input"));
        
        $query = "INSERT INTO `Factura_KeynersTeam` ( `nombreUsuario`, `fecha`, `titulo`, `cantidad`, `totalPagar` ) values ( :nombreUsuario, :fecha, :titulo, :cantidad, :totalPagar)";
        $stm = $db->prepare($query);            
        $stm->bindParam(":nombreUsuario", $data->nombreUsuario);
        $stm->bindParam(":fecha", $data->fecha);
        $stm->bindParam(":titulo", $data->titulo);
        $stm->bindParam(":cantidad", $data->cantidad);
        $stm->bindParam(":totalPagar", $data->totalPagar);
   
        if($stm->execute()){
            
            echo json_encode(array("message" => "Datos ingresados correct", "code" => "success"));
        }else{
            
            echo json_encode(array("message" => "Datos ingresados incorrect", "code" => "danger"));
        }

    }

//idFactura	idUsuario	idLibro	nombreUsuario	fecha	título	cantidad	totalPagar	Factura_KeynersTeam

    function actualizarFactura(){
        global $db;
        $data = json_decode(file_get_contents("php://input"));
        
        $query = "UPDATE `Factura_KeynersTeam` SET `nombreUsuario`= :nombreUsuario, `fecha`=:fecha, `título`=:título, `cantidad`=:cantidad, `totalPagar`=:totalPagar where `idFactura`=:idFactura";
          
        $stm = $db->prepare($query);            
        $stm->bindParam(":idFactura", $data->idFactura);
        $stm->bindParam(":nombreUsuario", $data->nombreUsuario);
        $stm->bindParam(":titulo", $data->titulo);
        $stm->bindParam(":fecha", $data->fecha);
        $stm->bindParam(":cantidad", $data->cantidad);
        $stm->bindParam(":totalPagar", $data->totalPagar);
   
        if($stm->execute()){
            
            echo json_encode(array("message" => "Datos actualizados correct", "code" => "success"));
        }else{
            
            echo json_encode(array("message" => "Datos actualizados incorrect", "code" => "danger"));
        }

    }

//idFactura	idUsuario	idLibro	nombreUsuario	fecha	título	cantidad	totalPagar	Factura_KeynersTeam

    function borrarFactura(){
        global $db;
        $data = json_decode(file_get_contents("php://input"));
        
        $query = "DELETE FROM `Factura_KeynersTeam` where `idFactura`=:idFactura";
          
        $stm = $db->prepare($query);            
        $stm->bindParam(":idFactura", $data->idFactura);
   
        if($stm->execute()){
            
            echo json_encode(array("message" => "Datos eliminados correct", "code" => "success"));
        }else{
            
            echo json_encode(array("message" => "Datos eliminados incorrect", "code" => "danger"));
        }
    }



?>