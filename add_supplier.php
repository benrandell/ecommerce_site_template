<?php
require_once "connect.php";

// Retrieve the data sent from JavaScript
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['tableName']) && $data['tableName'] === "supplier_table") {
    try {
        // replacing any NULL Values to "" to aviod warnings
        $supplierID = isset($data['supplierID']) ? $data['supplierID'] : '';
        $supplierName = isset($data['supplierName']) ? $data['supplierName'] : '';
        $address = isset($data['address']) ? $data['address'] : '';
        $phone = isset($data['phone']) ? $data['phone'] : '';
        $email = isset($data['email']) ? $data['email'] : '';

        // prepared statements 
        $stmt = $handle->prepare("INSERT INTO " . $data['tableName'] . "(supplier_id, supplier_name, address, phone, email) VALUES (:supplierID, :supplierName, :address, :phone, :email)");
        $stmt->bindParam(':supplierID', $supplierID);
        $stmt->bindParam(':supplierName', $supplierName);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Return a success response
        echo "successful deletion";
    } catch(PDOException $e) {
        // Return an error response
        echo "Deletion failed: " . $e->getMessage();
    }
}
?>

