<?php

    //La source, point d'enter du site du site
    define("URL", str_replace("read.php","",(isset($_SERVER['HTTPS'])? "https" : "http").
    "://".$_SERVER['HTTP_HOST'].$_SERVER["PHP_SELF"]));

    class Cadeaux{

        // Connection
        private $conn;

        // Table
        private $db_table = "cadeaux";

        // Columns
        public $id;
        public $nom;
        public $description;
        public $stock;
        public $updated_at;
        public $created_at;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getCadeaux(){
            $sqlQuery = "SELECT * FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
        

        // READ single
        public function getOneCadeaux(){
            $sqlQuery = "SELECT
                        id, 
                        nom, 
                        description, 
                        stock, 
                        updated_at, 
                        created_at
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       id = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->nom = $dataRow['nom'];
            $this->description = $dataRow['description'];
            $this->stock = $dataRow['stock'];
            $this->updated_at = $dataRow['updated_at'];
            $this->created_at = $dataRow['created_at'];
        }        


        // UPDATE
        public function updateCadeau(){

            $debug=1; 
            $sqlQuery = "UPDATE cadeaux SET stock = :stock, updated_at = :updated_at WHERE id = :id";
            

            $stmt = $this->conn->prepare($sqlQuery);
            



            $this->stock=htmlspecialchars(strip_tags($this->stock));
            $this->id=htmlspecialchars(strip_tags($this->id));
            //var_dump($sqlQuery);
            $stock = (int) $this->stock;
            $id = (int) $this->id;
            // bind data
            $stmt->bindParam(":stock", $stock);
            $stmt->bindParam(":updated_at", $this->updated_at);
            $stmt->bindParam(":id",$id);


            try{
                $stmt->execute();
                    return true;
            }catch(Exception $e)
            {
                echo $e->getMessage();
                return false;
            }
           

           
        }

        
    }
?>