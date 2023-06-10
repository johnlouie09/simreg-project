<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $address = $email = $mobile_number = $gender = $provider = $date_registered = "";
$name_err = $address_err = $email_err = $mobile_number_err = $gender_err = $provider_err = $date_registered_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter your email account.";     
    } else{
        $email = $input_email;
    }

    // Validate mobile number
    $input_mobile_number = trim($_POST["mobile_number"]);
    if(empty($input_mobile_number)){
        $mobile_number_err = "Please enter your mobile number.";     
    } else{
        $mobile_number = $input_mobile_number;
    }

    // Validate gender
    $input_gender = trim($_POST["gender"]);
    if(empty($input_gender)){
        $gender_err = "Please enter your gender.";     
    } else{
        $gender = $input_gender;
    }

    // Validate provider
    $input_provider = trim($_POST["provider"]);
    if(empty($input_provider)){
        $provider_err = "Please enter your provider.";     
    } else{
        $provider = $input_provider;
    }

    // Validate date registered
    $input_date_registered = trim($_POST["date_registered"]);
    if(empty($input_date_registered)){
        $date_registered_err = "Please enter the date.";     
    } else{
        $date_registered = $input_date_registered;
    }

    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($email_err) && empty($mobile_number_err) && empty($gender_err) && empty($provider_err) && empty($date_registered_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO registrants (name, address, email, mobile_number, gender, provider, date_registered) VALUES (?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_name, $param_address, $param_email, $param_mobile_number, $param_gender, $param_provider, $param_date_registered);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_email = $email;
            $param_mobile_number = $mobile_number;
            $param_gender = $gender;
            $param_provider = $provider;
            $param_date_registered = $date_registered;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: success.php");
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
   
        <div class="container-md shadow-lg border mt-5">
         <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="row mx-3">
                
                
                    <h2 class="mt-5">Fill up this form</h2>
                    <p>Please fill this form and submit to add registrant record to the database.</p>
                    <div class="col-md-6 mx-auto">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
                    </div>
                    <div class="col-md-6 mx-auto">
                        <div class="form-group">
                            <label>Mobile Number</label>
                            <input type="number" name="mobile_number" class="form-control <?php echo (!empty($mobile_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $mobile_number; ?>">
                            <span class="invalid-feedback"><?php echo $mobile_number_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Gender</label>
                            <input type="text" name="gender" class="form-control <?php echo (!empty($gender_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $gender; ?>">
                            <span class="invalid-feedback"><?php echo $gender_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Provider</label>
                            <input type="text" name="provider" class="form-control <?php echo (!empty($provider_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $provider; ?>">
                            <span class="invalid-feedback"><?php echo $provider_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Date Registered</label>
                            <input type="datetime-local" name="date_registered" class="form-control <?php echo (!empty($date_registered_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date_registered; ?>">
                            <span class="invalid-feedback"><?php echo $date_registered_err;?></span>
                        </div>
                    </div>
                
              </div>
                <div class="mb-3 mx-4">
                    <input type="submit" class="btn btn-primary" value="Submit" href="admin.php">
                    <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                </div>
        </form>        
        </div>
    


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

