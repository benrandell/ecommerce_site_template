<?php
// Start PHP session
session_start();

// Check if the product details are passed
if (isset($_POST['product_id']) && isset($_POST['description'])) {
    $productId = $_POST['product_id'];
    $description = $_POST['description'];

    // Add the selected product details to the session
    if (!isset($_SESSION['selected_items'])) {
        $_SESSION['selected_items'] = array();
    }

    // Create a unique key for the selected item (so you can actually update the count!)
    $itemKey = $productId . '_' . $description;

    // Check if the item is already selected
    if (isset($_SESSION['selected_items'][$itemKey])) {
        // Increment the count for the selected item
        $_SESSION['selected_items'][$itemKey]['count']++;
    } else {
        // Add the new item to the selected items with an initial count of 1
        $_SESSION['selected_items'][$itemKey] = array(
            'product_id' => $productId,
            'description' => $description,
            'count' => 1
        );
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('checkout_8.jpg');
            background-size: cover;
            background-repeat: repeat;
            background-attachment: fixed;
            background-position: top, center;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 20px 20px 100px 50px;
            padding: 20px;
            /* border: 1px solid #ccc; */
            border-radius: 4px;
            background-color: rgba(0,0,0,0);
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0);
        }

        .welcome {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            color: #fff;
            font-size: 48px;
            margin-bottom: 10px;
        }

        p {
            color: #fff;
            font-size: 16px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #fff
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #fff;
            font-size: 14px;
        }

        /* Style for the horizontal layout */
        .products-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin: 0 -10px;
        }

        /* Product Card Styles */
        .product-card {
            width: calc(40% - 20px);
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: rgba(0,0,0,0.5);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin: 20px;
            display: inline-block;
            vertical-align: top;
            transition: transform 0.3s ease;
            position: relative; /* for button positioning */
            color: #fff;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-card h2 {
            font-size: 24px;
            font-weight: bold;
            margin: 0 0 15px;
        }

        .product-card img {
            max-width: 100%;
            height: auto;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .product-card p {
            margin: 5px 0;
        }

        .product-card strong {
            font-weight: bold;
        }

        .product-info {
            flex: 1;
            margin-bottom: 10px;
        }

        .email-input {
            display: flex;
            flex: 1;
            flex-direction: column;
            align-items: stretch;
            margin-top: 20px;
        }

        .email-input label {
            font-size: 18px; /* Increase the font size for the email label */
            font-weight: bold; /* Add bold styling to the email label */
        }

        .email-input input[type="email"] {
            flex: 1;
            padding: 5px; /* Adjust the padding to give more space inside the input box */
            border: 1px solid #fff;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px; /* Increase the font size for the email input */
        }

        /* Style Buy Button */
        .remove-button {
            display: block;
            width: 100%;
            padding: 12px 0;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #ff4a4a;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        .remove-button:hover {
            background-color: rgba(0,0,0,0.5);
        }

        /* Style Buy Button */
        .confirm-button {
            display: block;
            width: 100%;
            padding: 12px 0;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #47a846;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        .confirm-button:hover {
            background-color: rgba(0,0,0,0.5);
        }

        .back-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #47a846;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body>
    <div class="container">
    <button class="back-button" onclick="window.location.href='user_shopping_page.php'">Go Back To Products Page</button>

        <div class="welcome">
            <h1>Welcome to your Cart Checkout</h1>
            <p>Click Confirm to Order!</p>
            <?php
                // Check if there are any selected items
                if (empty($_SESSION['selected_items'])) { ?>
                    <div style="display: flex; justify-content: center; align-items: center; height: 200px;">
                        <h1>No items selected yet!</h1>
                    </div>
                <?php
                } else {
                    require_once "connect.php"; ?>
                    <div class="products-container">
                        <?php $totalPrice = 0; ?>
                        <?php foreach ($_SESSION['selected_items'] as $item):
                            try {
                                $sql = "SELECT product_id, description, price, quantity FROM product_table p WHERE product_id = :product_id AND description = :description";
                                $stmt = $handle->prepare($sql);
                                $stmt->bindValue(':product_id', $item['product_id']);
                                $stmt->bindValue(':description', $item['description']);
                                $stmt->execute();
                                $result_product = $stmt->fetch(PDO::FETCH_ASSOC);
                                $priceWithoutDollar = str_replace('$', '', $result_product['price']);
                                $priceInt = floatval($priceWithoutDollar);
                                $totalItemPrice = $priceInt * $item['count'];
                                $totalPrice += $totalItemPrice;
                            } catch(PDOException $e) {
                                echo $sql . "\r\n" . $e->getMessage();
                            } ?>

                            <div class="product-card">
                                <h2><?php echo $result_product['description']; ?></h2>
                                <p><strong>Price:</strong> <?php echo $result_product['price']; ?></p>
                                <p><strong>Quantity:</strong> <?php echo $item['count']; ?></p>
                                <!-- Add a "Remove" button to remove the item from the cart -->
                                <button class="remove-button" onclick="removeProduct('<?php echo $item['product_id'] . "_" . $item['description']; ?>')">Remove</button> 
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <h2>Total Price: $<?php echo $totalPrice; ?></h2>
                    <!-- Add an input field for the user's email -->
                    <div class="email-input" style="margin-top: 20px;">
                        <label for="email">Enter your email:</label>
                        <input type="email" id="email" name="email" required>
                        <button class="confirm-button">Confirm Order</button>
                    </div>
                <?php 
                }?>
        </div>
    </div>

    <script>
        function removeProduct(itemKey) {
            // Send an AJAX request to remove_from_cart.php
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // If successful, reload the page to update the displayed items
                        window.location.reload();
                    } else {
                        // If there was an error, you can handle it here
                        console.error('Error removing product:', xhr.status, xhr.responseText);
                    }
                }
            };

            xhr.open('POST', 'remove_from_cart.php', true); // Keep the file name as "remove_from_cart.php" if you have created this file
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('itemKey=' + encodeURIComponent(itemKey));
        }

        document.querySelector('.confirm-button').addEventListener('click', function () {
            // Show the alert message
            alert('Your order has been confirmed! Thank you for your purchase.');
            // Clear the email input field after the order is confirmed
            document.getElementById('email').value = '';
            // The user can add new items to the existing ones.
            window.location.reload();
        });
    </script>
</body>

</html>
