<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include_once '../../config/Database.php';
include_once '../../models/Usuario.php';

$database = new Database();
$db = $database->Connect();

$usuario = new Usuario($db);

$result = $usuario->read();

$num = $result->rowCount();

if($num > 0){
    $usuarios = array();
    $usuarios['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $item = array(
            'id' => $id,
            'nome' => $nome,
            'telefone' => $telefone,
            'email' => $email
        );
        array_push($usuarios['data'], $item);
    }
    echo json_encode($usuarios);
}else{
    echo json_encode(
        array('message' => 'nenhum usuario foi encontrado')
    );
}