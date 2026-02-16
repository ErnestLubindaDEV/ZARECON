<?php
$page_title = "Delegate Registration - ZARECON 2026";
include 'header.php';  // ← This is the ONLY header include – keeps one logo and one nav
?>

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
    $full_name     = trim($_POST['full_name'] ?? '');
    $email         = trim($_POST['email'] ?? '');
    $institution   = trim($_POST['institution'] ?? '');
    $phone         = trim($_POST['phone'] ?? '');
    $country       = trim($_POST['country'] ?? '');
    $category      = $_POST['category'] ?? '';
    $dietary       = trim($_POST['dietary'] ?? '');
    $accessibility = trim($_POST['accessibility'] ?? '');
    $agreement     = isset($_POST['agreement']) ? 1 : 0;

    // Validation
    $errors = [];
    if (empty($full_name))     $errors[] = "Full name is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (empty($institution))   $errors[] = "Institution is required.";
    if (empty($phone))         $errors[] = "Phone number is required.";
    if (empty($country))       $errors[] = "Country is required.";
    if (empty($category))      $errors[] = "Please select a registration category.";
    if (!$agreement)           $errors[] = "You must agree to the terms.";

    if (!empty($errors)) {
        $message = "<strong>Please fix the following errors:</strong><br>" . implode("<br>", $errors);
        $message_class = "alert-danger";
    } else {
        // Insert into database
        $sql = "INSERT INTO registrations (full_name, email, institution, phone, country, category, dietary, accessibility, agreement, submitted_at, type) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'delegate')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssi", $full_name, $email, $institution, $phone, $country, $category, $dietary, $accessibility, $agreement);

        if ($stmt->execute()) {
            $message = "<strong>Delegate registration successful!</strong><br>Thank you for registering for ZARECON 2026.<br>We will send you confirmation and payment details shortly.";
            $message_class = "alert-success";
        } else {
            $message = "Error: " . $stmt->error . ". Please try again.";
            $message_class = "alert-danger";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Delegate Registration - ZARECON 2026</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <style>
        .registration-form {
            max-width: 700px;
            margin: 40px auto;
            padding: 40px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        }
        .section-title {
            color: #0f766e;
            margin-bottom: 30px;
            text-align: center;
        }
        .alert {
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 8px;
            font-size: 16px;
        }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger  { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .btn-submit {
            background: #0f766e;
            color: white;
            border: none;
            padding: 14px 40px;
            border-radius: 50px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn-submit:hover { background: #0c5c56; }
        .form-group { margin-bottom: 20px; }
        .form-control:focus {
            border-color: #14b8a6;
            box-shadow: 0 0 0 0.25rem rgba(20,184,166,0.25);
        }
    </style>
</head>
<body>

    <!-- Navigation is loaded ONLY from header.php – no duplicates here -->

    <section class="registration-section py-5">
        <div class="container">
            <div class="registration-form">
                <h2 class="section-title">Delegate Registration – ZARECON 2026</h2>

                <?php if (!empty($message)): ?>
                    <div class="alert <?php echo $message_class; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="delegate-registration.php">
                    <!-- Personal Information -->
                    <h4 class="mb-3">Personal Information</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="full_name">Full Name *</label>
                            <input type="text" id="full_name" name="full_name" class="form-control" required 
                                   value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" class="form-control" required 
                                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="institution">Institution / Organization *</label>
                            <input type="text" id="institution" name="institution" class="form-control" required 
                                   value="<?php echo isset($_POST['institution']) ? htmlspecialchars($_POST['institution']) : ''; ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="phone">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" class="form-control" required 
                                   value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="country">Country *</label>
                        <input type="text" id="country" name="country" class="form-control" required 
                               value="<?php echo isset($_POST['country']) ? htmlspecialchars($_POST['country']) : ''; ?>">
                    </div>

                    <!-- Registration Category -->
                    <h4 class="mb-3 mt-5">Registration Category</h4>
                    <div class="form-group">
                        <select id="category" name="category" class="form-control" required>
                            <option value="" disabled selected>Select category</option>
                            <option value="Student" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Student') ? 'selected' : ''; ?>>Student (Proof required)</option>
                            <option value="Regular" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Regular') ? 'selected' : ''; ?>>Regular Delegate</option>
                            <option value="Virtual" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Virtual') ? 'selected' : ''; ?>>Virtual Participation</option>
                            <option value="Academia" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Academia') ? 'selected' : ''; ?>>Academic / Researcher</option>
                            <option value="Industry" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Industry') ? 'selected' : ''; ?>>Industry Professional</option>
                        </select>
                    </div>

                    <!-- Additional Info -->
                    <h4 class="mb-3 mt-5">Additional Information</h4>
                    <div class="form-group">
                        <label for="dietary">Dietary Requirements (optional)</label>
                        <input type="text" id="dietary" name="dietary" class="form-control" placeholder="e.g. Vegetarian, Vegan, Gluten-free" 
                               value="<?php echo isset($_POST['dietary']) ? htmlspecialchars($_POST['dietary']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="accessibility">Accessibility Needs (optional)</label>
                        <input type="text" id="accessibility" name="accessibility" class="form-control" placeholder="e.g. Wheelchair access, sign language interpreter" 
                               value="<?php echo isset($_POST['accessibility']) ? htmlspecialchars($_POST['accessibility']) : ''; ?>">
                    </div>

                    <!-- Agreement -->
                    <div class="form-group form-check mt-4">
                        <input type="checkbox" class="form-check-input" id="agreement" name="agreement" required>
                        <label class="form-check-label" for="agreement">
                            I agree to the <a href="#" style="color: #0f766e;">conference terms, cancellation policy, and data privacy notice</a>.
                        </label>
                    </div>

                    <button type="submit" class="btn-submit mt-4">Complete Delegate Registration</button>
                </form>

                <p class="text-center mt-4">
                    Have questions? <a href="contact.html">Contact us</a> | Already registered? <a href="login.php">Log in</a>
                </p>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>  <!-- If you have a separate footer file -->

</body>
</html>