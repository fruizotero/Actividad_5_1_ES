<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>User Registration</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body>

    <?php

    require_once "./scripts/funciones.php";

    $email = null;
    $password = null;
    $confirm_password = null;
    $role = null;
    $is_form_valid = true;
    $is_user_register = false;
    $errors = [];



    if ($_SERVER["REQUEST_METHOD"] == "POST") {


        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];
        $role = $_POST["role"];

        if (strcasecmp($password, $confirm_password) !== 0) {
            $errors[] = "Las contraseñas no coinciden";
            $is_form_valid = false;
        }

        if (exist_user_email($email)) {
            $errors[] = "Email ya registrado";
            $is_form_valid = false;
        }

        if ($is_form_valid) {
            $errors = [];
            $is_user_register = register_user($email, $password, $role);
        }




        // $users = getUsers();


        // foreach ($users as  $user) {
        //     $email_bd = $user["email"];

        //     if (strcmp($email, $email_bd) == 0) {
        //         echo "Email ya usado, intenta con otro email";
        //         break;
        //     }
        // }


        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
    }




    ?>

    <div class="container mt-5">
        <div class="row justify-content-end">
            <div class="col-2">
                <a href="pages/login.php">Login</a>

            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>Registro de Usuario</h2>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Repita contraseña</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Seleccione el rol:</label>
                        <select class="form-control" id="role" name="role" required>

                            <?php
                            $roles = getRoles();


                            foreach ($roles as  $role) {
                                $id = $role["id"];
                                $name = $role["name"];
                                echo "<option values value=$id>$name</option>";
                            }

                            ?>


                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar usuario</button>

                </form>


            </div>
            <section class="errors"></section>

            <?php

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                if (!$is_form_valid) {

                    foreach ($errors as  $error) {
                        echo "<div class=\"alert alert-danger\" role=\"alert\">$error</div>";
                    }
                }

                if ($is_user_register) {
                    echo "<div class=\"alert alert-success\" role=\"alert\">El usuario se creo correctamente</div>";
                } else {
                    echo "<div class=\"alert alert-danger\" role=\"alert\">No se pudo crear el usuario</div>";
                }
            }


            ?>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery (required for Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>