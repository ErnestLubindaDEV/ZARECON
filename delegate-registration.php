<?php 
$page_title = "Registration - ZARECON 2026";  // Change this per page
include 'header.php'; 
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
        // Insert into database (new table or reuse with type field)
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

     <!-- Main Header-->
    <header class="main-header header-style-one">
    	
    	<!--Header-Upper-->
        <div class="header-upper">
        	<div class="outer-container">
            	<div class="clearfix">
                	
                	<div class="pull-left logo-box">
                    	<div class="logo"><a href="index.html"><img src="images1/logo.png" alt="" title=""></a></div>
                    </div>
                   	
					<div class="nav-outer clearfix">
                    
						<!--Mobile Navigation Toggler For Mobile-->
                        <div class="mobile-nav-toggler"><span class="icon flaticon-menu"></span></div>

						<!-- Main Menu -->
						<nav class="main-menu navbar-expand-md">
							<div class="navbar-header">
								<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
							</div>

							<div class="navbar-collapse collapse scroll-nav clearfix" id="navbarSupportedContent">
                                <ul style="display: flex; flex-direction: row; align-items: center; gap: 32px; margin: 0; padding: 0; justify-content: center; list-style: none;">
    <li><a href="index.html" style="padding: 10px 0; font-weight: 500; transition: color 0.3s;">Home</a></li>
    
    <li><a href="about.html" style="padding: 10px 0; font-weight: 500; transition: color 0.3s;">About</a></li>
    
    <li><a href="#" style="padding: 10px 0; font-weight: 500; transition: color 0.3s;">ZARENA Membership</a></li>
    
    <li class="has-sub dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding: 10px 0; font-weight: 500; transition: color 0.3s;">
            Registration <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" style="min-width: 220px; padding: 12px 0; margin-top: 10px; border-radius: 8px; box-shadow: 0 8px 25px rgba(0,0,0,0.12); background: #fff; border: 1px solid rgba(0,0,0,0.1);">
            <li><a href="paper-registration.php" style="display: block; padding: 10px 25px; color: #333; transition: all 0.3s;">Paper Registration</a></li>
            <li><a href="#" style="display: block; padding: 10px 25px; color: #333; transition: all 0.3s;">Delegate Registration</a></li>
            <li><a href="#" style="display: block; padding: 10px 25px; color: #333; transition: all 0.3s;">Sponsor Registration</a></li>
        </ul>
    </li>
    
    <li><a href="contact.html" style="padding: 10px 0; font-weight: 500; transition: color 0.3s;">Contact</a></li>
</ul>
							</div>
							
						</nav>
						<!-- Main Menu End-->
						
						<!-- Outer Box -->
						<div class="outer-box">
					
                           <div class="col-xl-3 text-right d-none d-xl-block">
                                <div class="header-btn second-header-btn">
                                     <a href="registration.php" class="btn"><i class="far fa-ticket-alt"></i>Register</a>
                                </div>
						</div>
						
					</div>
					
                </div>
            </div>
        </div>
        <!--End Header Upper-->
        
		<!--Sticky Header-->
        <div class="sticky-header">
        	<div class="auto-container clearfix">
            	<!--Logo-->
            	<div class="logo pull-left">
                	<a href="index.html" class="img-responsive"><img src="images1/logo.png" alt="" title=""></a>
                </div>
                
				<!--Right Col-->
                <div class="right-col pull-right">
					<!-- Main Menu -->
                    <nav class="main-menu navbar-expand-md">
                        <div class="navbar-collapse collapse clearfix" id="navbarSupportedContent1">
                            <ul class="navigation clearfix"><!--Keep This Empty / Menu will come through Javascript--></ul>
                        </div>
                    </nav><!-- Main Menu End-->
                </div>
                
            </div>
        </div>
        <!--End Sticky Header-->
		
		<!-- Mobile Menu  -->
        <div class="mobile-menu">
            <div class="menu-backdrop"></div>
            <div class="close-btn"><span class="icon flaticon-cancel"></span></div>
            
            <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
            <nav class="menu-box">
            	<div class="nav-logo"><a href="index.html"><img src="images1/logo.png" alt="" title=""></a></div>
                
                <ul class="navigation clearfix"><!--Keep This Empty / Menu will come through Javascript--></ul>
            </nav>
        </div><!-- End Mobile Menu -->

    </header>
    <!-- End Main Header -->

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

    <?php include 'footer.php'; ?>

</body>
</html>