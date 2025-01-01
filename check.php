<?php
session_start();
// include('config.php');
// Cart initialize karna agar na ho toh
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Item ko cart mein add karne ka function
function addToCart($productId, $productName, $productPrice, $quantity) {
    // Cart mein existing item check karna
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $productId) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }
    
    // Agar item pehle se nahi hai, toh naya add karein
    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $productId,
            'name' => $productName,
            'price' => $productPrice,
            'quantity' => $quantity
        ];
    }
}

// Example: Add item to cart
if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    $quantity = $_POST['quantity'];
    
    addToCart($productId, $productName, $productPrice, $quantity);
}

// Cart ko display karna
function displayCart() {
    if (empty($_SESSION['cart'])) {
        echo "<p>Your cart is empty!</p>";
    } else {
        echo "<h2>Your Cart</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>";
        foreach ($_SESSION['cart'] as $item) {
            $total = $item['price'] * $item['quantity'];
            echo "<tr>
                    <td>{$item['id']}</td>
                    <td>{$item['name']}</td>
                    <td>{$item['price']}</td>
                    <td>{$item['quantity']}</td>
                    <td>{$total}</td>
                </tr>";
        }
        echo "</table>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add to Cart Example</title>
</head>
<body>
    <h1>Add Product to Cart</h1>
    <form method="POST">
        <label>Product ID:</label>
        <input type="text" name="product_id" required><br>

        <label>Product Name:</label>
        <input type="text" name="product_name" required><br>

        <label>Price:</label>
        <input type="number" step="0.01" name="product_price" required><br>

        <label>Quantity:</label>
        <input type="number" name="quantity" min="1" value="1" required><br>

        <button type="submit" name="add_to_cart">Add to Cart</button>
    </form>

    <hr>
    <?php
    // Cart display karna
    displayCart();
    ?>
</body>
</html>
