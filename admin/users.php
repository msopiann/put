<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    // Redirect to login page if not an admin
    header("Location: ../login-admin.php");
    exit;
}

require_once __DIR__ . '/../guard/user.php';

$nonAdminUsers  = getNonAdminUsers(10);

$title = "Admin User Page | Toko Puput";
ob_start();
?>

<div class="container">
    <h2 class="main-title">Management User</h2>
    <table>
        <thead>
            <tr>
                <th>Nama User</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($nonAdminUsers as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $content = ob_get_clean();
include('../layouts/admin/layout.php'); ?>