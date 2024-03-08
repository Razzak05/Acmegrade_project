<?php
$addr = $_POST['address'];
$total = $_POST['total'];

include "authguard.php";
include "../shared/connection.php";

// Insert into orders table
$stmt = $conn->prepare("INSERT INTO orders (username, userid, address, total_amount) VALUES (?, ?, ?, ?)");
$stmt->bind_param("siss", $_SESSION['username'], $_SESSION['userid'], $addr, $total);
$stmt->execute();
$orderid = $conn->insert_id;
$stmt->close();

// Select data from cart and product tables
$sql_result = mysqli_query($conn, "SELECT * FROM cart JOIN product ON cart.pid=product.pid WHERE userid=$_SESSION[userid]");

// Insert into order_details table
while ($dbrow = mysqli_fetch_assoc($sql_result)) {
    $insert_status = mysqli_query($conn, "INSERT INTO order_details (orderid, pid, name, price, details, impath, owner) VALUES ('$orderid', '$dbrow[pid]', '$dbrow[name]', '$dbrow[price]', '$dbrow[details]', '$dbrow[impath]', '$dbrow[owner]')");
    if (!$insert_status) {
        echo mysqli_error($conn);
    }
}
?>
