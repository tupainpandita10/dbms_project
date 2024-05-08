
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "mini";

$conn = new mysqli($servername, $username, $password, $database, 3306);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT user_id, name, phone_number, email FROM users"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Phonebook</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        
        th { 
            font-family: Arial, Helvetica, sans-serif;  
            background-color: orange;
            color: black;
            font-size: 20px;
            
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
        
        a {
            color: black;
            text-decoration: none;
            font-family: 'Roboto', sans-serif;
        }
        
        a:hover {
            text-decoration: underline;
        }
        
        h2 {
            cursor: pointer;
            color: blue;
            font-family: Tahoma, Verdana, sans-serif;
        }
        
        h2:hover {
            color: blue;
        }
        
        td {
            color: blue;
            background-color: white;
        }
    </style>
</head>
<body>
    <h2>Phonebook</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Email</th> 
            <th>Operation</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["user_id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["phone_number"] . "</td>";
                echo "<td>" . $row["email"] . "</td>"; 
                echo "<td><a href='remove.php?user_id=" . $row["user_id"] . "'>Remove</a> | <a href='update.php?user_id=" . $row["user_id"] . "'>Update</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No users found</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
