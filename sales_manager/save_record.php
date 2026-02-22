<?php
// ============================================================
//  save_record.php
//  Saves sales or purchase record to MySQL database
// ============================================================

// ── STEP 1: DATABASE CONNECTION ──────────────────────────────
$host   = "127.0.0.1";
$user   = "root";
$pass   = "";
$dbname = "sales_purchase_db";
$port   = 3307;

$conn = mysqli_connect($host, $user, $pass, $dbname, $port);

// ── STEP 2: CHECK CONNECTION ──────────────────────────────────
if (!$conn) {
    echo json_encode([
        "success" => false,
        "message" => "Connection failed: " . mysqli_connect_error()
    ]);
    exit;
}

header('Content-Type: application/json');

// ── STEP 3: CHECK IF TYPE IS SET ─────────────────────────────
if (!isset($_POST["type"])) {
    echo json_encode(["success" => false, "message" => "No data received."]);
    exit;
}

$type = $_POST["type"];

// ════════════════════════════════════════════════
//  IF IT IS A SALE
// ════════════════════════════════════════════════
if ($type == "sale") {

    // Get data from the form
    $customer_name = mysqli_real_escape_string($conn, $_POST["customer_name"]);
    $product_name  = mysqli_real_escape_string($conn, $_POST["product_name"]);
    $quantity      = mysqli_real_escape_string($conn, $_POST["quantity"]);
    $cost          = mysqli_real_escape_string($conn, $_POST["cost"]);
    $selling_price = mysqli_real_escape_string($conn, $_POST["selling_price"]);
    $total_price   = mysqli_real_escape_string($conn, $_POST["total_price"]);
    $sale_date     = mysqli_real_escape_string($conn, $_POST["sale_date"]);

    // Check if fields are empty
    if (empty($customer_name) || empty($product_name) || empty($sale_date)) {
        echo json_encode(["success" => false, "message" => "Please fill all required fields."]);
        exit;
    }

    // SQL query to insert into sales table
    $sql = "INSERT INTO sales (customer_name, product_name, quantity, cost, selling_price, total_price, sale_date)
            VALUES ('$customer_name', '$product_name', '$quantity', '$cost', '$selling_price', '$total_price', '$sale_date')";

    // Run the query
    if (mysqli_query($conn, $sql)) {
        echo json_encode(["success" => true, "message" => "Sale saved successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . mysqli_error($conn)]);
    }

// ════════════════════════════════════════════════
//  IF IT IS A PURCHASE
// ════════════════════════════════════════════════
} elseif ($type == "purchase") {

    // Get data from the form
    $vendor_name     = mysqli_real_escape_string($conn, $_POST["vendor_name"]);
    $product_name    = mysqli_real_escape_string($conn, $_POST["product_name"]);
    $per_unit_price  = mysqli_real_escape_string($conn, $_POST["per_unit_price"]);
    $purchased_units = mysqli_real_escape_string($conn, $_POST["purchased_units"]);
    $total_price     = mysqli_real_escape_string($conn, $_POST["total_price"]);
    $purchase_date   = mysqli_real_escape_string($conn, $_POST["purchase_date"]);

    // Check if fields are empty
    if (empty($vendor_name) || empty($product_name) || empty($purchase_date)) {
        echo json_encode(["success" => false, "message" => "Please fill all required fields."]);
        exit;
    }

    // SQL query to insert into purchases table
    $sql = "INSERT INTO purchases (vendor_name, product_name, per_unit_price, purchased_units, total_price, purchase_date)
            VALUES ('$vendor_name', '$product_name', '$per_unit_price', '$purchased_units', '$total_price', '$purchase_date')";

    // Run the query
    if (mysqli_query($conn, $sql)) {
        echo json_encode(["success" => true, "message" => "Purchase saved successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . mysqli_error($conn)]);
    }

} else {
    echo json_encode(["success" => false, "message" => "Unknown type."]);
}

// ── CLOSE CONNECTION ──────────────────────────────────────────
mysqli_close($conn);
?>