<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zarecon";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Login processing
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Please fill in both email and password.";
    } else {
        // Find user by email
        $sql = "SELECT id, full_name, email, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $full_name, $email_db, $hashed_password);
            $stmt->fetch();

            // Verify password
            if (password_verify($password, $hashed_password)) {
                // Login successful
                $_SESSION['user_id'] = $id;
                $_SESSION['full_name'] = $full_name;
                $_SESSION['email'] = $email_db;

                // Redirect to home page
                header("Location: index.html");
                exit();
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "No account found with that email.";
        }
    }
}

$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login - ZARECON 2026</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <style>
        .login-form { max-width: 450px; margin: 60px auto; padding: 40px; background: white; border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.1); }
        .alert-danger { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 25px; }
        .btn-login { background: #0f766e; color: white; border: none; padding: 14px; width: 100%; border-radius: 50px; font-size: 18px; font-weight: 600; }
        .form-group { margin-bottom: 25px; }
        .text-center a { color: #0f766e; text-decoration: underline; }
    </style>
</head>
<body>

    <!-- Header - paste your header code here if needed -->

    <section class="login-section py-5">
        <div class="container">
            <div class="login-form">
                <h2 class="text-center mb-4" style="color: #0f766e;">Login to ZARECON 2026</h2>

                <?php if (!empty($error)): ?>
                    <div class="alert-danger">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="login.php">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn-login">Sign In</button>
                </form>

                <p class="text-center mt-4">
                    Don't have an account? <a href="registration.php">Register here</a>
                </p>
            </div>
        </div>
    </section>

    <!-- Footer - paste your footer code here if needed -->

</body>
</html>
