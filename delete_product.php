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
        $stmt = $handle->prepare("DELETE FROM " . $data['tableName'] . " WHERE product_id = :productID AND product_name = :productName AND description = :description AND price = :price AND quantity = :quantity AND status = :status AND supplier_id = :supplierID");
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

