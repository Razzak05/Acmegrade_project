<?php
if(isset($_GET['cartid'])) {
    $cartid = $_GET['cartid'];
    
    include "../shared/connection.php";

    $stmt = $conn->prepare("DELETE FROM cart WHERE cartid = $cartid");
    $stmt->bind_param("i", $pid);
    $stmt->execute();

    if($stmt->affected_rows > 0) {
        header("Location: viewcart.php");
        exit;
    } else {
        echo "Failed to delete product.";
        echo $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: error.php");
    exit;
}
?>
