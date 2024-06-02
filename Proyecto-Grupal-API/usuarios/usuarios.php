<?php   

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/db.php";

$database = new Database();
$conn = $database->getConn();
$database->checkConn();
echo "<br>";
$variableusuarios = $database->getUsuarios();

if ($variableusuarios){
    echo "<pre>";
    print_r($variableusuarios);
    echo "</pre>";
}
else{
    echo "<pre>Sin registros";
    echo "</pre>";
}

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

public function checkConn(){
    if($this->conn){
        echo "conectado";
    }
    else{
        echo 'Fuera de servicio';
    }
}

function obtenerUsuarios(){
    global $db;
    $query = "SELECT `*` FROM `Usuario_KeynersTeam`";
    $stmt = $db->prepare($query);
    $stmt->execute();

    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($items);

}


function obtenerUsuario($id){
    global $db;
    $query = "SELECT `*` FROM `Usuario_KeynersTeam` WHERE `idUsuario` = ?";
    $stmt = $db->prepare($query);
    $stmt->bindParam(1, $id);
    $stmt->execute();

    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($items);

}


function crearUsuario(){
    global $db;
    $data = json_decode(file_get_contents("php://input"));

    $query = "INSERT INTO `Usuario_KeynersTeam` ( `nombreUsuario`, `correo`, `password`, `rol`, `estado` )  VALUES (:nombreUsuario, :correo, :password, :rol, :estado )";
    $stmt = $db->prepare($query);
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
    global $db;
    $data = json_decode(file_get_contents("php://input"));

    $query = "UPDATE `Usuario_KeynersTeam` SET `nombreUsuario`= :nombreUsuario, `correo`= :correo, `password`=:password, `rol`=:rol, `estado`=:estado WHERE `idUsuario`=:idUsuario";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":nombreUsuario", $data->nombreUsuario);
    $stmt->bindParam(":correo", $data->correo);
    $stmt->bindParam(":password", $data->password);
    $stmt->bindParam(":rol", $data->rol);
    $stmt->bindParam(":estado", $data->estado);
    $stmt->bindParam(":idUsuario", $data->id);


    if($stmt->execute()){
        http_response_code(200);
        echo json_encode(array("mensaje"=> "Actualizar Usuario completo"));
    }else{
        http_response_code(500);
        echo json_encode(array("mensaje"=> "Actualizar Usuario incompleto"));
    }
}


function borrarUsuarios(){
    global $db;
    $data = json_decode(file_get_contents("php://input"));

    $query = "DELETE FROM `Usuario_KeynersTeam` WHERE `idUsuario`=:idUsuario";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":idUsuario", $data->idUsuarios);


    if($stmt->execute()){
        http_response_code(200);
        echo json_encode(array("mensaje"=> "Borrar Usuario completo"));
    }else{
        http_response_code(500);
        echo json_encode(array("mensaje"=> "Borrar Usuario incompleto"));
    }
}

?>