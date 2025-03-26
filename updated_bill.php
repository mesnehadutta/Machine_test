<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = $_POST['customer_name'];
    $product_names = $_POST['product_name'];
    $unit_prices = $_POST['unit_price'];
    $quantities = $_POST['quantity'];

    $bill_number = rand(1000, 9999);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Updated Bill</title>
</head>
<body>
    <h2>Final Updated Bill</h2>
    <p><strong>Bill Number:</strong> <?php echo $bill_number; ?></p>
    <p><strong>Customer Name:</strong> <?php echo htmlspecialchars($customer_name); ?></p>

    <table border="1">
        <tr>
            <th>Product Name</th>
            <th>Unit Price</th>
            <th>Quantity</th>
            <th>Total Price</th>
        </tr>

        <?php
        $grand_total = 0;
        for ($i = 0; $i < count($product_names); $i++) {
            $unit_price = floatval($unit_prices[$i]); // Ensure float values for decimal support
            $quantity = intval($quantities[$i]); // Ensure integer values for quantity
            $total_price = $unit_price * $quantity;
            $grand_total += $total_price;
        ?>
            <tr>
                <td><?php echo htmlspecialchars($product_names[$i]); ?></td>
                <td><?php echo number_format($unit_price, 2, '.', ''); ?></td>
                <td><?php echo $quantity; ?></td>
                <td><?php echo number_format($total_price, 2, '.', ''); ?></td>
            </tr>
        <?php } ?>
    </table>

    <h3>Grand Total: ₹<?php echo number_format($grand_total, 2, '.', ''); ?></h3>
    
    <a href="index.php">Create New Bill</a>
</body>
</html>
<?php } else {
    echo "<p>No data received. <a href='index.php'>Go back</a></p>";
} ?>
