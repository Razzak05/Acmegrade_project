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


$stmt = $conn->prepare("SELECT * FROM product WHERE owner = ?");
$stmt->bind_param("s", $_SESSION['userid']);
$stmt->execute();
$result = $stmt->get_result();

while ($dbrow = $result->fetch_assoc()) {
    echo "<div class='own-card'>"; 
    echo "<div>" . htmlspecialchars($dbrow['name']) . "</div>"; 
    echo "<div>" . htmlspecialchars($dbrow['price']) . "</div>"; 
    echo "<div>" . htmlspecialchars($dbrow['detail']) . "</div>"; 
    echo "<div class='pdtimg'>"; 
    echo "<img src='" . htmlspecialchars($dbrow['impath']) . "'>"; 
    echo "<div>";
    echo "<a href='./edit.php'><button>Edit</button></a>";
    echo "<a href='./delete.php?pid=$dbrow[pid]'><button onclick='deletePdt($dbrow[pid])' >Delete</button></a>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
}

$stmt->close();
$conn->close();
?>

<script>
    function deletePdt(pid){
        res = confirm("Are you sure want to Delete?")
        if(res){
            window.location.href=`delete.php?pid=${pid}`;
        }
    }
</script>
</body>
</html>