<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "mini";


$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
    
    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);

    $sql = "DELETE FROM users WHERE user_id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        echo "User removed successfully";
    } else {
        echo "Error removing user: " . $conn->error;
    }
} else {
    echo "Invalid user ID";
}


$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Back to Phone View</title>
    <style>
        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <a href="view.php">Back to Phone View</a>
</body>
</html>
