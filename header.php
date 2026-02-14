<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($page_title) ? $page_title : 'ZARECON 2026'; ?></title>

    <!-- CSS links – adjust paths if needed -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="fontawesome/css/all.min.css" rel="stylesheet">
    <!-- Add other CSS you use -->
</head>
<body>

<!-- Navigation Header -->
<header id="home" class="header-area">
    <div id="header-sticky" class="menu-area">
        <div class="container">
            <div class="second-menu">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-3">
                        <div class="logo">
                            <a href="index.html"><img src="img/logo/logo.png" alt="ZARECON Logo"></a>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-9">
                        <div class="responsive"><i class="icon dripicons-align-right"></i></div>
                        <div class="main-menu text-right text-xl-center">
                            <nav id="mobile-menu">
                                <ul>
                                    <li><a href="index.html">Home</a></li>
                                    <li><a href="about.html">About</a></li>
                                    <li><a href="#">ZARENA Membership</a></li>
                                    <li class="has-sub dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Registration <span class="caret"></span></a>
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
                    <div class="col-xl-3 text-right d-none d-xl-block">
                        <div class="header-btn second-header-btn">
                            <a href="login.php" class="btn"><i class="far fa-user"></i> Login</a>
                            <a href="registration.php" class="btn ms-2"><i class="far fa-ticket-alt"></i> Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Optional: Small top banner or breadcrumb on inner pages -->
<?php if (isset($show_breadcrumb) && $show_breadcrumb): ?>
<section class="breadcrumb-area py-4 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $page_title ?? 'Page'; ?></li>
            </ol>
        </nav>
    </div>
</section>
<?php endif; ?>

<main>
