<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = htmlspecialchars($_POST['customer_name']);
    $product_names = $_POST['product_name'];
    $unit_prices = $_POST['unit_price'];
    $quantities = $_POST['quantity'];

    $bill_number = rand(1000, 9999);
    $grand_total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Receipt</title>
    <script>
        function updateTotal(input) {
            let row = input.closest('tr');
            let price = parseFloat(row.querySelector('[name="unit_price[]"]').value) || 0;
            let qty = parseInt(row.querySelector('[name="quantity[]"]').value) || 0;
            let total = price * qty;
            row.querySelector(".total_price").textContent = total.toFixed(2);
            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            let totalElements = document.querySelectorAll(".total_price");
            let grandTotal = 0;
            totalElements.forEach(el => {
                grandTotal += parseFloat(el.textContent) || 0;
            });
            document.getElementById("grandTotal").textContent = grandTotal.toFixed(2);
        }
    </script>
</head>
<body>
    <h2>Bill Receipt</h2>
    <p><strong>Bill Number:</strong> <?php echo $bill_number; ?></p>
    <p><strong>Customer Name:</strong> <?php echo $customer_name; ?></p>

    <form action="updated_bill.php" method="post">
        <input type="hidden" name="customer_name" value="<?php echo $customer_name; ?>">
        <table border="1">
            <tr>
                <th>Product Name</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
            </tr>

            <?php
            for ($i = 0; $i < count($product_names); $i++) {
                $unit_price = floatval($unit_prices[$i]);
                $quantity = intval($quantities[$i]);
                $total_price = $unit_price * $quantity;
                $grand_total += $total_price;
            ?>
                <tr>
                    <td><input type="text" name="product_name[]" value="<?php echo htmlspecialchars($product_names[$i]); ?>" required></td>
                    <td><input type="number" step="0.01" name="unit_price[]" value="<?php echo number_format($unit_price, 2, '.', ''); ?>" required oninput="updateTotal(this)"></td>
                    <td><input type="number" name="quantity[]" value="<?php echo $quantity; ?>" required oninput="updateTotal(this)"></td>
                    <td class="total_price"><?php echo number_format($total_price, 2, '.', ''); ?></td>
                </tr>
            <?php } ?>
        </table>

        <h3>Grand Total: ₹<span id="grandTotal"><?php echo number_format($grand_total, 2, '.', ''); ?></span></h3>
        <button type="submit">Edit Bill</button>
    </form>
    <a href="index.php">Back</a>
</body>
</html>
<?php } ?>
