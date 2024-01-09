<?php

require_once "conexion.php";
 function getRoles()
 {

     try {
         $conn = getConnection();
         $query = "SELECT * from rol";
         $stmt = $conn->prepare($query);
         $stmt->execute();
         $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

         return $values;
     } catch (PDOException $ex) {
         echo $ex->getMessage();
     }
 }

 function getUsers()
 {

     try {
         $conn = getConnection();
         $query = "SELECT * FROM notas.usuario;";
         $stmt = $conn->prepare($query);
         $stmt->execute();
         $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

         return $values;
     } catch (PDOException $ex) {
         echo $ex->getMessage();
     }
 }

 function exist_user_email($email){

    try {
        $conn = getConnection();
        $query = "SELECT * from usuario WHERE email=:email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam("email", $email);
        $stmt->execute();

        $rows_affected = $stmt->rowCount();

        return $rows_affected >= 1;



    } catch (PDOException $ex) {
        echo "error: " . $ex->getMessage();
    }

 }


?>