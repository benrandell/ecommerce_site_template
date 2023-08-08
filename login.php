<?php
// Define the credentials for admin and guest users
$adminUsername = 'Ben123';
$adminPassword = 'Brandy2253!';

// Initialize variables for error handling
$usernameError = $passwordError = $loginError = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the entered username and password
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Validate the entered username and password
    if ($username === $adminUsername && $password === $adminPassword) {
        // Admin login successful, redirect to admin page
        header("Location: admin_products.php");
        exit();
    } else {
        // Regular user login successful, redirect to user page
        header("Location: user_shopping_page.php");
        exit();
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
            background-image: url('tech_drop.jpg');
            background-size: cover;
            background-repeat: repeat;
            background-attachment: fixed;
            background-position: top, center;
            color: #333;
        }

        .container {
            max-width: 400px;
            margin: 20px auto 100px;
            padding: 20px;
            /* border: 1px solid #ccc; */
            border-radius: 4px;
            background-color: rgba(0,0,0,0);
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .welcome {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            color: #fff;
            font-size: 24px;
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

        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #fff;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
            background-color: rgba(0,0,0,0);
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome">
            <h1>Welcome to Bionic Buys</h1>
            <p>Please login and enjoy your shopping</p>
        </div>
        <form method="POST" action="">
            <?php if ($loginError) : ?>
                <div class="error"><?php echo $loginError; ?></div>
            <?php endif; ?>

            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
