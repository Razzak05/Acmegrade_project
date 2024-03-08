<?php

session_start();
print_r($_POST);

echo "<br>";

print_r($_FILES['pdtimg']);

$source = $_FILES['pdtimg']['tmp_name'];
$dest = "../shared/images/" . $_FILES['pdtimg']['name'];

echo "<br>";
echo $dest;

move_uploaded_file($source, $dest);

include "../shared/connection.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$price = $_POST['price'];
$detail = $_POST['detail'];
$impath = $dest;
$owner = $_SESSION['userid'];


$stmt = $conn->prepare("INSERT INTO product (name, price, detail, impath, owner) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $price, $detail, $impath, $owner);

if ($stmt->execute()) {
    echo "Product Uploaded Successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
