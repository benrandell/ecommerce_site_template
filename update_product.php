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
        $UproductID = isset($data['UproductID']) ? $data['UproductID'] : '';
        $UproductName = isset($data['UproductName']) ? $data['UproductName'] : '';
        $Udescription = isset($data['Udescription']) ? $data['Udescription'] : '';
        $Uprice = isset($data['Uprice']) ? $data['Uprice'] : '';
        $Uquantity = isset($data['Uquantity']) ? $data['Uquantity'] : '';
        $Ustatus = isset($data['Ustatus']) ? $data['Ustatus'] : '';
        $UsupplierID = isset($data['UsupplierID']) ? $data['UsupplierID'] : '';

        // prepared statements 
        $stmt = $handle->prepare("UPDATE " . $data['tableName'] . " SET product_id = :UproductID, product_name = :UproductName, description = :Udescription, price = :Uprice, quantity = :Uquantity, status = :Ustatus, supplier_id = :UsupplierID WHERE product_id = :productID AND product_name = :productName AND description = :description AND price = :price AND quantity = :quantity AND status = :status AND supplier_id = :supplierID");
        $stmt->bindParam(':productID', $productID);
        $stmt->bindParam(':productName', $productName);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':supplierID', $supplierID);
        $stmt->bindParam(':UproductID', $UproductID);
        $stmt->bindParam(':UproductName', $UproductName);
        $stmt->bindParam(':Udescription', $Udescription);
        $stmt->bindParam(':Uprice', $Uprice);
        $stmt->bindParam(':Uquantity', $Uquantity);
        $stmt->bindParam(':Ustatus', $Ustatus);
        $stmt->bindParam(':UsupplierID', $UsupplierID);
        $stmt->execute();

        // Return a success response
        echo "successful update";
    } catch(PDOException $e) {
        // Return an error response
        echo "Deletion failed: " . $e->getMessage();
    }
}
?>

