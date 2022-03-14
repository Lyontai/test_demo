<?php

$error = '';
$name = '';
$email = '';
$subject = '';
$message = '';

function clean_text($string)
{
	$string = trim($string);
	$string = stripslashes($string);
	$string = htmlspecialchars($string);
	return $string;
}

if (isset($_POST["submit"])) {
	if (empty($_POST["name"])) {
		$error = '<p><label class="text-danger">Please Enter your Name</label></p>';
	} else {
		$name = clean_text($_POST["name"]);
		if (!preg_match("/^[a-zA-Z]*$/", $name)) {
			$error = '<p><label class="text-danger">Only letters and white space allowed</label></p>';
		}
	}
	if (empty($_POST["email"])) {
		$error = '<p><label class="text-danger">Please Enter your Email</label></p>';
	} else {
		$email = clean_text($_POST["email"]);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error = '<p><label class="text-danger">\Invalid email format</label></p>';
		}
	}
	if (empty($_POST["subject"])) {
		$error = '<p><label class="text-danger">Subject is required</label></p>';
	} else {
		$subject = clean_text($_POST["subject"]);
	}
	if (empty($_POST["message"])) {
		$error = '<p><label class="text-danger">Message is required</label></p>';
	} else {
		$message = clean_text($_POST["message"]);
	}
	if ($error != '') {
		require 'class/class.phpmailer.php';
		require 'class/class.smtp.php';
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->Host = 'smtp.hostonmag.ng';
		$mail->Port = '465';
		$mail->SMTPAuth = true;
		$mail->Username = 'info@oshodicampaigns.org';
		$mail->Password = 'Master007*$$';
		$mail->SMTPSecure = 'ssl';
		$mail->FromName = $_POST["name"];
		$mail->From = 'info@oshodicampaigns.org';
		$mail->addAddress('info@oshodicampaigns.org', $_POST["email"]);
		// $mail->addBCC($_POST["email"], $_POST["name"]);
		$mail->AddReplyTo($_POST["email"], "Reply");
		$mail->WordWrap = 50;
		$mail->isHTML(true);
		$mail->Subject = $_POST["subject"];
		$mail->Body = $_POST["message"];
		if ($mail->send()) {
			$error = '<script>alert("Thank you for Contacting us")</script>';
		} else {
            $error = '<label class="text-danger">There is an Error, try to fill all fields.</label>';
            
		}
		$name = '';
		$email = '';
		$subject = '';
		$message = '';
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact | Ajasin Foundation</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">

    <!-- ElegantFonts CSS -->
    <link rel="stylesheet" href="css/elegant-fonts.css">

    <!-- themify-icons CSS -->
    <link rel="stylesheet" href="css/themify-icons.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="css/swiper.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./bootstrap-icons/bootstrap-icons.css">
    <style>
            .error {
                width: 50%;
                padding: 10px;
                border: 1px solid #a94442;
                color: #a94442;
                background: #f3dede;
                border-radius: 5px;
                text-align: center;
            }
        </style>
</head>
<body class="single-page contact-page">
    <header class="site-header">
            <div class="nav-bar">
            <div class="container">
                <div class="row">
                    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
                        <div class="site-branding d-flex align-items-center">
                            <a class="d-block" href="index.php" rel="home"><img class="d-block" src="images/logo.jpg" alt="logo"></a>
                            <span class="header-text">Dr. Abiola Oshodi Campaign Website <br><small>Official Website</small></span>
                        </div><!-- .site-branding -->

                        <nav class="site-navigation d-flex justify-content-end align-items-center">
                            <ul class="d-flex flex-column flex-lg-row justify-content-lg-end align-content-center">
                                <li><a href="index.php">Home</a></li>
                                <li><a href="about.php">About us</a></li>
                                <li><a href="activities.php">Activities</a></li>
                                <li><a href="gallery.php">Gallery</a></li>
                                <li><a href="#" onclick="newTabs()">Blog</a></li>
                                <li class="current-menu-item"><a href="contact.php">Contact</a></li>
                            </ul>
                        </nav><!-- .site-navigation -->

                        <div class="hamburger-menu d-lg-none">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div><!-- .hamburger-menu -->
                    </div><!-- .col -->
                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- .nav-bar -->
        
    </header><!-- .site-header --><!-- .site-header -->

    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Contact</h1>
                </div><!-- .col -->
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .page-header -->
  

    <div class="contact-page-wrap">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-5">
                    <div class="entry-content">
                        <h2>Get In touch with us</h2>

                        <p>You can contect us by sending to us a Mail in the mail section.</p>

                        <ul class="contact-info p-0">
                            <li><i class="fa fa-phone"></i><span>+234 806 005 1116</span></li>
                            <li><i class="fa fa-envelope"></i><span>info@oshodicampaigns.org</span></li>
                            <li><i class="fa fa-map-marker"></i><span>Abiola Oshodi Liberty Centre, beside Zoka Palace along St. John's Mary Unity Secondary School, Owo</span></li>
                        </ul>
                    </div>
                </div><!-- .col -->

                <div class="col-12 col-lg-7">
                    <form class="contact-form" method="POST">
                            <?php echo $error; ?>
                        <input type="text" placeholder="Name" name="name"  value="<?php echo $name; ?>" required>
                        <input type="email" placeholder="Email" name="email"  value="<?php echo $email; ?>" required>
                        <input type="text" placeholder="Subject" name="subject"  value="<?php echo $subject; ?>" required>
                        <textarea rows="15" cols="6" placeholder="Messages" name="message"  value="<?php echo $message; ?>" required></textarea>

                        <span>
                            <input class="btn gradient-bg" name="submit" type="submit" value="Contact us">
                        </span>
                    </form><!-- .contact-form -->

                </div><!-- .col -->

                <div class="col-12">
                    <div class="contact-gmap">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1765.2559651918646!2d5.595577712553494!3d7.206965720890256!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1047affd8b257de5%3A0xbeeecd5592c66f1f!2sSt.%20John%20%26%20Mary%20Secondary%20School%20Owo!5e1!3m2!1sen!2sng!4v1643243471727!5m2!1sen!2sng" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div><!-- .row -->
        </div><!-- .container -->
    </div>

 <?php include 'footer.php' ?><!-- .site-footer --><!-- .site-footer -->

    <script type='text/javascript' src='js/jquery.js'></script>
    <script type='text/javascript' src='js/jquery.collapsible.min.js'></script>
    <script type='text/javascript' src='js/swiper.min.js'></script>
    <script type='text/javascript' src='js/jquery.countdown.min.js'></script>
    <script type='text/javascript' src='js/circle-progress.min.js'></script>
    <script type='text/javascript' src='js/jquery.countTo.min.js'></script>
    <script type='text/javascript' src='js/jquery.barfiller.js'></script>
    <script type='text/javascript' src='js/custom.js'></script>
    <script src="./js/js.js"></script>
</body>
</html>