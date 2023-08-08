<!DOCTYPE html>
<html>
<head>
    <a href="admin_products.php">Go to Products</a>
    <title>Table Display</title>
    <style>
        /* Table Styling */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Additional Styling */
        h3 {
            margin-top: 30px;
        }
    </style>
</head>
<body>
<?php
// Local Server information
$server = "127.0.0.1";
// $port = "3306";
$username = "root";
$password = "Brandy2253!";
$db = "BionicBuys";

#connect to database
try {
    $handle = new PDO("mysql:host=$server;dbname=$db", "$username", "$password");
    // error handling and reporting
    $handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    # grab product table
    try {
        $sql = "SELECT * FROM product_table";
        $stmt = $handle->prepare($sql);
        $stmt->execute();
        $result_product = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display product table
        if (!empty($result_product)) {
            echo '<h3>Product Table</h3>';
            echo '<table>';
            echo '<tr>';
            foreach ($result_product[0] as $key => $value) {
                echo '<th>' . $key . '</th>';
            }
            echo '</tr>';

            foreach ($result_product as $row) {
                echo '<tr>';
                foreach ($row as $value) {
                    echo '<td>' . $value . '</td>';
                }
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>No records found in the Product Table.</p>';
        }

    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    # grab supplier table
    try {
        $sql = "SELECT * FROM supplier_table";
        $stmt = $handle->prepare($sql);
        $stmt->execute();
        $result_supplier = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display supplier table
        if (!empty($result_supplier)) {
            echo '<h3>Supplier Table</h3>';
            echo '<table>';
            echo '<tr>';
            foreach ($result_supplier[0] as $key => $value) {
                echo '<th>' . $key . '</th>';
            }
            echo '</tr>';

            foreach ($result_supplier as $row) {
                echo '<tr>';
                foreach ($row as $value) {
                    echo '<td>' . $value . '</td>';
                }
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>No records found in the Supplier Table.</p>';
        }

    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

} catch (PDOException $e) {
    // there is an issue connecting to the database!
    $em = $e->getMessage();
    die("Oops, Something went wrong connecting to the database. $em");
}
?>
</body>
</html>
