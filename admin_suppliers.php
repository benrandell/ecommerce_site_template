 <!-- ADMIN can edit the SQL database for Updates (UPDATE, ADD and DELETE) - updates are sent to user view  -->

<!--  Connect to SQL Database -->
<?php 
    require_once "connect.php";
    require_once "delete_supplier.php";
    require_once "add_supplier.php";
    require_once "update_supplier.php";

    // grab table data to display
    try {
        $sql = "SELECT * FROM supplier_table";
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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .header {
            background-color: #4CAF50;
            color: #fff;
            padding: 20px;
            display: flex;
            text-align: center;
            align-items: center;
            justify-content: space-between;
            border-radius: 10px 10px 0 0;
        }

        h1 {
            margin: 0;
            font-size: 24px;
            font-weight: normal;
            font-style: italic;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        h3 {
            margin: 0;
            font-size: 18px;
            font-weight: normal;
            /* font-style: italic; */
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #ffffff;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px; 
        }

        table, th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        th {
            background-color: #f9f9f9;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .search-bar {
            margin-top: 10px;
            display: flex;
            justify-content: flex-end;
        }

        .search-bar input[type="text"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .action-button {
            padding: 6px 12px;
            font-size: 14px;
            font-weight: bold;
            margin-right: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            /* adding padding */
            padding-top: 8px;
            padding-bottom: 8px;
            padding-left: 12px;
            padding-right: 12px;
        }

        .action-button.edit {
            background-color: #2196F3;
        }

        .action-button.delete {
            background-color: #F44336;
        }

        .add-form {
            margin-top: 20px;
        }

        .add-form h2 {
            margin-bottom: 10px;
        }

        .add-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .add-form input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .add-form input[type="submit"] {
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .add-form input[type="submit"]:hover {
            background-color: #45a049;
        }

        .action-buttons {
            display: flex;
        }

        .action-buttons .action-button {
            margin-right: 10px;
        }

        .action-button.edit, .action-button.delete {
            margin-top: 10px;
        }

        .action-button.edit {
            margin-right: 10px;
        }

        /* CSS to style the input container */
        .input-container {
            width: 100%;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .input-container input {
            width: 100%;
            box-sizing: border-box;
        }

        .redirect-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .redirect-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bionic Buys - Admin Page</h1>
        <a href="admin_products.php" class="redirect-button">Go to Products Table</a>
        <a href="login.php" class="redirect-button">Logout</a>
        <a href="demo_sql.php">See MySQL Database</a>
    </div>

    <div class="container">
        <h3>Suppliers Table</h3>
        <div class="search-bar">
            <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search...">
        </div>

        <table id="dataTable">
            <tr>
                <th>Supplier ID</th>
                <th>Supplier Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($resultSet as $row): ?>
                <tr>
                    <td><?php echo $row['supplier_id']; ?></td>
                    <td><?php echo $row['supplier_name']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-button edit">Edit</button>
                            <button class="action-button delete">Delete</button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="add-form">
            <h2>Add New Supplier</h2>
            <form id="addSupplierForm">
                <label for="supplierID">Supplier ID:</label>
                <input type="text" id="supplierID" name="supplierID" required>

                <label for="supplierName">Supplier Name:</label>
                <input type="text" id="supplierName" name="supplierName" required>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>

                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required>

                <label for="email">Email:</label>
                <input type="text" id="email" name="email" required>

                <input type="submit" value="Add Supplier">
            </form>
        </div>
    </div>

    <script>
        // Edit button click event
        const editButtons = document.querySelectorAll(".action-button.edit");
        editButtons.forEach(button => {
            button.addEventListener("click", (event) => {
                const row = event.target.closest("tr");
                const cells = row.getElementsByTagName("td");

                // Access the data from each cell in the row
                const supplierID = cells[0].textContent;
                const supplierName = cells[1].textContent;
                const address = cells[2].textContent;
                const phone = cells[3].textContent;
                const email = cells[4].textContent;

                // Store the original values in data attributes
                row.dataset.originalSupplierID = supplierID;
                row.dataset.originalSupplierName = supplierName;
                row.dataset.originalAddress = address;
                row.dataset.originalPhone = phone;
                row.dataset.originalEmail = email;

                // Create input fields for editing
                const inputFields = `
                <td>
                    <div class="input-container">
                    <input type="text" class="input-supplier-id" value="${supplierID}">
                    </div>
                </td>
                <td>
                    <div class="input-container">
                    <input type="text" class="input-supplier-name" value="${supplierName}">
                    </div>
                </td>
                <td>
                    <div class="input-container">
                    <input type="text" class="input-address" value="${address}">
                    </div>
                </td>
                <td>
                    <div class="input-container">
                    <input type="text" class="input-phone" value="${phone}">
                    </div>
                </td>
                <td>
                    <div class="input-container">
                    <input type="text" class="input-email" value="${email}">
                    </div>
                </td>
                <td>
                    <div class="action-buttons">
                    <button class="action-button save">Save</button>
                    </div>
                </td>
                `;

                // Replace the row with the input fields
                row.innerHTML = inputFields;
            });
        });

        // Save button click event (attached to document)
        document.addEventListener("click", (event) => {
            const saveButton = event.target.closest(".action-button.save");
            if (saveButton) {
                const saveButton = event.target;
                const row = saveButton.closest("tr");

                // Retrieve the updated input values
                const updatedSupplierID = row.querySelector(".input-supplier-id").value;
                const updatedSupplierName = row.querySelector(".input-supplier-name").value;
                const updatedAddress = row.querySelector(".input-address").value;
                const updatedPhone = row.querySelector(".input-phone").value;
                const updatedEmail = row.querySelector(".input-email").value;

                // Retrieve the original values from data attributes
                const supplierID = row.dataset.originalSupplierID;
                const supplierName = row.dataset.originalSupplierName;
                const address = row.dataset.originalAddress;
                const phone = row.dataset.originalPhone;
                const email = row.dataset.originalEmail;
                const tableName = "supplier_table";

                // Create an object with the data
                const data = {
                    tableName: tableName,
                    supplierID: supplierID,
                    supplierName: supplierName,
                    address: address,
                    phone: phone,
                    email: email,
                    UsupplierID: updatedSupplierID,
                    UsupplierName: updatedSupplierName,
                    Uaddress: updatedAddress,
                    Uphone: updatedPhone,
                    Uemail: updatedEmail,
                };
                
                //debug console 
                console.log(data)

                // Send the data to the PHP file using AJAX
                fetch("update_supplier.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.text())
                .then(result => {
                    console.log(result);
                    location.reload();
                })
                .catch(error => {
                    console.error("Error:", error);
                    // Handle any error that occurred during the AJAX request
                });
            }
            else {
                console.log("Save button not found.")
            }
        });

        // Delete button click event
        const deleteButtons = document.querySelectorAll(".action-button.delete");
        deleteButtons.forEach(button => {
            button.addEventListener("click", (event) => {
                const row = event.target.closest("tr");
                const cells = row.getElementsByTagName("td");
                
                // Access the data from each cell in the row
                const supplierID = cells[0].textContent;
                const supplierName = cells[1].textContent;
                const address = cells[2].textContent;
                const phone = cells[3].textContent;
                const email = cells[4].textContent;
                const tableName = "supplier_table";

                // Run prepared Sql statment to delete this row from the sql table
                // Create an object with the data
                const data = {
                    tableName: tableName,
                    supplierID: supplierID,
                    supplierName: supplierName,
                    address: address,
                    phone: phone,
                    email: email,
                };

                // Send the data to the PHP file using AJAX
                fetch("delete_supplier.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.text())
                .then(result => {
                    //row.remove();
                    console.log(result);
                    location.reload();
                })
                .catch(error => {
                    console.error("Error:", error);
                    // Handle any error that occurred during the AJAX request
                });
            });
        });

        // Add event listener to the form submission
        document.getElementById("addSupplierForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent form submission

            // Retrieve input values
            const supplierID = document.getElementById("supplierID").value;
            const supplierName = document.getElementById("supplierName").value;
            const address = document.getElementById("address").value;
            const phone = document.getElementById("phone").value;
            const email = document.getElementById("email").value;
            const tableName = "supplier_table";

            // Just need to run add_row.php and reload page!
            // Create an object with the data
            const data = {
                tableName: tableName,
                supplierID: supplierID,
                supplierName: supplierName,
                address: address,
                phone: phone,
                email: email,
            };

            // Send the data to the PHP file using AJAX
            fetch("add_supplier.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(response => response.text())
            .then(result => {
            //row.remove();
                console.log(result);
                location.reload();
            })
            .catch(error => {
                console.error("Error:", error);
                // Handle any error that occurred during the AJAX request
            });
        });

        // search bar function
        function searchTable() {
            const input = document.getElementById("searchInput");
            const filter = input.value.toUpperCase();
            const table = document.getElementById("dataTable");
            const rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) {
                let found = false;
                const cells = rows[i].getElementsByTagName("td");
                for (let j = 0; j < cells.length; j++) {
                    const cell = cells[j];
                    if (cell) {
                        const cellText = cell.textContent || cell.innerText;
                        if (cellText.toUpperCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }
                if (found) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>