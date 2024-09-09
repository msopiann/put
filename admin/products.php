<?php
require_once __DIR__ . '/../guard/product.php';

$products = getProducts(100);

$title = "Admin Product Page | Toko Puput";
ob_start();
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="../assets/admin/css/style.css">

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2 class="main-title">Products</h2>
        <a href="product/tambah.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Product</a>
    </div>

    <div class="grid row row-gap-3">
        <?php foreach ($products as $item): ?>
        <div class="col-6 col-md-4">
            <div class="card h-fit">
                <a href="#">
                    <img src="<?php echo htmlspecialchars($item['image_url']); ?>" class="card-img-top"
                        alt="<?php echo htmlspecialchars($item['name']); ?>" />
                </a>
                <div class="card-body">
                    <div class="clearfix mb-3">
                        <span
                            class="float-start badge rounded-pill bg-success"><?php echo number_format($item['price']); ?></span>
                    </div>
                    <h5 class="card-title">
                        <a target="_blank" href="#"><?php echo htmlspecialchars($item['name']); ?></a>
                    </h5>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</div>

<?php
$content = ob_get_clean();
include("../layouts/admin/layout.php")
?>