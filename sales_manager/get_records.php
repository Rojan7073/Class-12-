<?php

//DATABASE CONNECTION 
$host   = "127.0.0.1";
$user   = "root";
$pass   = "";
$dbname = "sales_purchase_db";
$port   = 3307;

$conn = mysqli_connect($host, $user, $pass, $dbname, $port);
header('Content-Type: application/json');
// get dates fom record.html
$from = $_GET["from"];
$to   = $_GET["to"];

if (empty($from) || empty($to)) {
    echo json_encode(["success" => false, "message" => "Please provide both dates."]);
    exit;
}

// Escape the dates for safety
$from = mysqli_real_escape_string($conn, $from);
$to   = mysqli_real_escape_string($conn, $to);

// ── STEP 4: FETCH SALES IN DATE RANGE ────────────────────────
$all_records = [];

$sql_sales = "SELECT 'sale' AS type,
                     sale_date AS date,
                     customer_name AS customer_vendor,
                     product_name,
                     quantity AS units,
                     total_price
              FROM sales
              WHERE sale_date BETWEEN '$from' AND '$to'
              ORDER BY sale_date DESC";

$result_sales = mysqli_query($conn, $sql_sales);

if ($result_sales) {
    while ($row = mysqli_fetch_assoc($result_sales)) {
        $all_records[] = $row;
    }
}

// ── STEP 5: FETCH PURCHASES IN DATE RANGE ────────────────────
$sql_purchases = "SELECT 'purchase' AS type,
                         purchase_date AS date,
                         vendor_name AS customer_vendor,
                         product_name,
                         purchased_units AS units,
                         total_price
                  FROM purchases
                  WHERE purchase_date BETWEEN '$from' AND '$to'
                  ORDER BY purchase_date DESC";

$result_purchases = mysqli_query($conn, $sql_purchases);

if ($result_purchases) {
    while ($row = mysqli_fetch_assoc($result_purchases)) {
        $all_records[] = $row;
    }
}

// ── STEP 6: SORT ALL RECORDS BY DATE (newest first) ──────────
usort($all_records, function($a, $b) {
    return strcmp($b["date"], $a["date"]);
});

// ── STEP 7: SEND BACK THE DATA AS JSON ───────────────────────
echo json_encode(["success" => true, "data" => $all_records]);

// ── STEP 8: CLOSE CONNECTION ──────────────────────────────────
mysqli_close($conn);
?>