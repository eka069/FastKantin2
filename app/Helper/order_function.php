<?php
// Fungsi untuk mengambil semua pesanan
function getAllOrders($conn)
{
    $query = "SELECT o.*, f.name AS food_name, f.image, f.price
              FROM orders o
              JOIN food_items f ON o.food_id = f.id
              ORDER BY o.created_at DESC";

    $stmt = $conn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fungsi untuk mengambil detail pesanan berdasarkan ID
function getOrderById($conn, $id)
{
    $id = (int)$id;
    $query = "SELECT o.*, f.name AS food_name, f.price, f.image
            FROM orders o
            JOIN food_items f ON o.food_id = f.id
            WHERE o.id = $id";
    $result = $conn->query($query);
    $result = $result->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result;
    }

    return null;
}

// Fungsi untuk mengambil pesanan berdasarkan user_id
function getUserOrders($conn, $user_id)
{
    $user_id = (int)$user_id;
    $query = "SELECT o.*, f.name AS food_name, f.price, f.image
            FROM orders o
            JOIN food_items f ON o.food_id = f.id
            WHERE o.user_id = $user_id
            ORDER BY o.created_at DESC";
    $result = $conn->query($query);

    $orders = $result->fetchAll(PDO::FETCH_ASSOC);

    return $orders;
}

// Fungsi untuk membuat pesanan baru
function createOrder($conn, $data)
{
    $query = "INSERT INTO orders (food_id, customer_name, quantity, pickup_time, notes, status, user_id, payment_method, created_at)
              VALUES (:food_id, :customer_name, :quantity, :pickup_time, :notes, :status, :user_id, :payment_method, NOW())";

    $stmt = $conn->prepare($query);
    $success = $stmt->execute([
        ':food_id' => $data['food_id'],
        ':customer_name' => $data['customer_name'],
        ':quantity' => $data['quantity'],
        ':pickup_time' => $data['pickup_time'],
        ':notes' => $data['notes'],
        ':status' => $data['status'],
        ':user_id' => $data['user_id'],
        ':payment_method' => $data['payment_method']
    ]);

    if ($success) {
        return $conn->lastInsertId();
    }

    return false;
}


// Fungsi untuk memperbarui status pesanan
function updateOrderStatus($conn, $id, $status)
{
    $id = (int)$id;
    $status = clean_input_menu($status);

    $query = "UPDATE orders SET status = '$status', updated_at = NOW() WHERE id = $id";

    $stmt = $conn->prepare($query);
    $success = $stmt->execute([
        ':status' => $status,
        ':id' => $id
    ]);

    if ($success) {
        return $conn->lastInsertId();
    }
    return false;
}

// Fungsi untuk mendapatkan label status
if (!function_exists('getStatusLabel')) {
    function getStatusLabel($status)
    {
        switch ($status) {
            case 'pending':
                return 'Menunggu';
            case 'processing':
                return 'Diproses';
            case 'completed':
                return 'Selesai';
            default:
                return 'Unknown';
        }
    }
}

// Fungsi untuk mendapatkan kelas badge status
if (!function_exists('getStatusBadgeClass')) {
    function getStatusBadgeClass($status)
    {
        switch ($status) {
            case 'pending':
                return 'bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full';
            case 'processing':
                return 'bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full';
            case 'completed':
                return 'bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full';
            default:
                return 'bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full';
        }
    }
}
