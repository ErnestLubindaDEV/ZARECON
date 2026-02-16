<?php 
$page_title = "Paper Registration - ZARECON 2026";
include 'header.php';  // ← Loads nav with ONLY Login button
?>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
$upload_success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name     = trim($_POST['full_name'] ?? '');
    $email         = trim($_POST['email'] ?? '');
    $institution   = trim($_POST['institution'] ?? '');
    $phone         = trim($_POST['phone'] ?? '');
    $paper_title   = trim($_POST['paper_title'] ?? '');
    $authors       = trim($_POST['authors'] ?? '');
    $keywords      = trim($_POST['keywords'] ?? '');
    $track         = $_POST['track'] ?? '';
    $agreement     = isset($_POST['agreement']) ? 1 : 0;

    // Basic validation
    $errors = [];
    if (empty($full_name))    $errors[] = "Full name is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (empty($institution))  $errors[] = "Institution is required.";
    if (empty($paper_title))  $errors[] = "Paper title is required.";
    if (empty($authors))      $errors[] = "Authors list is required.";
    if (empty($keywords))     $errors[] = "Keywords are required.";
    if (empty($track))        $errors[] = "Please select a track/theme.";
    if (!$agreement)          $errors[] = "You must agree to the terms and conditions.";

    // File upload validation
    $upload_dir = "uploads/abstracts/";
    $upload_file = $upload_dir . basename($_FILES["abstract_file"]["name"] ?? '');
    $file_type = strtolower(pathinfo($upload_file, PATHINFO_EXTENSION));

    if (empty($_FILES["abstract_file"]["name"])) {
        $errors[] = "Abstract/paper file is required.";
    } elseif ($_FILES["abstract_file"]["size"] > 5000000) { // 5MB limit
        $errors[] = "File is too large (max 5MB).";
    } elseif (!in_array($file_type, ['pdf', 'doc', 'docx'])) {
        $errors[] = "Only PDF, DOC, DOCX files are allowed.";
    }

    if (!empty($errors)) {
        $message = "<strong>Please fix the following errors:</strong><br>" . implode("<br>", $errors);
        $message_class = "alert-danger";
    } else {
        // Move uploaded file
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
        if (move_uploaded_file($_FILES["abstract_file"]["tmp_name"], $upload_file)) {
            $upload_success = true;
            $file_path = $upload_file;
        } else {
            $message = "File upload failed. Please try again.";
            $message_class = "alert-danger";
        }

        // Insert into database
        if ($upload_success) {
            $sql = "INSERT INTO papers (full_name, email, institution, phone, paper_title, authors, keywords, track, file_path, agreement, submitted_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssssi", $full_name, $email, $institution, $phone, $paper_title, $authors, $keywords, $track, $file_path, $agreement);

            if ($stmt->execute()) {
                $message = "<strong>Paper registration submitted successfully!</strong><br>Thank you! We'll review your submission and contact you soon.";
                $message_class = "alert-success";
            } else {
                $message = "Database error: " . $stmt->error;
                $message_class = "alert-danger";
            }
            $stmt->close();
        }
    }
}

$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Paper Registration - ZARECON 2026</title>
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

    <!-- Navigation is loaded ONLY from header.php – now with Login button only -->

    <section class="registration-section py-5">
        <div class="container">
            <div class="registration-form">
                <h2 class="section-title">Paper Registration – ZARECON 2026</h2>

                <?php if (!empty($message)): ?>
                    <div class="alert <?php echo $message_class; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="paper-registration.php" enctype="multipart/form-data">
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
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" class="form-control" 
                                   value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                        </div>
                    </div>

                    <!-- Paper Details -->
                    <h4 class="mb-3 mt-5">Paper / Abstract Details</h4>
                    <div class="form-group">
                        <label for="paper_title">Paper Title *</label>
                        <input type="text" id="paper_title" name="paper_title" class="form-control" required 
                               value="<?php echo isset($_POST['paper_title']) ? htmlspecialchars($_POST['paper_title']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="authors">Authors (comma-separated) *</label>
                        <input type="text" id="authors" name="authors" class="form-control" required 
                               value="<?php echo isset($_POST['authors']) ? htmlspecialchars($_POST['authors']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="keywords">Keywords (comma-separated) *</label>
                        <input type="text" id="keywords" name="keywords" class="form-control" required 
                               value="<?php echo isset($_POST['keywords']) ? htmlspecialchars($_POST['keywords']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="track">Track / Theme *</label>
                        <select id="track" name="track" class="form-control" required>
                            <option value="" disabled <?php echo !isset($_POST['track']) ? 'selected' : ''; ?>>Select track</option>
                            <option value="Renewable Energy Technologies" <?php echo (isset($_POST['track']) && $_POST['track'] == 'Renewable Energy Technologies') ? 'selected' : ''; ?>>Renewable Energy Technologies and Innovation</option>
                            <option value="Energy-Water-Food Nexus" <?php echo (isset($_POST['track']) && $_POST['track'] == 'Energy-Water-Food Nexus') ? 'selected' : ''; ?>>Energy–Water–Food Nexus</option>
                            <option value="Climate Resilience" <?php echo (isset($_POST['track']) && $_POST['track'] == 'Climate Resilience') ? 'selected' : ''; ?>>Climate Resilience and Inclusive Financing Models</option>
                            <option value="Green Hydrogen" <?php echo (isset($_POST['track']) && $_POST['track'] == 'Green Hydrogen') ? 'selected' : ''; ?>>Green Hydrogen Production and Utilisation</option>
                            <option value="Energy Storage" <?php echo (isset($_POST['track']) && $_POST['track'] == 'Energy Storage') ? 'selected' : ''; ?>>Energy Storage Systems</option>
                            <option value="Smart Grids" <?php echo (isset($_POST['track']) && $_POST['track'] == 'Smart Grids') ? 'selected' : ''; ?>>Smart Grids, IoT and Data-Driven Energy Systems</option>
                            <option value="Policy" <?php echo (isset($_POST['track']) && $_POST['track'] == 'Policy') ? 'selected' : ''; ?>>Policy, Regulation, and Climate Finance</option>
                        </select>
                    </div>

                    <!-- File Upload -->
                    <div class="form-group">
                        <label for="abstract_file">Upload Abstract / Paper File * (PDF, DOC, DOCX – max 5MB)</label>
                        <input type="file" id="abstract_file" name="abstract_file" class="form-control" accept=".pdf,.doc,.docx" required>
                    </div>

                    <!-- Agreement -->
                    <div class="form-group form-check mt-4">
                        <input type="checkbox" class="form-check-input" id="agreement" name="agreement" required>
                        <label class="form-check-label" for="agreement">
                            I confirm that this submission is original, has not been published elsewhere, and I agree to the <a href="#" style="color: #0f766e;">conference terms and ethics guidelines</a>.
                        </label>
                    </div>

                    <button type="submit" class="btn-submit mt-4">Submit Paper Registration</button>
                </form>

                <p class="text-center mt-4">
                    Have questions? <a href="contact.html">Contact us</a>
                </p>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>
</html>