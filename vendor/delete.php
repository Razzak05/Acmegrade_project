<?php
if(isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    
    include "../shared/connection.php";

    $stmt = $conn->prepare("DELETE FROM product WHERE pid = ?");
    $stmt->bind_param("i", $pid);
    $stmt->execute();

    if($stmt->affected_rows > 0) {
        header("Location: view.php");
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
