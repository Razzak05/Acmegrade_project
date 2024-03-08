<!DOCTYPE html>
<html>
<head>
    <style>
        .own-card {
            width: 300px;
            height: 350px;
            display: inline-block;
            background-color: bisque;
            vertical-align: top;
            margin: 10px;
            padding: 10px;
        }

        img {
            width: 100%;
        }

        .display-1 {
            font-size: 24px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?php
include "authguard.php";
include "menu.html";

if (!isset($_SESSION['userid'])) {
    echo "Session variable 'userid' not set.";
    exit;
}

include "../shared/connection.php";
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * FROM cart JOIN product ON cart.pid = product.pid WHERE userid = ?");
$stmt->bind_param("s", $_SESSION['userid']);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
while ($dbrow = $result->fetch_assoc()) {
    $total += $dbrow["price"];
    echo "<div class='own-card'>"; 
    echo "<div>" . htmlspecialchars($dbrow['name']) . "</div>"; 
    echo "<div>" . htmlspecialchars($dbrow['price']) . "</div>"; 
    echo "<div>" . htmlspecialchars($dbrow['detail']) . "</div>"; 
    echo "<div class='pdtimg'>"; 
    echo "<img src='" . htmlspecialchars($dbrow['impath']) . "'>"; 
    echo "<div>";
    echo "<a href='./edit.php'><button>Edit</button></a>";
    echo "<button onclick='deletePdt(" . $dbrow['pid'] . ")' >Remove Cart</button>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
}

echo "<div class='m-3'>
    <form method='post' action='placeorder.php' class='w-50'>
        <h3>Place Order</h3>
        <textarea class='form-control' name='address' placeholder='Enter Delivery Address'></textarea>
        <input value='$total'  hidden name='total'>
        <button class='p-3 btn btn-primary'>Place Order $total Rs</button>
    </form>
</div>";

$stmt->close();
$conn->close();
?>

<script>
    function deleteCart(cartid){
        res = confirm("Are you sure want to delete?")
        if(res){
            window.location.href = `delete.php?cartid=${cartid}`;
        }
    }
</script>
</body>
</html>
