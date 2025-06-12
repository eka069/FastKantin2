<?php
/**
* Fungsi untuk menangani upload gambar
*
* @param array $file File yang diupload ($_FILES['image'])
* @param string $upload_dir Direktori tujuan upload
* @return array Status upload dan path gambar
*/
function uploadImage($file, $upload_dir = 'assets/images/menu/') {
   $result = [
       'success' => false,
       'message' => '',
       'path' => ''
   ];

   // Tambahkan debugging
   error_log("Mencoba upload gambar: " . print_r($file, true));

   // Cek apakah ada file yang diupload
   if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
       $error_message = "Tidak ada file yang diupload atau terjadi kesalahan.";
       if (isset($file['error'])) {
           $error_message .= " Error code: " . $file['error'];
       }
       $result['message'] = $error_message;
       error_log($error_message);
       return $result;
   }

   // Validasi tipe file
   $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
   if (!in_array($file['type'], $allowed_types)) {
       $result['message'] = 'Format gambar tidak didukung. Gunakan JPG, PNG, atau GIF.';
       error_log("Format gambar tidak didukung: " . $file['type']);
       return $result;
   }

   // Validasi ukuran file (max 2MB)
   $max_size = 2 * 1024 * 1024;
   if ($file['size'] > $max_size) {
       $result['message'] = 'Ukuran gambar terlalu besar. Maksimal 2MB.';
       error_log("Ukuran gambar terlalu besar: " . $file['size']);
       return $result;
   }

   // Buat direktori jika belum ada
   if (!file_exists($upload_dir)) {
       error_log("Membuat direktori: " . $upload_dir);
       if (!mkdir($upload_dir, 0777, true)) {
           $result['message'] = 'Gagal membuat direktori upload.';
           error_log("Gagal membuat direktori: " . $upload_dir);
           return $result;
       }
   }

   // Generate nama file unik
   $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9\.]/', '_', basename($file['name']));
   $target_file = $upload_dir . $filename;

   error_log("Target file: " . $target_file);

   // Upload file
   if (move_uploaded_file($file['tmp_name'], $target_file)) {
       $result['success'] = true;
       $result['path'] = $target_file;
       error_log("File berhasil diupload ke: " . $target_file);
   } else {
       $result['message'] = 'Gagal mengupload gambar. Silakan coba lagi.';
       error_log("Gagal mengupload file ke: " . $target_file);
   }

   return $result;
}

/**
* Fungsi untuk mendapatkan URL placeholder jika gambar tidak tersedia
*
* @param int $width Lebar gambar
* @param int $height Tinggi gambar
* @return string URL placeholder
*/
function getPlaceholderUrl($width = 300, $height = 300) {
   return "assets/images/placeholder/create_placeholder.php?width={$width}&height={$height}";
}
?>
