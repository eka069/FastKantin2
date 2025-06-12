<?php
// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Perbaikan Database Fast Kantin</h1>";

// Koneksi ke database
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'fastkantin';

// Coba koneksi ke database
echo "<h2>Memeriksa Koneksi Database</h2>";
$conn = mysqli_connect($db_host, $db_user, $db_pass);

if (!$conn) {
    echo "<p style='color:red'>Koneksi ke MySQL gagal: " . mysqli_connect_error() . "</p>";
    exit;
}

echo "<p style='color:green'>Koneksi ke MySQL berhasil!</p>";

// Cek apakah database ada
$db_exists = mysqli_select_db($conn, $db_name);

if (!$db_exists) {
    echo "<p>Database '$db_name' tidak ditemukan. Mencoba membuat database...</p>";
    
    // Buat database
    $sql = "CREATE DATABASE IF NOT EXISTS $db_name";
    if (mysqli_query($conn, $sql)) {
        echo "<p style='color:green'>Database '$db_name' berhasil dibuat!</p>";
        
        // Pilih database
        mysqli_select_db($conn, $db_name);
    } else {
        echo "<p style='color:red'>Gagal membuat database: " . mysqli_error($conn) . "</p>";
        exit;
    }
} else {
    echo "<p style='color:green'>Database '$db_name' ditemukan!</p>";
}

// Baca file SQL
echo "<h2>Menjalankan Script SQL</h2>";

$sql_file = 'database.sql';
if (file_exists($sql_file)) {
    $sql = file_get_contents($sql_file);
    
    // Pisahkan query
    $queries = explode(';', $sql);
    
    $success = true;
    foreach ($queries as $query) {
        $query = trim($query);
        if (empty($query)) continue;
        
        if (mysqli_query($conn, $query)) {
            echo "<p>Query berhasil dijalankan: " . substr($query, 0, 50) . "...</p>";
        } else {
            echo "<p style='color:red'>Error menjalankan query: " . mysqli_error($conn) . "</p>";
            echo "<p>Query: " . $query . "</p>";
            $success = false;
        }
    }
    
    if ($success) {
        echo "<p style='color:green'>Semua query berhasil dijalankan!</p>";
    }
} else {
    echo "<p style='color:red'>File SQL tidak ditemukan: $sql_file</p>";
}

// Cek tabel yang ada
echo "<h2>Tabel dalam Database</h2>";
$result = mysqli_query($conn, "SHOW TABLES");

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        echo "<ul>";
        while ($row = mysqli_fetch_row($result)) {
            echo "<li>" . $row[0] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Tidak ada tabel dalam database.</p>";
    }
} else {
    echo "<p style='color:red'>Error: " . mysqli_error($conn) . "</p>";
}

// Cek data dalam tabel
echo "<h2>Data dalam Tabel</h2>";

$tables = ['categories', 'sellers', 'food_items', 'orders'];

foreach ($tables as $table) {
    echo "<h3>Tabel: $table</h3>";
    
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM $table");
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo "<p>Jumlah data: " . $row['count'] . "</p>";
        
        if ($row['count'] > 0) {
            $data_result = mysqli_query($conn, "SELECT * FROM $table LIMIT 5");
            
            if ($data_result && mysqli_num_rows($data_result) > 0) {
                echo "<table border='1' cellpadding='5'>";
                
                // Header tabel
                echo "<tr>";
                $fields = mysqli_fetch_fields($data_result);
                foreach ($fields as $field) {
                    echo "<th>" . $field->name . "</th>";
                }
                echo "</tr>";
                
                // Data
                while ($data_row = mysqli_fetch_assoc($data_result)) {
                    echo "<tr>";
                    foreach ($data_row as $value) {
                        echo "<td>" . $value . "</td>";
                    }
                    echo "</tr>";
                }
                
                echo "</table>";
            }
        }
    } else {
        echo "<p style='color:red'>Error: " . mysqli_error($conn) . "</p>";
    }
}

// Tutup koneksi
mysqli_close($conn);

// Tambahkan link untuk kembali ke beranda
echo "<p><a href='index.html' style='display:inline-block;margin-top:20px;padding:10px 15px;background-color:#3b82f6;color:white;text-decoration:none;border-radius:5px;'>Kembali ke Beranda</a></p>";
?>
