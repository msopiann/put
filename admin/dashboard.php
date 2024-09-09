<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    // Redirect to login page if not an admin
    header("Location: ../sign-in-admin.php");
    exit;
}

require_once __DIR__ . '/../guard/user.php';
require_once __DIR__ . '/../guard/product.php';

$totalOrders = countSales();
$totalCustomers = countNonAdminUsers();
$newestProducts = getNewestProducts(100);
$topProducts = getTopSalesProducts(5);


$title = "Admin Dashboard Page | Toko Puput";
ob_start();
?>
<div class="container">
    <h2 class="main-title">Dashboard</h2>
    <div class="row stat-cards">
        <div class="col-md-6 col-xl-3">
            <article class="stat-cards-item">
                <div class="stat-cards-icon warning">
                    <i data-feather="file" aria-hidden="true"></i>
                </div>
                <div class="stat-cards-info">
                    <p class="stat-cards-info__num"><?php echo number_format($totalOrders); ?></p>
                    <p class="stat-cards-info__title">Total order</p>
                </div>
            </article>
        </div>
        <div class="col-md-6 col-xl-3">
            <article class="stat-cards-item">
                <div class="stat-cards-icon success">
                    <i data-feather="feather" aria-hidden="true"></i>
                </div>
                <div class="stat-cards-info">
                    <p class="stat-cards-info__num"><?php echo number_format($totalCustomers); ?></p>
                    <p class="stat-cards-info__title">Total users</p>
                </div>
            </article>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-9">
            <div class="users-table table-wrapper">
                <table class="posts-table">
                    <thead>
                        <tr class="users-table-info">
                            <th>
                                <label class="users-table__checkbox ms-20">
                                    <input type="checkbox" class="check-all">New Post Products
                                </label>
                            </th>
                            <th>Product Name</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($newestProducts as $item): ?>
                        <tr>
                            <td>
                                <label class="users-table__checkbox">
                                    <input type="checkbox" class="check">
                                    <div class="categories-table-img">
                                        <picture>
                                            <source srcset="<?php echo htmlspecialchars($item['image_url']); ?>"
                                                type="image/JPEG">
                                            <img src="<?php echo htmlspecialchars($item['image_url']); ?>">
                                        </picture>
                                    </div>
                                </label>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($item['name']); ?>
                            </td>
                            <td><span class="badge-pending"><?php echo number_format($item['stock']); ?></span></td>
                            <td><?php echo number_format($item['price']); ?></td>
                            <td>
                                <span class="p-relative">
                                    <button class="dropdown-btn transparent-btn" type="button" title="More info">
                                        <div class="sr-only">More info</div>
                                        <i data-feather="more-horizontal" aria-hidden="true"></i>
                                    </button>
                                    <ul class="users-item-dropdown dropdown">
                                        <li><a href="product/update.php?id=<?php echo $item['id']; ?>">Edit</a></li>
                                        <li><a href="product/hapus.php?id=<?php echo $item['id']; ?>">Trash</a></li>
                                    </ul>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-3">
            <article class="white-block">
                <div class="top-cat-title">
                    <h3>Top Product</h3>
                </div>
                <ul class="top-cat-list">
                    <?php foreach ($topProducts as $item): ?>
                    <li>
                        <a href="##">
                            <div class="top-cat-list__title">
                                <?php echo htmlspecialchars($item['name']); ?><span
                                    class="ml-3"><?php echo number_format($item['total_sold']); ?></span>
                            </div>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </article>
        </div>
    </div>
</div>

<?php $content = ob_get_clean();
include('../layouts/admin/layout.php'); ?>