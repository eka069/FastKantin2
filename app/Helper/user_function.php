<?php
// Fungsi untuk membersihkan input
function clean_input($data)
{
    return htmlspecialchars(strip_tags(trim((string)$data)));
}
/**
 * User Functions
 *
 * Functions to handle user operations
 */

// Initialize user session
function initUserSession()
{
    if (!isset($_SESSION['user'])) {
        $_SESSION['user'] = null;
    }
}

// Check if user is logged in
function isLoggedIn($role = ['user'])
{
    initUserSession();
    return isset($_SESSION['user']) && $_SESSION['user'] !== null && in_array($_SESSION['user']['role'], $role);
}

// Get current user
function getCurrentUser()
{
    initUserSession();
    return $_SESSION['user'] ?? null;
}

// Check if email already exists
function registerUser($conn, $data)
{
    $name = clean_input($data['name']);
    $email = clean_input($data['email']);
    $phone = clean_input($data['phone']);
    $password = clean_input($data['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $table = ($data['role'] == 'user') ? 'users' : 'sellers';

    // ✅ Cek apakah email sudah ada
    $checkQuery = "SELECT id FROM {$table} WHERE email = :email";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->execute([':email' => $email]);
    if ($checkStmt->fetch(PDO::FETCH_ASSOC)) {
        return [
            'success' => false,
            'message' => 'Email sudah terdaftar'
        ];
    }

    // Lanjut insert jika email belum ada
    $query = "INSERT INTO {$table} (name, email, phone, password, created_at)
                  VALUES (:name, :email, :phone, :password, NOW())";

    $stmt = $conn->prepare($query);
    $success = $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':phone' => $phone,
        ':password' => $hashed_password
    ]);

    if ($success) {
        $user_id = $conn->lastInsertId();
        $user = getUserById($conn, $user_id, $table);
        $user['role'] = $data['role'];
        $_SESSION['user'] = $user;

        return [
            'success' => true,
            'message' => 'Registrasi berhasil',
            'user' => $user
        ];
    }

    return [
        'success' => false,
        'message' => 'Registrasi gagal'
    ];
}

// Get user by email
function loginUser($conn, $email, $password, $role)
{
    $email = clean_input($email);
    $table = ($role == 'user') ? 'users' : 'sellers';

    $stmt = $conn->prepare("SELECT * FROM {$table} WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $verify = password_verify($password, $user['password']);

    if ($user && $verify) {
        $user['role'] = $role;
        return [
            'success' => true,
            'user' => $user
        ];

        exit;
    }

    return [
        'success' => false,
        'message' => 'Email atau password salah'
    ];
}

// Logout user
function logoutUser()
{
    // Unset user session
    $_SESSION['user'] = null;

    return [
        'success' => true,
        'message' => 'Logout berhasil'
    ];
}

// Get user by ID
function getUserById($conn, $id, $table)
{
    $id = (int)$id;

    $query = "SELECT id, name, email, phone, created_at FROM {$table} WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->execute([':id' => $id]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user ? $user : null;
}


// Update user profile
function updateUserProfile($conn, $id, $data)
{
    $id = (int)$id;
    $name = clean_input($data['name']);
    $phone = clean_input($data['phone'] ?? '');

    $role = $data['role'];
    $table = ($role == 'user') ? 'users' : 'sellers';

    $stmt = $conn->prepare("UPDATE {$table} SET name = :name, phone = :phone, updated_at = NOW() WHERE id = :id");
    $success = $stmt->execute([
        ':name' => $name,
        ':phone' => $phone,
        ':id' => $id
    ]);

    if ($success) {
        // Get updated user data
        $user = getUserById($conn, $id, $table);
        $user['role'] = $role;
        $_SESSION['user'] = $user; // Update session

        return [
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'user' => $user
        ];
    }
}

// Change user password
function changeUserPassword($conn, $data, $current_password, $new_password)
{
    $id = (int)$data['id'] ?? 0;
    $role = $data['role'];
    $table = ($role == 'user') ? 'users' : 'sellers';

    // Get user with password
    $query = "SELECT password FROM {$table} WHERE id = $id";
    $result = $conn->query($query);
    $result = $result->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        return [
            'success' => false,
            'message' => 'User tidak ditemukan'
        ];
    }

    $user = $result;

    // Verify current password
    if (!password_verify($current_password, $user['password'])) {
        return [
            'success' => false,
            'message' => 'Password saat ini salah'
        ];
    }

    // Hash new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password
    $query = "UPDATE {$table} SET password = '$hashed_password', updated_at = NOW() WHERE id = $id";
    $stmt = $conn->prepare($query);


    if ($stmt->execute()) {
        return [
            'success' => true,
            'message' => 'Password berhasil diubah'
        ];
    }

    return [
        'success' => false,
        'message' => 'Gagal mengubah password'
    ];
}
