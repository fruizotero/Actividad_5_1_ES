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

function exist_user_email($email)
{

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


function register_user($email, $pass, $role)
{

    $success = false;

    try {
        $conn = getConnection();
        $conn->beginTransaction();

        $query_add_user = "INSERT INTO usuario(email, pwdhash) VALUES(:email, :pwdhash)";
        $query_add_role = "INSERT INTO usuario_rol(idUsuario, idRol) VALUES(:idUsuario, :idRol)";

        $stmt_add_user = $conn->prepare($query_add_user);
        // $stmt_add_user->debugDumpParams();
        $success =  $stmt_add_user->execute(["email" => $email, "pwdhash" => password_hash($pass, PASSWORD_BCRYPT)]);
        // $stmt_add_user->debugDumpParams();

        $idUsuario = $conn->lastInsertId();

        $stmt_add_role = $conn->prepare($query_add_role);
        // $stmt_add_role->debugDumpParams();
      
        $success = $success && $stmt_add_role->execute(["idUsuario" => $idUsuario, "idRol" => $role]);
        // $stmt_add_role->debugDumpParams();

        if ($success)
            $conn->commit();
        else
            $conn->rollBack();
    } catch (PDOException $ex) {
        $conn->rollBack();
        $success = false;

        echo "error: " . $ex->getMessage();
    }

    return $success;
}
