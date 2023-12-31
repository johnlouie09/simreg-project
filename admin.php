<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
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

  <!-- JQuery -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>

  <!-- CDN Links --> 
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  

  <script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
  </script>

</head>
<body>
    <!-- ======= Header ======= -->
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a>Registrant Details</a></h1>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="getstarted scrollto" data-bs-toggle="modal" data-bs-target="#myModal" href="">Log Out</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Modal body -->
      <div class="modal-body">

        <h5 class="text-center">Are you sure you want to log out?</h5>

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
         <p>
            <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
            <a href="logout.php" class="btn btn-primary btn-sm">Log Out</a>
         </p>
      </div> 
    
    </div>
  </div>
</div>

  <section id="hero">
   <div class="container-fluid">
      <div class="mb-3 clearfix">
          <h2 class="pull-left">...</h2>
      </div>
         <div class="row">
            <div class="col-md-12 table-responsive">
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM registrants";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped table-hover table-sm table-responsive{-sm|-md|-lg|-xl|-xxl}" data-aos="fade-down" data-aos-delay="100">';
                                echo '<thead class="table-info">';
                                    echo "<tr>";
                                        echo "<th>Registrant ID</th>";
                                        echo "<th>First Name</th>";
                                        echo "<th>Middle Name</th>";
                                        echo "<th>Last Name</th>";
                                        echo "<th>Gender</th>";
                                        echo "<th>Provider</th>";
                                        echo "<th>Mobile Number</th>";
                                        echo "<th>Date of Birth</th>";
                                        echo "<th>Province</th>";
                                        echo "<th>City/Municipality</th>";
                                        echo "<th>Barangay</th>";
                                        echo "<th>Street</th>";
                                        echo "<th>Date Registered</th>";
                                        echo "<th>Actions</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['firstname'] . "</td>";
                                        echo "<td>" . $row['middlename'] . "</td>";
                                        echo "<td>" . $row['surname'] . "</td>";
                                        echo "<td>" . $row['gender'] . "</td>";
                                        echo "<td>" . $row['provider'] . "</td>";
                                        echo "<td>" . $row['mobile_number'] . "</td>";
                                        echo "<td>" . $row['date_of_birth'] . "</td>";
                                        echo "<td>" . $row['province'] . "</td>";
                                        echo "<td>" . $row['city'] . "</td>";
                                        echo "<td>" . $row['barangay'] . "</td>";
                                        echo "<td>" . $row['street'] . "</td>";
                                        echo "<td>" . $row['date_registered'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="update.php?id='. $row['id'] .'" class="mr-3" title="Update Registrant" data-toggle="tooltip"><span class="bi bi-person-fill-add"></span></a>';
                                            echo '<a href="delete.php?id='. $row['id'] .'" title="Delete Registrant" data-toggle="tooltip"><span class="bi bi-person-fill-dash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
             </div>
         </div>        
    </div>
  </section>

    







  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>





  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>


  
</body>
</html>