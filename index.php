<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Bill</title>
    <script>
        function addRow() {
            let table = document.getElementById("products");
            let row = table.insertRow();
            row.innerHTML = `
                <td><input type="text" name="product_name[]" required></td>
                <td><input type="number" name="unit_price[]" step="0.01" required oninput="updateTotal(this)"></td>
                <td><input type="number" name="quantity[]" required oninput="updateTotal(this)"></td>
                <td class="total">0.00</td>
                <td><button type="button" onclick="removeRow(this)">Remove</button></td>
            `;
        }

        function removeRow(button) {
            let table = document.getElementById("products");
            if (table.rows.length > 2) { // Ensures first row remains fixed
                button.parentElement.parentElement.remove();
                calculateGrandTotal();
            } else {
                alert("The first product is required and cannot be removed!");
            }
        }

        function updateTotal(input) {
            let row = input.parentElement.parentElement;
            let price = parseFloat(row.querySelector('[name="unit_price[]"]').value) || 0;
            let qty = parseFloat(row.querySelector('[name="quantity[]"]').value) || 0;
            let total = price * qty;
            row.querySelector(".total").textContent = total.toFixed(2); // Show 2 decimal places
            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            let totals = document.querySelectorAll(".total");
            let grandTotal = 0;
            totals.forEach(total => {
                grandTotal += parseFloat(total.textContent) || 0;
            });
            document.getElementById("grandTotal").textContent = grandTotal.toFixed(2); // Show 2 decimal places
        }
    </script>
</head>
<body>
    <h2>Customer Bill</h2>
    <form action="bill.php" method="post">
        <label>Customer Name: <input type="text" name="customer_name" required></label>
        <h3>Products</h3>
        <table border="1" id="products">
            <tr>
                <th>Name</th> <th>Price</th> <th>Qty</th> <th>Total</th> <th>Action</th>
            </tr>
            <tr>
                <td><input type="text" name="product_name[]" required></td>
                <td><input type="number" name="unit_price[]" step="0.01" required oninput="updateTotal(this)"></td>
                <td><input type="number" name="quantity[]" required oninput="updateTotal(this)"></td>
                <td class="total">0.00</td>
                <td><button type="button" disabled>Required</button></td> <!-- Disable remove button for first row -->
            </tr>
        </table>
        <button type="button" onclick="addRow()">Add Product</button>
        <h3>Grand Total: <span id="grandTotal">0.00</span></h3>
        <button type="submit">Generate Bill</button>
    </form>
</body>
</html>
