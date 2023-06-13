<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$firstname = $middlename = $surname = $mobile_number = $gender = $provider = $date_of_birth = $province = $city = $barangay = $street = "";
$firstname_err = $middlename_err = $surname_err = $mobile_number_err = $gender_err = $provider_err = $date_of_birth_err = $province_err = $city_err = $barangay_err = $street_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    
    // Check input errors before inserting in database
    if(empty($firstname_err) && empty($middlename_err) && empty($surname_err) && empty($mobile_number_err) && empty($gender_err) && empty($provider_err) && empty($date_of_birth_err) && empty($province_err) && empty($city_err) && empty($barangay_err) && empty($street_err)){
        // Prepare an update statement
        $sql = "UPDATE registrants SET firstname=?, middlename=?, surname=?, mobile_number=?, gender=?, provider=?, date_of_birth=?, province=?, city=?, barangay=?, street=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssssssi", $param_firstname, $param_middlename, $param_surname, $param_mobile_number, $param_gender, $param_provider, $param_date_of_birth, $param_province, $param_city, $param_barangay, $param_street, $param_id);
            
            // Set parameters
            $param_firstname = $firstname;
            $param_middlename = $middlename;
            $param_surname = $surname;
            $param_mobile_number = $mobile_number;
            $param_gender = $gender;
            $param_provider = $provider;
            $param_date_of_birth = $date_of_birth;
            $param_province = $province;
            $param_city = $city;
            $param_barangay = $barangay;
            $param_street = $street;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: admin.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM registrants WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $firstname = $row["firstname"];
                    $middlename = $row["middlename"];
                    $surname = $row["surname"];
                    $mobile_number = $row["mobile_number"];
                    $gender = $row["gender"];
                    $provider = $row["provider"];
                    $date_of_birth = $row["date_of_birth"];
                    $province = $row["province"];
                    $city = $row["city"];
                    $barangay = $row["barangay"];
                    $street = $row["street"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top">
        <div class="container d-flex align-items-center justify-content-between">

            <h1 class="logo"><a>SimReg</a></h1>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="getstarted scrollto">Update Page</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->
        </div>
   </header><!-- End Header -->
  
    <section id="hero">
        <div class="container-md shadow-lg border mt-5" data-aos="fade-up" data-aos-delay="100">
         <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/formdata" autocomplete="off">
            <div class="row mx-3">
                
                
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to the registrants record.</p>
                    <div class="col-md-6 mx-auto">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="firstname" class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstname; ?>" required>
                            <span class="invalid-feedback"><?php echo $firstname_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Middle Name</label>
                            <input type="text"name="middlename" class="form-control <?php echo (!empty($middlename_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $middlename; ?>">
                            <span class="invalid-feedback"><?php echo $middlename_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Surname</label>
                            <input type="text" name="surname" class="form-control <?php echo (!empty($surname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $surname; ?>">
                            <span class="invalid-feedback"><?php echo $surname_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Gender</label> 
                            <select name="gender" class="form-select" aria-label="Default select example">
                                <option selected disabled>select here</option>
                                <option value="<?php echo $gender = "Female"; ?>">Female</option>
                                <option value="<?php echo $gender = "Male"; ?>">Male</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Provider</label>
                            <select name="provider" class="form-select" aria-label="Default select example">
                                <option selected disabled>select here</option>
                                <option value="<?php echo $provider = "DITO"; ?>">DITO</option>
                                <option value="<?php echo $provider = "Globe"; ?>">Globe</option>
                                <option value="<?php echo $provider = "TNT"; ?>">TNT</option>
                                <option value="<?php echo $provider = "Smart"; ?>">Smart</option>
                                <option value="<?php echo $provider = "TM"; ?>">TM</option>
                                <option value="<?php echo $provider = "SUN"; ?>">SUN</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mobile Number</label>
                            <input type="text" name="mobile_number" class="form-control <?php echo (!empty($mobile_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $mobile_number; ?>">
                            <span class="invalid-feedback"><?php echo $mobile_number_err;?></span>
                        </div>
                    </div>
                    <div class="col-md-6 mx-auto">
                        <div class="form-group">
                            <label>Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control <?php echo (!empty($date_of_birth_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date_of_birth; ?>">
                            <span class="invalid-feedback"><?php echo $date_of_birth_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Province</label> 
                            <select name="province" class="form-select" aria-label="Default select example">
                                <option selected disabled>select here</option>
                                <option value="<?php echo $province = "Camarines Sur"; ?>">Camarines Sur</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>City/Municipality</label> 
                            <select name="city" class="form-select" aria-label="Default select example">
                                <option selected disabled>select here</option>
                                <option value="<?php echo $city = "Iriga City"; ?>">Iriga City</option>
                                <option value="<?php echo $city = "Baao"; ?>">Baao</option>
                                <option value="<?php echo $city = "Buhi"; ?>">Buhi</option>
                                <option value="<?php echo $city = "Bato"; ?>">Bato</option>
                                <option value="<?php echo $city = "Balatan"; ?>">Balatan</option>
                                <option value="<?php echo $city = "Nabua"; ?>">Nabua</option>
                                <option value="<?php echo $city = "Bula"; ?>">Bula</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Barangay</label>
                            <input type="text" name="barangay" class="form-control <?php echo (!empty($barangay_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $barangay; ?>">
                            <span class="invalid-feedback"><?php echo $barangay_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Street</label>
                            <input type="text" name="street" class="form-control <?php echo (!empty($street_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $street; ?>">
                            <span class="invalid-feedback"><?php echo $street_err;?></span>
                        </div>
                    </div>
            </div>
                    <div class="mb-3 mx-4 modal-footer">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </div>
        </form>        
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
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>


  
</body>
</html>