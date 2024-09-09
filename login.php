<?php
// src/sign-in-admin.php
require_once './guard/user.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (login_user($username, $password)) {
        // Redirect to index.php
        header("Location: index.php");
        exit;
    } else {
        $error_message = "Invalid username or password.";
    }
}
$title = "Login | Toko Puput";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/admin/mdb/css/mdb.min.css">
</head>

<body>
    <div class="w-50 mx-auto mt-5 h-100 justify-content-center align-items-center">
        <!-- Pills navs -->
        <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" href="login.php">Login</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="register.php">Register</a>
            </li>
        </ul>
        <!-- Pills navs -->

        <!-- Pills content -->
        <div class="tab-content">
            <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
                <form action="login.php" method="POST">
                    <?php if (isset($error_message)) { ?>
                    <div class="alert alert-danger text-center"><?php echo $error_message; ?></div>
                    <?php } ?>

                    <!-- Username input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input name="username" type="text" id="loginUsername" class="form-control" required />
                        <label class="form-label" for="loginName">Username</label>
                    </div>

                    <!-- Password input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="password" name="password" id="loginPassword" class="form-control" required />
                        <label class="form-label" for="loginPassword">Password</label>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" data-mdb-button-init data-mdb-ripple-init
                        class="btn btn-primary btn-block mb-4">Login</button>

                    <!-- Register buttons -->
                    <div class="text-center">
                        <p>Not a member? <a href="register.php">Register</a></p>
                    </div>
                </form>
            </div>
        </div>
        <!-- Pills content -->
    </div>
    <script src="./assets/admin/mdb/js/mdb.es.min.js"></script>
</body>

</html>