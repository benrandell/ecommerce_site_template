<!--  Connect to SQL Database -->
<?php 
    require_once "connect.php";

    // grab table data to display
    try {
        $sql = "SELECT p.product_id, p.description, p.price, p.quantity, s.supplier_name FROM supplier_table s JOIN product_table p ON s.supplier_id = p.supplier_id";
        $stmt = $handle->prepare($sql);
        $stmt->execute();
        $resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo $sql . "\r\n" . $e->getMessage();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bionic Buys - Products</title>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
            background-image: url('wavey.jpg');
            background-size: cover, cover;
            background-repeat: repeat;
            background-attachment: fixed;
            background-position: top, center;
        }

        /* Header Styles */
        .header {
            background-color: rgba(0,0,0,0);
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-radius: 10px 10px 0 0;
            position: relative; /* for button positioning */
        }

        .header h1 {
            margin: 0;
            font-size: 200px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .header a {
            text-decoration: none;
            color: #fff;
            font-size: 24px;
            padding: 10px 20px;
            border-radius: 4px;
            background-color: rgba(0,0,0,0.5);
            transition: background-color 0.3s ease;
        }

        .header a:hover {
            background-color: #47a846;
        }

        /* Align the "Logout" and "Checkout" buttons to the right side */
        .header a:nth-child(2) {
            margin-right: 10px;
        }

        /* Product Card Styles */
        .product-card {
            width: 300px;
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

        /* Style Buy Button */
        .buy-button {
            display: block;
            width: 100%;
            padding: 12px 0;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        .buy-button:hover {
            background-color: rgba(0,0,0,0.5);
        }

        .main-container h1 {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 30px;
            text-align: center;
            /* text-decoration: underline; */
        }

        .main-container h2 {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 30px;
            text-align: center;
        }

        /* Search Bar Styles */
        .search-bar {
            display: flex;
            width: 21%;
            justify-content: flex-start; /* Align items to the left side */
            align-items: center;
            margin-bottom: 20px;
            margin-left: 20px;
        }

        #searchInput {
            flex: 1;
            padding: 11px 0;
            border: 1px solid #ccc;
            border-radius: 4px 0 0 4px;
            font-size: 16px;
        }

        #searchInput:focus {
            outline: none;
        }

        #searchInput::placeholder {
            color: #999;
        }

        button {
            width: 100px;
            padding: 12px 0;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bionic Buys.</h1>
        <a href="user_checkout.php">Checkout</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="main-container">
        <h1>Products for Sale</h1>
        <!-- Add the search bar -->
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search for products..." oninput="searchProducts()">
            <button onclick="searchProducts()">Search</button>
        </div>

        <?php foreach ($resultSet as $row): ?>
            <!-- Display each product as a card -->
            <div class="product-card">
                <h2><?php echo $row['description']; ?></h2>
                <!-- Replace the following line with an actual product image -->
                <!-- <img src="product_image_placeholder.jpg" alt="Product Image"> -->
                <p><strong>Price:</strong> <?php echo $row['price']; ?></p>
                <p><strong>Inventory Left:</strong> <?php echo intval($row['quantity']); ?></p>
                <p><strong>Supplier:</strong> <?php echo $row['supplier_name']; ?></p>
                <!-- Add a "Buy Now" or "Add to Cart" button here -->
               <button class="buy-button" onclick="addToCart(<?php echo $row['product_id']; ?>, '<?php echo $row['description']; ?>')">Buy Now</button>
            </div>
        <?php endforeach; ?>
    </div>
    <script>
        function addToCart(productId, description) {
            // Send the selected product details to the server using AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'user_checkout.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    // Handle the response (if needed)
                }
            };
            xhr.send('product_id=' + productId + '&description=' + description);
        }

        function searchProducts() {
            const searchInput = document.getElementById('searchInput');
            const filter = searchInput.value.toUpperCase();
            const productCards = document.querySelectorAll('.product-card');

            for (const card of productCards) {
                const productName = card.querySelector('h2').textContent.toUpperCase();
                if (productName.includes(filter)) {
                    card.style.display = 'inline-block';
                } else {
                    card.style.display = 'none';
                }
            }
        }

    </script>
</body>
</html>

