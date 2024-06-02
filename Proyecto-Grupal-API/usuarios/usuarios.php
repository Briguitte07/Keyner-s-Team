<?php   

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/database.php";

$database = new DatabasesConexion();
$conn = $database->obtenerConn();
$database->checkConn();

$request_method = $_SERVER["REQUEST_METHOD"];


switch ($request_method) {

    case 'POST':
        crearUsuario();
        break;
    case 'PUT':
        actualizarUsuario(); 
        break;
    case 'GET':
        // if (!empty($_GET["id"])) {
        //     $id = intval($_GET["id"]);
        //     obtenerUsuario($id);
        // }else{
        //     obtenerUsuarios();
        // } lo de abajo es un if ternario

        isset($_GET["idUsuario"]) ? obtenerUsuario(intval($_GET["idUsuario"])) : obtenerUsuarios();

        break;
    case 'DELETE':
        borrarUsuarios();
        break;    
    case 'OPTIONS':
        http_response_code(200);
        break;
    default:
        http_response_code(400);
        echo json_encode(array("mensaje"=> "Metodo invalido"));
        break; 

}

function obtenerUsuarios(){
    global $conn;
    $query = "SELECT * FROM `Usuario_KeynersTeam`";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($items);

}


function obtenerUsuario($idUsuario){
    global $conn;
    $query = "SELECT * FROM `Usuario_KeynersTeam` WHERE `idUsuario` = ?";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $idUsuario);
    $stmt->execute();

    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($items);

}


function crearUsuario(){
    global $conn;
    $data = json_decode(file_get_contents("php://input"));

    $query = "INSERT INTO `Usuario_KeynersTeam` ( `nombreUsuario`, `correo`, `password`, `rol`, `estado` )  VALUES (:nombreUsuario, :correo, :password, :rol, :estado )";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":nombreUsuario", $data->nombreUsuario);
    $stmt->bindParam(":correo", $data->correo);
    $stmt->bindParam(":password", $data->password);
    $stmt->bindParam(":rol", $data->rol);
    $stmt->bindParam(":estado", $data->estado);

    if($stmt->execute()){
        http_response_code(200);
        echo json_encode(array("mensaje"=> "crear Usuario completo"));
    }else{
        http_response_code(500);
        echo json_encode(array("mensaje"=> "crear Usuario incompleto"));
    }
    
}

function actualizarUsuario(){
    global $conn;
    $data = json_decode(file_get_contents("php://input"));

    $query = "UPDATE `Usuario_KeynersTeam` SET `nombreUsuario`= :nombreUsuario, `correo`= :correo, `password`=:password, `rol`=:rol, `estado`=:estado WHERE `idUsuario`=:idUsuario";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(":idUsuario", $data->idUsuario);
    $stmt->bindParam(":nombreUsuario", $data->nombreUsuario);
    $stmt->bindParam(":correo", $data->correo);
    $stmt->bindParam(":password", $data->password);
    $stmt->bindParam(":rol", $data->rol);
    $stmt->bindParam(":estado", $data->estado);

    if($stmt->execute()){
        http_response_code(200);
        echo json_encode(array("mensaje"=> "Actualizar Usuario completo"));
    }else{
        http_response_code(500);
        echo json_encode(array("mensaje"=> "Actualizar Usuario incompleto"));
    }
}


function borrarUsuarios(){
    global $conn;
    $data = json_decode(file_get_contents("php://input"));

    $query = "DELETE FROM `Usuario_KeynersTeam` WHERE `idUsuario`=:idUsuario";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":idUsuario", $data->idUsuario);


    if($stmt->execute()){
        http_response_code(200);
        echo json_encode(array("mensaje"=> "Borrar Usuario completo"));
    }else{
        http_response_code(500);
        echo json_encode(array("mensaje"=> "Borrar Usuario incompleto"));
    }
}

?>