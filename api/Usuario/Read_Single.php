<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  include_once '../../config/Database.php';
  include_once '../../models/Usuario.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate blog post object
  $usuario = new Usuario($db);
  // Get ID
  $usuario->id = isset($_GET['id']) ? $_GET['id'] : die();
  // Get post
  $usuario->read_single();
  // Create array
  $resposta = array(
    'id' => $usuario->id,
    'nome' => $usuario->nome,
    'telefone' => $usuario->telefone,
    'email' => $usuario->email
  );
  // Make JSON
  print_r(json_encode($resposta));