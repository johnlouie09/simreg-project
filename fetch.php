<?php
  include('config.php');

  $id = $_POST['id'];
  $sql = "SELECT * FROM barangay WHERE city_id = $id";
  $result = mysqli_query($link,$sql);

  $out='';
  while($row = mysqli_fetch_assoc($result)){
    $out .= '<option>'.$row['barangay_name'].'</option>';
  }
    echo $out;
?>