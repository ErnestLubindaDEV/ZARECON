<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'ZARECON 2026'; ?></title>

    <!-- CSS links -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="fontawesome/css/all.min.css" rel="stylesheet">
    <!-- Add other CSS files you use here -->
</head>
<body>

<!-- Navigation Header -->
<header id="home" class="header-area">
    <div id="header-sticky" class="menu-area">
        <div class="container">
            <div class="second-menu">
                <div class="row align-items-center">
                    <!-- Logo -->
                    <div class="col-xl-3 col-lg-3">
                        <div class="logo">
                            <a href="index.html">
                                <img src="img/logo/logo.png" alt="ZARECON Logo" style="max-height: 60px; width: auto;">
                            </a>
                        </div>
                    </div>

                    <!-- Main Menu -->
                    <div class="col-xl-6 col-lg-9">
                        <div class="responsive"><i class="icon dripicons-align-right"></i></div>
                        <div class="main-menu text-right text-xl-center">
                            <nav id="mobile-menu">
                                <ul>
                                    <li><a href="index.html">Home</a></li>
                                    <li><a href="about.html">About</a></li>
                                    <li><a href="#">ZARENA Membership</a></li>
                                    <li class="has-sub dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            Registration <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="paper-registration.php">Paper Registration</a></li>
                                            <li><a href="delegate-registration.php">Delegate Registration</a></li>
                                            <li><a href="sponsor-registration.php">Sponsor Registration</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="contact.html">Contact</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <!-- Login Button (Register removed) -->
                    <div class="col-xl-3 text-right d-none d-xl-block">
                        <div class="header-btn second-header-btn">
                            <a href="login.php" class="btn" style="margin-right: 0;">
                                <i class="far fa-user"></i> Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Optional Breadcrumb (only shows if $show_breadcrumb is set) -->
<?php if (isset($show_breadcrumb) && $show_breadcrumb): ?>
<section class="breadcrumb-area py-4 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    <?php echo htmlspecialchars($page_title ?? 'Page'); ?>
                </li>
            </ol>
        </nav>
    </div>
</section>
<?php endif; ?>

<main>