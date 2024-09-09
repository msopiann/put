<?php

require_once __DIR__ . '/./guard/user.php';

$success = false;
$error = false;
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $errorMessage = "Invalid email format.";
    } elseif (strlen($password) < 8) {
        $error = true;
        $errorMessage = "Password must be at least 8 characters long.";
    } elseif (!preg_match("/[A-Z]/", $password)) {
        $error = true;
        $errorMessage = "Password must contain at least one uppercase letter.";
    } elseif (!preg_match("/[0-9]/", $password)) {
        $error = true;
        $errorMessage = "Password must contain at least one number.";
    } else {
        // Call the function to register the user
        if (register_user($username, $email, $password, false)) {
            $success = true;
        } else {
            $error = true;
            $errorMessage = "Could not register user.";
        }
    }
}
$title = "Register | Toko Puput";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <!-- Bootstrap Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/admin/mdb/css/mdb.min.css">

    <style>
    .info-icon {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }

    .info-icon .tooltip-text {
        visibility: hidden;
        width: 200px;
        background-color: #000;
        color: #fff;
        text-align: center;
        border-radius: 5px;
        padding: 5px;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        /* Position the tooltip above the icon */
        left: 50%;
        margin-left: -100px;
        /* Center the tooltip */
        opacity: 0;
        transition: opacity 0.3s;
    }

    .info-icon:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
    }

    .toast-container {
        position: fixed;
        top: 1rem;
        right: 1rem;
        z-index: 1055;
    }

    .loading-bar {
        position: relative;
        height: 4px;
        background-color: #f1f1f1;
        animation: load 3s linear forwards;
        margin-top: 10px;
        border-radius: 2px;
    }

    @keyframes load {
        from {
            width: 0;
        }

        to {
            width: 100%;
        }
    }

    .toast.toast-error .loading-bar {
        background-color: #dc3545;
    }
    </style>
</head>

<body>
    <div class="w-50 mx-auto mt-5 h-100 justify-content-center align-items-center">
        <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="login.php">Login</a>
            </li>
            <li class="nav-item" role="presentation" href="register.php"><a class="nav-link active"
                    href="register.php">Register</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active">
                <form action="register.php" method="POST">
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
                        <input type="password" id="registerPassword" name="password" class="form-control" required
                            pattern="(?=.*\d)(?=.*[A-Z]).{8,}"
                            title="Must contain at least one number and one uppercase letter, and at least 8 or more characters" />
                        <label class="form-label" for="registerPassword">Password</label>
                    </div>


                    <div class="info-icon">
                        <p class="text-secondary">Panduan Password<i class="bi bi-info-circle ml-3"></i></p>
                        <div class="tooltip-text">Password minimal 8 huruf: minimal mengandung 1 huruf kapital dan 1
                            angka.</div>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" data-mdb-button-init data-mdb-ripple-init
                        class="btn btn-primary btn-block mb-3">Sign in</button>

                    <div class="text-center">
                        <p>Already have an account? <a href="login.php">Login</a></p>
                    </div>
                </form>
            </div>
        </div>

    </div>
    </div>

    <div class="toast-container">
        <?php if ($success): ?>
        <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
            aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Akun berhasil didaftarkan! Sebentar lagi kamu akan diarahkan ke halaman login.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="loading-bar"></div>
        </div>
        <?php endif; ?>

        <?php if ($error): ?>
        <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive"
            aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Error: <?php echo htmlspecialchars($errorMessage); ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="loading-bar"></div>
        </div>
        <?php endif; ?>
    </div>

    <script src="./assets/admin/js/bootstrap.bundle.min.js"></script>
    <script>
    <?php if ($success || $error): ?>
    var toastEl = document.querySelector('.toast');
    var toast = new bootstrap.Toast(toastEl, {
        delay: 3000
    });
    toast.show();

    <?php if ($success): ?>
    // Redirect to sign-in page after 5 seconds when success
    setTimeout(function() {
        window.location.href = 'login.php';
    }, 5000);
    <?php endif; ?>
    <?php endif; ?>

    // Add client-side validation for password
    document.getElementById('registerPassword').addEventListener('input', function(event) {
        const password = event.target.value;
        const isValid = password.length >= 8 && /[A-Z]/.test(password) && /[0-9]/.test(password);

        if (isValid) {
            event.target.setCustomValidity('');
        } else {
            event.target.setCustomValidity(
                'Password must be at least 8 characters long, contain at least one uppercase letter and one number.'
            );
        }
    });
    </script>

</body>

</html>