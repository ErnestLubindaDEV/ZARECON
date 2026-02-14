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
$upload_success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company_name      = trim($_POST['company_name'] ?? '');
    $contact_person    = trim($_POST['contact_person'] ?? '');
    $email             = trim($_POST['email'] ?? '');
    $phone             = trim($_POST['phone'] ?? '');
    $package           = $_POST['package'] ?? '';
    $additional_info   = trim($_POST['additional_info'] ?? '');
    $agreement         = isset($_POST['agreement']) ? 1 : 0;

    // File upload (e.g. company logo or proposal)
    $upload_dir = "uploads/sponsor-documents/";
    $upload_file = $upload_dir . basename($_FILES["sponsor_doc"]["name"] ?? '');
    $file_type = strtolower(pathinfo($upload_file, PATHINFO_EXTENSION));

    // Validation
    $errors = [];
    if (empty($company_name))      $errors[] = "Company/Organization name is required.";
    if (empty($contact_person))    $errors[] = "Contact person name is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (empty($phone))             $errors[] = "Phone number is required.";
    if (empty($package))           $errors[] = "Please select a sponsorship package.";
    if (!$agreement)               $errors[] = "You must agree to the terms.";

    if (!empty($_FILES["sponsor_doc"]["name"])) {
        if ($_FILES["sponsor_doc"]["size"] > 5000000) $errors[] = "File too large (max 5MB).";
        if (!in_array($file_type, ['pdf', 'doc', 'docx', 'png', 'jpg', 'jpeg'])) $errors[] = "Allowed: PDF, DOC, DOCX, PNG, JPG.";
    }

    if (!empty($errors)) {
        $message = "<strong>Please fix the following:</strong><br>" . implode("<br>", $errors);
        $message_class = "alert-danger";
    } else {
        // Handle file upload (optional field)
        $file_path = null;
        if (!empty($_FILES["sponsor_doc"]["name"]) && move_uploaded_file($_FILES["sponsor_doc"]["tmp_name"], $upload_file)) {
            $file_path = $upload_file;
        }

        // Insert into database
        $sql = "INSERT INTO sponsor_registrations (company_name, contact_person, email, phone, package, additional_info, file_path, agreement, submitted_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssi", $company_name, $contact_person, $email, $phone, $package, $additional_info, $file_path, $agreement);

        if ($stmt->execute()) {
            $message = "<strong>Sponsorship registration submitted successfully!</strong><br>Thank you for supporting ZARECON 2026.<br>We will review your application and contact you soon with next steps and invoice.";
            $message_class = "alert-success";
        } else {
            $message = "Error: " . $stmt->error;
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
    <title>Sponsor Registration - ZARECON 2026</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <style>
        .registration-form { max-width: 800px; margin: 40px auto; padding: 40px; background: white; border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.1); }
        .section-title { color: #0f766e; margin-bottom: 30px; text-align: center; }
        .package-table { margin-bottom: 40px; }
        .package-table th, .package-table td { padding: 15px; text-align: center; vertical-align: middle; }
        .package-table .package-name { font-weight: 600; font-size: 18px; }
        .package-table .price { font-size: 24px; color: #0f766e; font-weight: 700; }
        .alert { padding: 15px; margin-bottom: 25px; border-radius: 8px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .btn-submit { background: #0f766e; color: white; border: none; padding: 14px 40px; border-radius: 50px; font-size: 18px; font-weight: 600; cursor: pointer; }
        .btn-submit:hover { background: #0c5c56; }
        .form-group { margin-bottom: 20px; }
        .form-control:focus { border-color: #14b8a6; box-shadow: 0 0 0 0.25rem rgba(20,184,166,0.25); }
    </style>
</head>
<body>

    <!-- Your header -->

    <section class="registration-section py-5">
        <div class="container">
            <div class="registration-form">
                <h2 class="section-title">Sponsor Registration – ZARECON 2026</h2>

                <?php if (!empty($message)): ?>
                    <div class="alert <?php echo $message_class; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

 <!-- Sponsorship Packages Table -->
<div class="package-table table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Package</th>
                <th>Benefits</th>
                <th>Price (ZMW)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="package-name">Platinum</td>
                <td>Keynote slot, premium booth, logo on all materials, 6 free delegates, full-page ad</td>
                <td class="price">150,000</td>
            </tr>
            <tr>
                <td class="package-name">Gold</td>
                <td>Panel participation, standard booth, logo on website & program, 4 free delegates</td>
                <td class="price">100,000</td>
            </tr>
            <tr>
                <td class="package-name">Silver</td>
                <td>Logo on website & program, 2 free delegates, exhibit space</td>
                <td class="price">50,000</td>
            </tr>
            <tr>
                <td class="package-name">Bronze</td>
                <td>Logo on website, 1 free delegate</td>
                <td class="price">25,000</td>
            </tr>
        </tbody>
    </table>
    <p class="text-muted small text-center mt-2">Prices are in Zambian Kwacha (ZMW) – final quote provided upon review.</p>
</div>

                <form method="POST" action="sponsor-registration.php" enctype="multipart/form-data">
                    <!-- Company Information -->
                    <h4 class="mb-3">Company / Organization Information</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="company_name">Company / Organization Name *</label>
                            <input type="text" id="company_name" name="company_name" class="form-control" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="contact_person">Contact Person *</label>
                            <input type="text" id="contact_person" name="contact_person" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="phone">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" class="form-control" required>
                        </div>
                    </div>

                    <!-- Package Selection -->
                    <h4 class="mb-3 mt-5">Sponsorship Package</h4>
                    <div class="form-group">
                        <select id="package" name="package" class="form-control" required>
                            <option value="" disabled selected>Select package</option>
                            <option value="Platinum">Platinum ($15,000)</option>
                            <option value="Gold">Gold ($10,000)</option>
                            <option value="Silver">Silver ($5,000)</option>
                            <option value="Bronze">Bronze ($2,500)</option>
                            <option value="Other">Other (please specify below)</option>
                        </select>
                    </div>
                    <div class="form-group" id="custom-package-group" style="display:none;">
                        <label for="custom_package">Custom Package Details</label>
                        <textarea id="custom_package" name="custom_package" class="form-control" rows="3" placeholder="Describe your proposed sponsorship level or custom package"></textarea>
                    </div>

                    <!-- Additional Info & Upload -->
                    <h4 class="mb-3 mt-5">Additional Information</h4>
                    <div class="form-group">
                        <label for="additional_info">Additional Comments / Requirements (optional)</label>
                        <textarea id="additional_info" name="additional_info" class="form-control" rows="4" placeholder="e.g. preferred branding placement, booth requirements, etc."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="sponsor_doc">Upload Company Logo or Sponsorship Proposal (optional – PDF, PNG, JPG)</label>
                        <input type="file" id="sponsor_doc" name="sponsor_doc" class="form-control" accept=".pdf,.png,.jpg,.jpeg">
                    </div>

                    <p class="text-muted small text-center mt-3">
                          For international sponsors: Approximate USD equivalent based on current rates (subject to change). Contact us for exact invoicing.
                   </p>

                    <!-- Agreement -->
                    <div class="form-group form-check mt-4">
                        <input type="checkbox" class="form-check-input" id="agreement" name="agreement" required>
                        <label class="form-check-label" for="agreement">
                            I confirm that the information provided is accurate and agree to the <a href="#" style="color: #0f766e;">sponsorship terms, payment conditions, and branding guidelines</a>.
                        </label>
                    </div>

                    <button type="submit" class="btn-submit mt-4">Submit Sponsorship Registration</button>
                </form>

                <p class="text-center mt-4">
                    Questions? <a href="contact.html">Contact us</a> | Already registered? <a href="login.php">Log in</a>
                </p>
            </div>
        </div>
    </section>

    <!-- Your footer -->

</body>
</html>