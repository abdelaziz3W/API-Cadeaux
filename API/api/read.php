<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
   
    include_once '../config/database.php';
    include_once '../class/cadeaux.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new Cadeaux($db);

    $stmt = $items->getCadeaux();
    $itemCount = $stmt->rowCount();


    //echo json_encode($itemCount);

    if($itemCount > 0){
        
        $cadeauxArr = array();
        $cadeauxArr["body"] = array();
       // $cadeauxArr["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "nom" => $nom,
                "description" => $description,
                "stock" => $stock,
                "updated_at" => $updated_at,
                "created_at" => $created_at
            );

            array_push($cadeauxArr["body"], $e);
        }
        echo json_encode($cadeauxArr);
    }

    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>