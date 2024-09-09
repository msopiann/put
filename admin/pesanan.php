<?php

require_once __DIR__ . '/../guard/product.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id']) && isset($_POST['new_status'])) {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['new_status'];

    if (updateOrderStatus($orderId, $newStatus)) {
        $message = "Order status updated successfully.";
    } else {
        $error = "Failed to update order status.";
    }
}

// Fetch all orders
$orders = getAllOrders();


$title = "Admin Pesanan Page | Toko Puput";
ob_start();
?>

<div class="container">
    <h2 class="main-title">Management Pesanan</h2>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <?php if (isset($message)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $message; ?>
                </div>
                <?php endif; ?>

                <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
                <?php endif; ?>
                <div class="card-body">
                    <table id="datatable" class="table table-striped dt-responsive nowrap table-vertical"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Amount</th>
                                <th>Order Date</th>
                                <th>Billing Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>
                                    <a href="#"
                                        class="font-weight-bold"><?php echo htmlspecialchars($order['id']); ?></a>
                                </td>
                                <td><?php echo number_format($order['total_price']); ?></td>
                                <td><?php echo Date($order['created_at']); ?></td>
                                <td><?php echo htmlspecialchars($order['username']); ?></td>
                                <td><span
                                        class="badge bg-success-subtle text-success"><?php echo htmlspecialchars($order['status']); ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</div>

<?php $content = ob_get_clean();
include('../layouts/admin/layout.php'); ?>