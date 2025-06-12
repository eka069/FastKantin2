<?php
// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

// Pastikan path relatif benar
$basePath = __DIR__; // Mendapatkan path absolut dari direktori saat ini

// Koneksi ke database
require_once $basePath . '/config/database.php';
require_once $basePath . '/functions/menu_functions.php';
require_once $basePath . '/functions/cart_functions.php';
require_once $basePath . '/functions/user_functions.php';
require_once $basePath . '/functions/order_functions.php';

global $connection;
// Cek apakah keranjang kosong
$cart_items = getCartItems($connection);
if (empty($cart_items)) {
    // Redirect ke halaman keranjang jika kosong
    header('Location: keranjang.php?error=empty');
    exit;
}

// Ambil total keranjang
$cart_total = getCartTotal($connection);

// Cek apakah user sudah login
$user = null;
if (function_exists('isLoggedIn') && isLoggedIn()) {
    $user = getCurrentUser();
}

// Proses form pembayaran
$success = false;
$error = '';
$order_id = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input
    $customer_name = trim($_POST['customer_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $pickup_time = trim($_POST['pickup_time'] ?? '');
    $payment_method = trim($_POST['payment_method'] ?? '');
    $notes = trim($_POST['notes'] ?? '');
}

if (empty($customer_name)) {
    $error = 'Nama pemesan harus diisi';
} elseif (empty($pickup_time)) {
    $error = 'Waktu pengambilan harus dipilih';
} elseif (empty($payment_method)) {
    $error = 'Metode pembayaran harus dipilih';
} else

    // Mulai transaksi
    try {
        $connection->beginTransaction(); // 

        $user_id = $user ? $user['id'] : null;

        // proses insert order...

        $connection->commit(); // 
    } catch (Exception $e) {
        $connection->rollBack(); // 
        error_log("Gagal menyimpan pesanan: " . $e->getMessage());
    }

// Buat pesanan untuk setiap item di keranjang
foreach ($cart_items as $item) {
    // Cek stok
    if ($item['quantity'] > $item['stock']) {
        throw new Exception("Stok {$item['name']} tidak mencukupi");
    }

    // Buat pesanan
    $customer_name = $_POST['customer_name'] ?? '';
    $pickup_time = $_POST['pickup_time'] ?? '';
    $notes = $_POST['notes'] ?? '';
    $payment_method = $_POST['payment_method'] ?? '';
    $user_id = $_SESSION['user']['id'] ?? null;

    $order_data = [
        'food_id' => $item['id'],
        'customer_name' => $customer_name ?? $_SESSION['user']['name'],
        'quantity' => $item['quantity'],
        'pickup_time' => $pickup_time,
        'notes' => $notes,
        'status' => 'pending',
        'user_id' => $user_id,
        'payment_method' => $payment_method
    ];

    $order_id = createOrder($connection, $order_data);

    if (!$order_id) {
        throw new Exception("Gagal membuat pesanan untuk {$item['name']}");
    }

    // Update stok
    $new_stock = $item['stock'] - $item['quantity'];
    if (!updateFoodStock($connection, $item['id'], $new_stock)) {
        throw new Exception("Gagal memperbarui stok untuk {$item['name']}");
    }
}

// Kosongkan keranjang
clearCart();

// Commit transaksi
try {
    $connection->beginTransaction();

    // Lakukan proses seperti createOrder(), updateStock(), dll

    $connection->commit();
    $success = true;
} catch (Exception $e) {
    $connection->rollBack();
    $error = $e->getMessage();
}


// Header
include $basePath . '/includes/header.php';
?>

<!-- Konten Utama -->
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Pembayaran</h1>

    <?php if ($success): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <p class="font-bold">Pesanan Berhasil!</p>
            <p class="mt-2">Pesanan Anda telah berhasil dibuat. Silakan ambil pesanan Anda pada waktu yang telah ditentukan.</p>
            <p class="mt-4">
                <a href="index.html" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition-colors inline-block">
                    Kembali ke Menu
                </a>
                <?php if ($user): ?>
                    <a href="riwayat-pesanan.php" class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-md transition-colors inline-block ml-2">
                        Lihat Riwayat Pesanan
                    </a>
                <?php endif; ?>
            </p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Pembayaran -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg border p-6">
                    <h2 class="text-xl font-semibold mb-4">Informasi Pesanan</h2>

                    <?php if ($error): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <p><?= htmlspecialchars($error) ?></p>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="" class="space-y-6">
                        <div class="space-y-2">
                            <label for="customer_name" class="block font-medium">Nama Pemesan</label>
                            <input type="text" id="customer_name" name="customer_name"
                                class="w-full p-2 border rounded-md" required
                                value="<?= htmlspecialchars($_POST['customer_name'] ?? ($user ? $user['name'] : '')) ?>">
                        </div>

                        <div class="space-y-2">
                            <label for="phone" class="block font-medium">Nomor Telepon</label>
                            <input type="tel" id="phone" name="phone"
                                class="w-full p-2 border rounded-md"
                                value="<?= htmlspecialchars($_POST['phone'] ?? ($user ? $user['phone'] : '')) ?>">
                        </div>

                        <div class="space-y-2">
                            <label for="pickup_time" class="block font-medium">Waktu Pengambilan</label>
                            <select id="pickup_time" name="pickup_time" class="w-full p-2 border rounded-md" required>
                                <option value="">Pilih waktu pengambilan</option>
                                <?php
                                // Generate time slots (every 30 minutes from 8 AM to 5 PM)
                                for ($hour = 8; $hour <= 17; $hour++) {
                                    foreach ([0, 30] as $minute) {
                                        if ($hour === 17 && $minute === 30) continue; // Skip 17:30
                                        $formattedHour = str_pad($hour, 2, '0', STR_PAD_LEFT);
                                        $formattedMinute = str_pad($minute, 2, '0', STR_PAD_LEFT);
                                        $timeSlot = "$formattedHour:$formattedMinute";
                                        $selected = ($_POST['pickup_time'] ?? '') === $timeSlot ? 'selected' : '';
                                        echo "<option value=\"$timeSlot\" $selected>$timeSlot WIB</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="payment_method" class="block font-medium">Metode Pembayaran</label>
                            <select id="payment_method" name="payment_method" class="w-full p-2 border rounded-md" required>
                                <option value="">Pilih metode pembayaran</option>
                                <option value="cash" <?= ($_POST['payment_method'] ?? '') === 'cash' ? 'selected' : '' ?>>Tunai (Bayar di Tempat)</option>
                                <option value="transfer" <?= ($_POST['payment_method'] ?? '') === 'transfer' ? 'selected' : '' ?>>Transfer Bank</option>
                                <option value="qris" <?= ($_POST['payment_method'] ?? '') === 'qris' ? 'selected' : '' ?>>QRIS</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="notes" class="block font-medium">Catatan (Opsional)</label>
                            <textarea id="notes" name="notes" rows="3"
                                class="w-full p-2 border rounded-md"><?= htmlspecialchars($_POST['notes'] ?? '') ?></textarea>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-md transition-colors">
                                Konfirmasi Pesanan
                            </button>
                            <a href="keranjang.php" class="w-full block text-center mt-2 text-blue-600 hover:underline">
                                Kembali ke Keranjang
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Ringkasan Pesanan -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg border p-4 sticky top-4">
                    <h2 class="font-semibold mb-4">Ringkasan Pesanan</h2>

                    <div class="space-y-4 mb-4">
                        <?php foreach ($cart_items as $item): ?>
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-medium"><?= htmlspecialchars($item['name']) ?></p>
                                    <p class="text-sm text-gray-600"><?= $item['quantity'] ?> x Rp <?= number_format($item['price'], 0, ',', '.') ?></p>
                                </div>
                                <p class="font-medium">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <hr class="my-4">

                    <div class="flex justify-between font-bold">
                        <span>Total</span>
                        <span>Rp <?= number_format($cart_total, 0, ',', '.') ?></span>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
// Footer
include $basePath . '/includes/footer.html';
?>