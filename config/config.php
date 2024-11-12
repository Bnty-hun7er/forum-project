<?php 

    define("HOST", "localhost");
    define("USER", "root");
    define("PASSWORD" , "") ;
    define("DATABASE", "forum");

    try {
        $conn = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER, PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "DB connection Successful"; 
    } 
    catch(PDOException $exp) {
        echo "Failed db connection " . $exp->getMessage();
    }

?>
