<?php
require_once './guard/user.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    if (register_user($username, $email, $password, $is_admin)) {
        if ($is_admin) {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        $error_message = "Registration failed. Please try again.";
    }
}

$title = "Admin Register";
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
        <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="login-admin.php">Login</a>
            </li>
            <li class="nav-item" role="presentation" href="register.php"><a class="nav-link active"
                    href="register-admin.php">Register</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active">
                <form action="register-admin.php" method="POST">
                    <?php if (isset($error_message)) { ?>
                    <div class="alert alert-danger text-center"><?php echo $error_message; ?></div>
                    <?php } ?>
                    <!-- Username input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="text" id="registerUsername" name="username" class="form-control" required />
                        <label class="form-label" for="registerUsername">Username</label>
                    </div>

                    <!-- Email input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="email" id="registerEmail" name="email" class="form-control" required />
                        <label class="form-label" for="registerEmail">Email</label>
                    </div>

                    <!-- Password input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="password" id="registerPassword" name="password" class="form-control" required />
                        <label class="form-label" for="registerPassword">Password</label>
                    </div>

                    <!-- Checkbox -->
                    <div class="form-check d-flex justify-content-center mb-4">
                        <input class="form-check-input me-2" type="checkbox" name="is_admin" value="1"
                            id="registerCheck" checked aria-describedby="registerCheckHelpText" />
                        <label class="form-check-label" for="registerCheck">
                            Register as an admin
                        </label>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" data-mdb-button-init data-mdb-ripple-init
                        class="btn btn-primary btn-block mb-3">Sign in</button>
                </form>
            </div>
        </div>

    </div>
    </div>
</body>

</html>