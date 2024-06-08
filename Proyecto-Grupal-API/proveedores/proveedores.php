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
        
        global $conn;

            $query = "SELECT * FROM `Proveedores_KeynersTeam`";
            $stm = $conn->prepare($query);
            $stm->execute();
    
            $resultado = $stm->fetchAll(PDO::FETCH_ASSOC);
    
            echo json_encode($resultado);
        
    }

//idProveedor nombreProveedor dirección Proveedores_KeynersTeam

    function obtenerProveedor($idProveedor){
        global $conn;

            $query = "SELECT * FROM `Proveedores_KeynersTeam` where  `idProveedor`=?";
            $stm = $conn->prepare($query);            
            $stm->bindParam(1, $idProveedor);
            $stm->execute();
    
            $resultado = $stm->fetchAll(PDO::FETCH_ASSOC);
    
            echo json_encode($resultado);
        
    
    }

//idProveedor nombreProveedor dirección Proveedores_KeynersTeam

    function insertarProveedor(){
        global $conn;
        $data = json_decode(file_get_contents("php://input"));
        
        $query = "INSERT INTO `Proveedores_KeynersTeam` ( `nombreProveedor`, `direccion`) values ( :nombreProveedor, :direccion)";
        $stm = $conn->prepare($query);            
        $stm->bindParam(":nombreProveedor", $data->nombreProveedor);
        $stm->bindParam(":direccion", $data->direccion);

   
        if($stm->execute()){
            
            echo json_encode(array("message" => "Proveedor registrado correctamente", "code" => "success"));
        }else{
            
            echo json_encode(array("message" => "El proveedor no se logró registrar", "code" => "danger"));
        }

    }

//idProveedor nombreProveedor dirección Proveedores_KeynersTeam

    function actualizarProveedor(){
        global $conn;
        $data = json_decode(file_get_contents("php://input"));
        
        $query = "UPDATE `Proveedores_KeynersTeam` SET `nombreProveedor`= :nombreProveedor, `direccion`=:direccion where `idProveedor`=:idProveedor";
          
        $stm = $conn->prepare($query);            
        $stm->bindParam(":idProveedor", $data->idProveedor);
        $stm->bindParam(":nombreProveedor", $data->nombreProveedor);
        $stm->bindParam(":direccion", $data->direccion);

   
        if($stm->execute()){
            
            echo json_encode(array("message" => "Proveedor modificado correctamente", "code" => "success"));
        }else{
            
            echo json_encode(array("message" => "El proveedor no se logró modificar", "code" => "danger"));
        }

    }

//idProveedor nombreProveedor dirección Proveedores_KeynersTeam

    function borrarProveedor(){
        global $conn;
        $data = json_decode(file_get_contents("php://input"));
        
        $query = "DELETE FROM `Proveedores_KeynersTeam` where `idProveedor`=:idProveedor";
          
        $stm = $conn->prepare($query);            
        $stm->bindParam(":idProveedor", $data->idProveedor);
   
        if($stm->execute()){
            
            echo json_encode(array("message" => "Proveedor eliminado correctamente", "code" => "success"));
        }else{
            
            echo json_encode(array("message" => "El proveedor no se logró eliminar", "code" => "danger"));
        }
    }



?>