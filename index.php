<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: admin.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: admin.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Sim Registration</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/icon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- CDN Links --> 
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 

</head>

<body>

 <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a>SimReg</a></h1>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">About</a></li>
          <li><a class="nav-link scrollto" href="#team">Team</a></li>
          <li><a class="nav-link scrollto" href="#faq">FAQ</a></li>
          <li><a class="getstarted scrollto" data-bs-toggle="modal" data-bs-target="#myModal" href="">Admin</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h6 class="modal-title">Admin Login</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-floating mb-3 mt-3">
                <input type="text" name="username" id="uname" placeholder="enter username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" required>
                <label for="uname">Username</label>
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-floating mb-3 mt-3">
                <input type="password" name="password" id="pword" placeholder="enter password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <label for="pword">Password</label>
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
              
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary btn-sm" value="Login">
            </div> 
        </form>
      </div>
   

    </div>
  </div>
</div>

<!-- ======= Hero Section ======= -->
   <section id="hero" class="d-flex align-items-center">
    <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
      <div class="row justify-content-center">
        <div class="col-xl-7 col-lg-9 text-center">
          <h1>SIM Registration System</h1>
          <h2>We are team of <span class="typed" data-typed-items='talented, dedicated, passionate, aspiring software engineer'></span> students.</h2>
        </div>
      </div>
      <div class="text-center">
        <a href="registrant.php" class="btn-get-started scrollto">Register Now!</a>
      </div>

      <div class="row icon-boxes">
        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="200">
          <div class="icon-box">
            <div class="icon"><i class="bi bi-globe2"></i></div>
            <h4 class="title"><a href="">Globe</a></h4>
            <p class="description">Globe Telecom, Inc., commonly shortened as Globe, is a major provider of telecommunications services in the Philippines</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="300">
          <div class="icon-box">
            <div class="icon"><i class="bi bi-graph-up"></i></div>
            <h4 class="title"><a href="">Smart</a></h4>
            <p class="description">Smart Communications Inc., commonly referred to as Smart, is a wholly owned wireless communications and digital services subsidiary of PLDT Inc.</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="400">
          <div class="icon-box">
            <div class="icon"><i class="bi bi-geo-alt-fill"></i></div>
            <h4 class="title"><a href="">DITO</a></h4>
            <p class="description">Dito Telecommunity Corporation (stylized as DITO), formerly known as Mindanao Islamic Telephone Company, Inc. or Mislatel</p>
          </div>
        </div>

        <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="500">
          <div class="icon-box">
            <div class="icon"><i class="bi bi-sun"></i></div>
            <h4 class="title"><a href="">Sun Cellular</a></h4>
            <p class="description">Digitel Mobile Philippines, Inc., doing business as Sun Cellular, was a wholly owned subsidiary of Digital Telecommunications Philippines</p>
          </div>
        </div>

      </div>
    </div>
  </section><!-- End Hero -->

  <main id="main">

  
      <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>About Sim Registration</h2>
          <p>This section would give you an overview about the Sim Registration Act.</p>
        </div>

        <div class="row content">
          <div class="col-lg-6">
            <p>
             What is Sim Registration Act (SRA)?
            </p>
            <ul>
              <li><i class="ri-check-double-line"></i> Republic Act No. 11934 or the SIM Registration Act (SRA) requires all new subscribers to register their SIM card prior to activation, and for existing subscribers to avoid deactivation.</li>
              <li><i class="ri-check-double-line"></i> The Implementing Rules and Regulations (IRR) of the SRA issued by the National Telecommunications Commission shall take effect on 27 December 2022.</li>
              <li><i class="ri-check-double-line"></i> The law promotes accountability on the use of the SIM card and provides competent authorities the necessary tools to detect and stop criminal activities such as text scams, cybercrimes, terrorism, and other offenses committed through text messages, voice calls and other relevant telecommunications services.</li>
            </ul>
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0">
            <p>
            Failure to register SIMs before the deadline will result in deactivation, rendering them unusable for voice calls, text messaging, and mobile data services. This action is part of the government’s effort to improve national security and curb fraudulent activities such as scams and identity theft.
            </p>
            <p>Below is the current statistics of the registered and unregistered sim card users. According to philstar.com</p>
            <a href="https://www.philstar.com/headlines/2023/04/17/2259384/nearing-deadline-only-413-percent-sim-cards-registered" class="btn-learn-more" target="_blank">Learn More</a>
          </div>
        </div>

      </div>
    </section><!-- End About Section -->

       <!-- ======= Counts Section ======= -->
       <section id="counts" class="counts section-bg">
      <div class="container">

        <div class="row justify-content-end">

          <div class="col-lg-3 col-md-5 col-6 d-md-flex align-items-md-stretch">
            <div class="count-box">
              <span data-purecounter-start="0" data-purecounter-end="168977773" data-purecounter-duration="2" class="purecounter"></span>
              <p>Sim Card users Nationwide</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-5 col-6 d-md-flex align-items-md-stretch">
            <div class="count-box">
              <span data-purecounter-start="0" data-purecounter-end="69828115" data-purecounter-duration="2" class="purecounter"></span>
              <p>Registered Users</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-5 col-6 d-md-flex align-items-md-stretch">
            <div class="count-box">
              <span data-purecounter-start="0" data-purecounter-end="99149658" data-purecounter-duration="2" class="purecounter"></span>
              <p>Unregistered Users</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-5 col-6 d-md-flex align-items-md-stretch">
            <div class="count-box">
              <span data-purecounter-start="0" data-purecounter-end="41" data-purecounter-duration="2" class="purecounter"></span>
              <p>Percentage</p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Counts Section -->


     <!-- ======= Team Section ======= -->
     <section id="team" class="team section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Team</h2>
          <p>Our team was collaborated by ACT (Associate in Computer Technology) and BSCS (Bachelor of Science in Computer Science) to build this powerful, excellent design and interactive website. Thanks to BootstrapMade for this template</p>
        </div>

        <div class="row">

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
            <div class="member">
              <div class="member-img">
                <img src="assets/img/team/Dev.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href="https://twitter.com/navales_louie" target="_blank"><i class="bi bi-twitter"></i></a>
                  <a href="https://www.facebook.com/johnlouie.navales" target="_blank"><i class="bi bi-facebook"></i></a>
                  <a href="https://www.instagram.com/navalesjohnlouie/" target="_blank"><i class="bi bi-instagram"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Louie Navales BSCS-2</h4>
                <span>Developer</span>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
            <div class="member">
              <div class="member-img">
                <img src="assets/img/team/designer.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href="https://twitter.com/JeanAyen194243" target="_blank"><i class="bi bi-twitter"></i></a>
                  <a href="https://www.facebook.com/profile.php?id=100074733617993" target="_blank"><i class="bi bi-facebook"></i></a>
                  <a href="https://www.instagram.com/jeanny122621/" target="_blank"><i class="bi bi-instagram"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Jean Ayen BSCS-2</h4>
                <span>Designer</span>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
            <div class="member">
              <div class="member-img">
                <img src="assets/img/team/backup.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href="https://twitter.com/CabilanKris05" target="_blank"><i class="bi bi-twitter"></i></a>
                  <a href="https://web.facebook.com/krisjane.cabilan" target="_blank"><i class="bi bi-facebook"></i></a>
                  <a href="https://www.instagram.com/krisjane_cabilan/" target="_blank"><i class="bi bi-instagram"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Kris Jane Cabilan BSCS-2</h4>
                <span>Back Up Developer</span>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="400">
            <div class="member">
              <div class="member-img">
                <img src="assets/img/team/tester-1.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href="https://twitter.com/colico_fel84480" target="_blank"><i class="bi bi-twitter"></i></a>
                  <a href="https://www.facebook.com/felma.colico.9" target="_blank"><i class="bi bi-facebook"></i></a>
                  <a href="" target="_blank"><i class="bi bi-instagram"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Felma Colico BSCS-2</h4>
                <span>Tester</span>
              </div>
            </div>
          </div>
          </div>

          <div class="row justify-content-center">
          
          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="600">
            <div class="member">
          
            </div>
          </div>
          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="500">
            <div class="member">
              <div class="member-img">
                <img src="assets/img/team/data-admin-1.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href="" target="_blank"><i class="bi bi-twitter"></i></a>
                  <a href="https://www.facebook.com/rizaline.banaga" target="_blank"><i class="bi bi-facebook"></i></a>
                  <a href="https://www.instagram.com/katalinaa_02/" target="_blank"><i class="bi bi-instagram"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Rizaline Bonilla ACT-2</h4>
                <span>Data Administrator 1</span>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="600">
            <div class="member">
              <div class="member-img">
                <img src="assets/img/team/data-admin-2.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href="https://twitter.com/AprilanneCadag/" target="_blank"><i class="bi bi-twitter"></i></a>
                  <a href="https://www.facebook.com/aprilanne.cadag" target="_blank"><i class="bi bi-facebook"></i></a>
                  <a href="https://www.instagram.com/itsbabyannecadag/" target="_blank"><i class="bi bi-instagram"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>April Anne Cadag ACT-2</h4>
                <span>Data Administrator 2</span>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="600">
            <div class="member">
              
            </div>
          </div>
          </div>

        

      </div>
    </section><!-- End Team Section -->

        <!-- ======= Frequently Asked Questions Section ======= -->
    <section id="faq" class="faq section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Frequently Asked Questions</h2>
          <p>Got questions? We’ve put together answers to the FAQs about the SIM Registration Act (SRA).</p>
        </div>

        <div class="faq-list">
          <ul>
            <li data-aos="fade-up">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse" data-bs-target="#faq-list-1">What is the SIM Register? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-1" class="collapse show" data-bs-parent=".faq-list">
                <p>
                The SIM Register refers to the secure digital database containing the required information for registered postpaid and prepaid subscribers.
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="100">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-2" class="collapsed">Will my data be used for other purposes other than SIM Registration? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-2" class="collapse" data-bs-parent=".faq-list">
                <p>
                No. The information in the SIM Register will only be used for the purpose of registering SIM cards.
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="200">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-3" class="collapsed">What happens if I fail to register my SIM before the dealine? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-3" class="collapse" data-bs-parent=".faq-list">
                <p>
                For existing subscribers, your SIM will be deactivated. A “deactivated SIM” cannot be used for outgoing and incoming calls, internet access, or sending and receiving of messages. Deadline falls on July 25, 2023. The deadline, however, may be extended by the Department of Information and Communications Technology.
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="300">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-4" class="collapsed">May I voluntarily request for deactivation of an already activated SIM? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-4" class="collapse" data-bs-parent=".faq-list">
                <p>
                  Yes, it is possible.
                </p>
              </div>
            </li>

          </ul>
        </div>

      </div>
    </section><!-- End Frequently Asked Questions Section -->
  
</main><!-- End #main -->

   <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container footer-top">
        <div class="copyright">
          &copy; Copyright <strong><span>OnePage</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
          <!-- All the links in the footer should remain intact. -->
          <!-- You can delete the links only if you purchased the pro version. -->
          <!-- Licensing information: https://bootstrapmade.com/license/ -->
          <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/onepage-multipurpose-bootstrap-template/ -->
          Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </div>
  </footer><!-- End Footer -->


  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  





  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/typed.js/typed.umd.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>