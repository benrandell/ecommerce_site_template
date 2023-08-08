<?php
// Start PHP session
session_start();

// Check if the itemKey is provided in the POST request
if (isset($_POST['itemKey'])) {
    $itemKey = $_POST['itemKey'];

    // Remove the selected item from the session
    if (isset($_SESSION['selected_items'][$itemKey])) {
        unset($_SESSION['selected_items'][$itemKey]);
    }

    // Respond with a success message
    echo 'Product removed successfully.';
} else {
    // Respond with an error message if the itemKey is missing
    http_response_code(400);
    echo 'Error: Missing itemKey.';
}
?>