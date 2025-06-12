<?php
/**
* Cart Functions
*
* Functions to handle shopping cart operations
*/

// Initialize cart in session if it doesn't exist
function initCart() {
   if (!isset($_SESSION['cart'])) {
       $_SESSION['cart'] = [];
   }
}

// Add item to cart
function addToCart($item_id, $quantity = 1) {
   // Initialize cart
   initCart();

   // Check if item already exists in cart
   if (isset($_SESSION['cart'][$item_id])) {
       // Update quantity
       $_SESSION['cart'][$item_id] += $quantity;
   } else {
       // Add new item
       $_SESSION['cart'][$item_id] = $quantity;
   }

   return true;
}

// Remove item from cart
function removeFromCart($item_id) {
   // Initialize cart
   initCart();

   // Check if item exists in cart
   if (isset($_SESSION['cart'][$item_id])) {
       // Remove item
       unset($_SESSION['cart'][$item_id]);
       return true;
   }

   return false;
}

// Update item quantity in cart
function updateCartItemQuantity($item_id, $quantity) {
   // Initialize cart
   initCart();

   // Check if item exists in cart
   if (isset($_SESSION['cart'][$item_id])) {
       // Update quantity
       if ($quantity > 0) {
           $_SESSION['cart'][$item_id] = $quantity;
       } else {
           // Remove item if quantity is 0 or negative
           unset($_SESSION['cart'][$item_id]);
       }
       return true;
   }

   return false;
}

    // Buat placeholder :id0, :id1, dst
    function getCartItems($conn) {
        $cart_items = [];

        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            return $cart_items;
        }

        $item_ids = array_keys($_SESSION['cart']);

        if (empty($item_ids)) {
            return $cart_items;
        }

        // Buat placeholder :id0, :id1, dst
        $placeholders = [];
        foreach ($item_ids as $index => $id) {
            $placeholders[] = ":id$index";
        }

        $item_ids_str = implode(',', $placeholders);

        $query = "SELECT f.*, c.name AS category_name, s.name AS seller_name
                  FROM food_items f
                  JOIN categories c ON f.category_id = c.id
                  JOIN sellers s ON f.seller_id = s.id
                  WHERE f.id IN ($item_ids_str)";

        try {
            $stmt = $conn->prepare($query);

            // Bind setiap item ID
            foreach ($item_ids as $index => $id) {
                $stmt->bindValue(":id$index", $id, PDO::PARAM_INT);
            }

            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $row) {
                $row['quantity'] = $_SESSION['cart'][$row['id']];
                $row['subtotal'] = $row['price'] * $row['quantity'];
                $cart_items[] = $row;
            }

        } catch (Exception $e) {
            error_log("Error dalam getCartItems: " . $e->getMessage());
        }

        return $cart_items;
    }


// Get cart total
function getCartTotal($conn) {
   $cart_items = getCartItems($conn);
   $total = 0;

   foreach ($cart_items as $item) {
       $total += $item['subtotal'];
   }

   return $total;
}

// Get cart count
function getCartCount() {
   // Initialize cart
   initCart();

   $count = 0;

   foreach ($_SESSION['cart'] as $quantity) {
       $count += $quantity;
   }

   return $count;
}

// Clear cart
function clearCart() {
   $_SESSION['cart'] = [];
   return true;
}
?>
