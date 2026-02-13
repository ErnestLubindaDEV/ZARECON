<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zarecon";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form processing
$message = "";
$message_class = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $institution = trim($_POST['institution']);

    // Basic validation
    if (empty($full_name) || empty($email) || empty($password) || empty($institution)) {
        $message = "All fields are required. Please fill everything out.";
        $message_class = "alert-danger";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
        $message_class = "alert-danger";
    } else {
        // Check if email already exists
        $check_sql = "SELECT email FROM users WHERE email = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $message = "This email is already registered. Please use a different email or log in.";
            $message_class = "alert-danger";
        } else {
            // Insert new user
            $sql = "INSERT INTO users (full_name, email, password, institution) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $full_name, $email, $password, $institution);

            if ($stmt->execute()) {
                $message = "<strong>Registration successful!</strong> Welcome to ZARECON 2026!<br>You can now log in or continue exploring. We'll send you a confirmation email shortly.";
                $message_class = "alert-success";
            } else {
                $message = "Something went wrong. Please try again or contact support.";
                $message_class = "alert-danger";
            }
        }
    }
}

$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Registration - ZARECON 2026</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Your CSS links (copy from index or about) -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!-- Add others as needed -->

    <style>
        .registration-form { max-width: 500px; margin: 50px auto; padding: 40px; background: white; border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.1); }
        .alert { padding: 15px; margin-bottom: 25px; border-radius: 8px; font-size: 16px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .btn-submit { background: #0f766e; color: white; border: none; padding: 14px; width: 100%; border-radius: 50px; font-size: 18px; font-weight: 600; }
        .form-group { margin-bottom: 25px; }
    </style>
</head>
<body>

    <!-- Your header here -->

    <section class="registration-section py-5">
        <div class="container">
            <div class="registration-form">
                <h2 class="text-center mb-4" style="color: #0f766e;">Register for ZARECON 2026</h2>

                <!-- Success/Error Message -->
                <?php if (!empty($message)): ?>
                    <div class="alert <?php echo $message_class; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <!-- Form -->
                <form method="POST" action="registration.php">
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" id="full_name" name="full_name" class="form-control" required value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="institution">Institution / Organization</label>
                        <input type="text" id="institution" name="institution" class="form-control" required value="<?php echo isset($_POST['institution']) ? htmlspecialchars($_POST['institution']) : ''; ?>">
                    </div>
                    <button type="submit" class="btn-submit">Complete Registration</button>
                </form>

                <p class="text-center mt-4" style="font-size: 15px;">
                    Already registered? <a href="#" style="color: #0f766e;">Log in here</a>
                </p>
            </div>
        </div>
    </section>

    <!-- Your footer here -->

</body>
</html>