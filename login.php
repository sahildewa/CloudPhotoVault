
<?php

session_start();

include("config/database.php");

$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 1)
    {
        $_SESSION['username'] = $username;

        header("Location: dashboard.php");
        exit();
    }
    else
    {
        $error = "Invalid Username or Password";
    }
}
?>
<?php

include("config/database.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cloud PhotoVault - Login</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="login-container">

    <div class="login-card">

        <h1>📸 Cloud PhotoVault</h1>

        <h2>Login</h2>

        <form method="POST">
            
<?php

if($error!="")
{

echo "<p style='color:red;'>$error</p>";

}

?>
            <input
                type="text"
                name="username"
                placeholder="Username"
                required>

            <input
                type="password"
                name="password"
                placeholder="Password"
                required>

            <button type="submit">

                Login

            </button>

        </form>

        <a href="index.php">

            ← Back to Home

        </a>

    </div>

</div>

</body>

</html>