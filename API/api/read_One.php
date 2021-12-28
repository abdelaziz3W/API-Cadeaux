<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../class/cadeaux.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new Cadeaux($db);

    $item->id = isset($_GET['id']) ? $_GET['id'] : die();
  
    $item->getOneCadeaux();

    if($item->nom != null){
        // create array
        $cad_arr = array(
            "id" =>  $item->id,
            "nom" => $item->nom,
            "description" => $item->description,
            "stock" => $item->stock,
            "updated_at" => $item->updated_at,
            "created_at" => $item->created_at
        );
      
        http_response_code(200);
        echo json_encode($cad_arr);
    }
      
    else{
        http_response_code(404);
        echo json_encode("Cadeaux not found.");
    }
?>