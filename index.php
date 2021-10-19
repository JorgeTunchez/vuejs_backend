<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Conecta a la base de datos  con usuario, contraseña y nombre de la BD
$servidor = "localhost:3308"; $usuario = "root"; $contrasenia = ""; $nombreBaseDatos = "vue_clientes";
$conexionBD = new mysqli($servidor, $usuario, $contrasenia, $nombreBaseDatos);


// Consulta datos y recepciona una clave para consultar dichos datos con dicha clave
if (isset($_GET["consultar"])){
    $sqlClientes = mysqli_query($conexionBD,"SELECT * FROM clientes WHERE id=".$_GET["consultar"]);
    if(mysqli_num_rows($sqlClientes) > 0){
        $clientes = mysqli_fetch_all($sqlClientes,MYSQLI_ASSOC);
        echo json_encode($clientes);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
//borrar pero se le debe de enviar una clave ( para borrado )
if (isset($_GET["borrar"])){
    $sqlClientes = mysqli_query($conexionBD,"DELETE FROM clientes WHERE id=".$_GET["borrar"]);
    if($sqlClientes){
        echo json_encode(["success"=>1]);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
//Inserta un nuevo registro y recepciona en método post los datos de nombre y correo
if(isset($_GET["insertar"])){
    $data = json_decode(file_get_contents("php://input"));
    $nombre=$data->nombre;
    $correo=$data->correo;
        if(($correo!="")&&($nombre!="")){
            
    $sqlClientes = mysqli_query($conexionBD,"INSERT INTO clientes(nombre,correo) VALUES('$nombre','$correo') ");
    echo json_encode(["success"=>1]);
        }
    exit();
}
// Actualiza datos pero recepciona datos de nombre, correo y una clave para realizar la actualización
if(isset($_GET["actualizar"])){
    
    $data = json_decode(file_get_contents("php://input"));

    $id=(isset($data->id))?$data->id:$_GET["actualizar"];
    $nombre=$data->nombre;
    $correo=$data->correo;
    
    $sqlClientes = mysqli_query($conexionBD,"UPDATE clientes SET nombre='$nombre',correo='$correo' WHERE id='$id'");
    echo json_encode(["success"=>1]);
    exit();
}
// Consulta todos los registros de la tabla empleados
$sqlClientes = mysqli_query($conexionBD,"SELECT * FROM clientes");
if(mysqli_num_rows($sqlClientes) > 0){
    $clientes = mysqli_fetch_all($sqlClientes,MYSQLI_ASSOC);
    echo json_encode($clientes);
}
else{ echo json_encode([["success"=>0]]); }


?>
