<?php
  $err_msg = "";

  try{
    require_once('connect.php');  
    if(isset($POST['username']))
  }catch(PDOException $e){
      $err_msg .= "something went wrong" . $e->getMessage() . "<br>";
      $err_msg .= "on line" . $e->getMessage();
      echo $err_msg;
  }
?>