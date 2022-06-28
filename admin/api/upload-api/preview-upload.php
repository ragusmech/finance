<?php
error_reporting(E_ALL);

function randomDigits($length){
    $numbers = range(0,9);
    shuffle($numbers);
    for($i = 0; $i < $length; $i++){
        global $digits;
        $digits .= $numbers[$i];
    }
    return $digits;
}

      $target_dir = "../../assets/images/invitations/";
      $file_name = $_FILES['file']['name'];
      $file_tmp = $_FILES['file']['tmp_name'];
      $temp = explode(".", $_FILES["file"]["name"]);
      $newfilename = 'invpreview-'.randomDigits(5).round(microtime(true)) . '.' . end($temp);

      if (move_uploaded_file($file_tmp, $target_dir . $newfilename)) {
       echo  'assets/images/invitations/' . $newfilename;
      } else {
          echo 0;
      }

         