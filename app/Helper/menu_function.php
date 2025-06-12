    <?php
    // Fungsi untuk mengambil semua menu makanan
    function getAllFoodItems($conn)
    {
        // Log untuk debugging
        error_log("Menjalankan fungsi getAllFoodItems()");

        try {
            $query = "SELECT f.*, c.name AS category_name, c.slug AS category_slug, s.name AS seller_name
                    FROM food_items f
                    JOIN categories c ON f.category_id = c.id
                    JOIN sellers s ON f.seller_id = s.id
                    ORDER BY f.id DESC";

            error_log("Query: " . $query);

            // Eksekusi query dengan PDO
            $stmt = $conn->prepare($query);
            $stmt->execute();

            $items = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $items[] = $row;
            }

            error_log("Jumlah item yang ditemukan: " . count($items));

            return $items;
        } catch (Exception $e) {
            error_log("Exception in getAllFoodItems: " . $e->getMessage());
            return [];
        }
    }

    // Fungsi untuk mengambil detail menu makanan berdasarkan ID
    function getFoodItemById($conn, $id)
    {
        error_log("Mencari menu dengan ID: $id");

        try {
            $query = "SELECT f.*, c.name AS category_name, c.slug AS category_slug, s.name AS seller_name
                    FROM food_items f
                    JOIN categories c ON f.category_id = c.id
                    JOIN sellers s ON f.seller_id = s.id
                    WHERE f.id = :id";

            error_log("Query: $query");

            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result;
            }

            error_log("Tidak ada menu dengan ID: $id");
            return null;
        } catch (Exception $e) {
            error_log("Exception in getFoodItemById: " . $e->getMessage());
            return null;
        }
    }


    // Fungsi untuk mengambil semua kategori
    function getAllCategories($conn)
    {
        try {
            $query = "SELECT * FROM categories ORDER BY name";

            // Eksekusi query dengan PDO
            $stmt = $conn->prepare($query);
            $stmt->execute();

            $categories = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $categories[] = $row;
            }

            return $categories;
        } catch (Exception $e) {
            error_log("Exception in getAllCategories: " . $e->getMessage());
            return [];
        }
    }

    // Fungsi untuk membuat menu makanan baru
    function clean_input_menu($data)
    {
        if (is_string($data)) {
            $data = trim($data);         // Hanya trim jika string
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
        }
        return $data;
    }

    function createFoodItem($conn, $data)
    {
        // Tambahkan debugging
        error_log("Mencoba membuat menu baru: " . print_r($data, true));

        // Bersihkan input (tanpa parameter $conn karena pakai PDO)
        $name = clean_input_menu($data['name']);

        $category_id = (int)$data['category_id'];
        $price = (int)$data['price'];
        $stock = (int)$data['stock'];
        $description = clean_input_menu($data['description']);
        $image = clean_input_menu($data['image']);
        $seller_id = (int)$data['seller_id'];

        // Query menggunakan PDO prepared statement
        $query = "INSERT INTO food_items
                    (name, category_id, price, stock, description, image, seller_id, created_at)
                VALUES
                    (:name, :category_id, :price, :stock, :description, :image, :seller_id, NOW())";

        try {
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':stock', $stock);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':seller_id', $seller_id);

            if ($stmt->execute()) {
                $insert_id = $conn->lastInsertId();
                error_log("Menu berhasil dibuat dengan ID: " . $insert_id);
                return $insert_id;
            } else {
                error_log("Error saat membuat menu: " . print_r($stmt->errorInfo(), true));
                return false;
            }
        } catch (PDOException $e) {
            error_log("Exception saat membuat menu: " . $e->getMessage());
            return false;
        }
    }


    function updateFoodItem($conn, $id, $data)
    {
        // Pastikan ID adalah integer
        $id = (int)$id;

        // Ambil data yang diperlukan
        $name = clean_input_menu($data['name']);
        $category_id = (int)$data['category_id'];  // Menambahkan category_id
        $price = (int)$data['price'];  // Menambahkan price
        $stock = (int)$data['stock'];  // Menambahkan stock
        $description = clean_input_menu($data['description']);
        $image = clean_input_menu($data['image']);

        // Query untuk memperbarui menu makanan
        $query = "UPDATE food_items
              SET name = :name,
                  category_id = :category_id,
                  price = :price,
                  stock = :stock,
                  description = :description,
                  image = :image,
                  updated_at = NOW()
              WHERE id = :id";

        try {
            // Menyiapkan statement untuk PDO
            $stmt = $conn->prepare($query);

            // Binding parameter
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            $stmt->bindParam(':price', $price, PDO::PARAM_INT);
            $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            // Eksekusi query
            if ($stmt->execute()) {
                return true;  // Berhasil diperbarui
            } else {
                return false; // Gagal memperbarui
            }
        } catch (PDOException $e) {
            error_log("Error dalam updateFoodItem: " . $e->getMessage());
            return false;  // Menangani error jika query gagal
        }
    }

    // Fungsi untuk menghapus menu makanan
    function deleteFoodItem($conn, $id)
    {
        $id = (int)$id;
        $query = "DELETE FROM food_items WHERE id = $id";

        try {
            $stmt = $conn->prepare($query);
            if ($stmt->execute()) {
                return true; // Mengembalikan true jika berhasil
            } else {
                return false; // Mengembalikan false jika gagal
            }
        } catch (Exception $e) {
            error_log("Error dalam deleteFoodItem: " . $e->getMessage());
            return false;
        }
    }

    // Fungsi untuk memperbarui stok makanan
    function updateFoodStock($conn, $id, $stock)
    {
        $id = (int)$id;
        $stock = (int)$stock;

        $query = "UPDATE food_items SET stock = :stock, updated_at = NOW() WHERE id = :id";

        try {
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':stock', $stock, PDO::PARAM_INT);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute(); // Mengembalikan true jika berhasil
        } catch (Exception $e) {
            error_log("Error dalam updateFoodStock: " . $e->getMessage());
            return false;
        }
    }
    ?>
