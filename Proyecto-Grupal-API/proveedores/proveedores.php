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
            actualizarProveedor();
            break;

        case 'POST':            
            insertarProveedor();
            break;
                
        case 'DELETE':
            http_response_code(200);
            borrarProveedor();
            break;
                    
        case 'GET':
                if (!empty($_GET["idProveedor"])){
                    $idProveedor = intval($_GET["idProveedor"]);
                    obtenerProveedor($idProveedor);
                }
                else{
                    obtenerProveedores();
                }
            break;
                                            
        case 'OPTIONS':
            http_response_code(200);
            break;
                            
        default:
            http_response_code(200);
            break;


    }

//idProveedor nombreProveedor dirección Proveedores_KeynersTeam

    function obtenerProveedores(){
        
        global $db;

            $query = "SELECT `*` FROM `Proveedores_KeynersTeam`";
            $stm = $db->prepare($query);
            $stm->execute();
    
            $resultado = $stm->fetchAll(PDO::FETCH_ASSOC);
    
            echo json_encode($resultado);
        
    }

//idProveedor nombreProveedor dirección Proveedores_KeynersTeam

    function obtenerProveedor($idProveedor){
        global $db;

            $query = "SELECT `*` FROM `Proveedores_KeynersTeam` where  `idProveedor`=?";
            $stm = $db->prepare($query);            
            $stm->bindParam(1, $idProveedor);
            $stm->execute();
    
            $resultado = $stm->fetchAll(PDO::FETCH_ASSOC);
    
            echo json_encode($resultado);
        
    
    }

//idProveedor nombreProveedor dirección Proveedores_KeynersTeam

    function insertarProveedor(){
        global $db;
        $data = json_decode(file_get_contents("php://input"));
        
        $query = "INSERT INTO `Proveedores_KeynersTeam` ( `nombreProveedor`, `dirección`) values ( :nombreProveedor, :estado)";
        $stm = $db->prepare($query);            
        $stm->bindParam(":nombreProveedor", $data->nombreProveedor);
        $stm->bindParam(":dirección", $data->dirección);

   
        if($stm->execute()){
            
            echo json_encode(array("message" => "Datos ingresados correct", "code" => "success"));
        }else{
            
            echo json_encode(array("message" => "Datos ingresados incorrect", "code" => "danger"));
        }

    }

//idProveedor nombreProveedor dirección Proveedores_KeynersTeam

    function actualizarProveedor(){
        global $db;
        $data = json_decode(file_get_contents("php://input"));
        
        $query = "UPDATE `Proveedores_KeynersTeam` SET `nombreProveedor`= :nombreProveedor, `dirección`=:dirección where `idProveedor`=:idProveedor";
          
        $stm = $db->prepare($query);            
        $stm->bindParam(":idProveedor", $data->idProveedor);
        $stm->bindParam(":nombreProveedor", $data->nombreProveedor);
        $stm->bindParam(":dirección", $data->dirección);

   
        if($stm->execute()){
            
            echo json_encode(array("message" => "Datos actualizados correct", "code" => "success"));
        }else{
            
            echo json_encode(array("message" => "Datos actualizados incorrect", "code" => "danger"));
        }

    }

//idProveedor nombreProveedor dirección Proveedores_KeynersTeam

    function borrarProveedor(){
        global $db;
        $data = json_decode(file_get_contents("php://input"));
        
        $query = "DELETE FROM `Proveedores_KeynersTeam` where `idProveedor`=:idProveedor";
          
        $stm = $db->prepare($query);            
        $stm->bindParam(":idProveedor", $data->idProveedor);
   
        if($stm->execute()){
            
            echo json_encode(array("message" => "Datos eliminados correct", "code" => "success"));
        }else{
            
            echo json_encode(array("message" => "Datos eliminados incorrect", "code" => "danger"));
        }
    }



?>