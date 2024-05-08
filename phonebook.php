<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "mini";
 
$conn = new mysqli($servername, $username, $password, $database, 3306);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function addUser($name, $phone_number, $email, $conn) {
    $name = mysqli_real_escape_string($conn, $name);
    $phone_number = mysqli_real_escape_string($conn, $phone_number);
    $email = mysqli_real_escape_string($conn, $email);

    $check_sql = "SELECT * FROM users WHERE phone_number = '$phone_number' OR email = '$email'";
    $result = $conn->query($check_sql);
    if ($result && $result->num_rows > 0) {
        echo "Phone number or email already exists in the database";
    } else {
        $sql = "INSERT INTO users (name, phone_number, email) VALUES ('$name', '$phone_number', '$email')";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];

    if (!empty($name) && !empty($phone_number) && !empty($email)) {
        
        if (preg_match("/^\d{10}$/", $phone_number)) {
            
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                addUser($name, $phone_number, $email, $conn);
            } else {
                echo "Invalid email format";
            }
        } else {
            echo "Phone number must be eaxctly of 10 digits";
        }
    } else {
        echo "Name, phone number, and email are required";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Phonebook</title>
    <style>
    body {
        text-align: center; 
    }
    form {
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 300px;
        text-align: left; 
    }
    input[type="text"] {
        width: calc(100% - 20px); 
        padding: 10px;
        margin-bottom: 10px;
        box-sizing: border-box;
    }
    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    input[type="submit"]:hover {
        background-color: #45a049;
    }

    .view-button {
        display: inline-block;
        background-color: #008CBA;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    .view-button:hover {
        background-color: #005f7a;
    }
    </style>
</head>
<body>
    <h2>Add New Contact</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name"><br><br>
        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" id="phone_number" pattern="\d{10}" title="Phone number must be exactly 10 digits" required><br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>
        <input type="submit" value="Add Contact">
    </form>

    <a href="view.php" class="view-button">View Contacts</a>
</body>
</html>
