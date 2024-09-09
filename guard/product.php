<?php
require_once __DIR__ . '/../config/connection.php';

// Function untuk menarik data produk dari database
function getProducts($limit = 10)
{
    global $conn;
    $sql = "SELECT * FROM products LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function untuk membuat data produk baru
function createProduct($name, $slug, $description, $price, $stock, $image_url)
{
    global $conn;
    $sql = "INSERT INTO products (id, name, slug, description, price, stock, image_url) VALUES (uuid_v4_baru(), ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdis", $name, $slug, $description, $price, $stock, $image_url);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Function untuk memperbarui data produk dari database
function updateProduct($id, $name, $description, $price, $stock, $image_url)
{
    global $conn;
    $slug = generateSlug($name);
    $sql = "UPDATE products SET name = ?, slug = ?, description = ?, price = ?, stock = ?, image_url = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdiss", $name, $slug, $description, $price, $stock, $image_url, $id);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Function untuk menghapus data produk dari database
function deleteProduct($id)
{
    global $conn;
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Function untuk menarik data order dari database
function updateOrderStatus($orderId, $newStatus)
{
    global $conn;
    $allowedStatuses = ['pending', 'processing', 'delivered', 'shipped', 'completed', 'cancelled'];

    if (!in_array($newStatus, $allowedStatuses)) {
        return false;
    }

    $oldStatusQuery = "SELECT status FROM orders WHERE id = ?";
    $stmt = $conn->prepare($oldStatusQuery);
    $stmt->bind_param("s", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    $oldStatus = $result->fetch_assoc()['status'];

    $sql = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $newStatus, $orderId);

    if ($stmt->execute()) {
        if ($newStatus === 'completed' && $oldStatus !== 'completed') {
            $updateSoldCountSql = "
                UPDATE products p
                JOIN order_items oi ON p.id = oi.product_id
                SET p.sold_count = p.sold_count + oi.quantity
                WHERE oi.order_id = ?";
            $stmt = $conn->prepare($updateSoldCountSql);
            $stmt->bind_param("s", $orderId);
            $stmt->execute();
        }
        return true;
    } else {
        return false;
    }
}

// Function untuk menarik data order dari database
function getAllOrders($limit = 50, $offset = 0)
{
    global $conn;
    $sql = "SELECT o.id, o.user_id, u.username, u.email, o.total_price, o.status, o.created_at
            FROM orders o
            JOIN users u ON o.user_id = u.id
            ORDER BY o.created_at DESC
            LIMIT ? OFFSET ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

function countSales()
{
    global $conn;

    $sql = "SELECT COUNT(*) as sales_count FROM orders 
            WHERE created_at AND status = 'completed'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['sales_count'];
}

function getNewestProducts($limit = 10)
{
    global $conn;
    $sql = "SELECT * FROM products ORDER BY created_at DESC LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}


function getTopSalesProducts($limit = 5)
{
    global $conn;

    $sql = "SELECT 
                p.id, 
                p.name, 
                p.price,    
                p.image_url, 
                SUM(oi.quantity) as total_sold,
                SUM(oi.quantity * oi.price) as total_revenue
            FROM 
                products p
            JOIN 
                order_items oi ON p.id = oi.product_id
            JOIN 
                orders o ON oi.order_id = o.id
            WHERE 
                o.status = 'completed'
            GROUP BY 
                p.id
            ORDER BY 
                total_sold DESC
            LIMIT ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    $topProducts = [];
    while ($row = $result->fetch_assoc()) {
        $topProducts[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'price' => $row['price'],
            'image_url' => $row['image_url'],
            'total_sold' => $row['total_sold'],
            'total_revenue' => $row['total_revenue']
        ];
    }

    return $topProducts;
}