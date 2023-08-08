<?php
require_once "connect.php";

// Retrieve the data sent from JavaScript
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['tableName']) && $data['tableName'] === "product_table") {
    try {
        // replacing any NULL Values to "" to aviod warnings
        $productID = isset($data['productID']) ? $data['productID'] : '';
        $productName = isset($data['productName']) ? $data['productName'] : '';
        $description = isset($data['description']) ? $data['description'] : '';
        $price = isset($data['price']) ? $data['price'] : '';
        $quantity = isset($data['quantity']) ? $data['quantity'] : '';
        $status = isset($data['status']) ? $data['status'] : '';
        $supplierID = isset($data['supplierID']) ? $data['supplierID'] : '';

        // prepared statements 
        $stmt = $handle->prepare("INSERT INTO " . $data['tableName'] . "(product_id, product_name, description, price, quantity, status, supplier_id) VALUES (:productID, :productName, :description, :price, :quantity, :status, :supplierID)");
        $stmt->bindParam(':productID', $productID);
        $stmt->bindParam(':productName', $productName);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':supplierID', $supplierID);
        $stmt->execute();

        // Return a success response
        echo "successful deletion";
    } catch(PDOException $e) {
        // Return an error response
        echo "Deletion failed: " . $e->getMessage();
    }
}
?>

