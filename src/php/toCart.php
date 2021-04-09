<?php
  $err_msg = "";
  $username = '';
  $phone = '';
  $list = '';

  try{
    require_once('connect.php');  
    if(isset($POST['username'], $POST['phone'], $POST['list'])){
      $username = $POST['username'];
      $phone = $POST['phone'];
      $list = $POST['list'];

      echo $username, $phone, $list;
    };
  }catch(PDOException $e){
      $err_msg .= "something went wrong" . $e->getMessage() . "<br>";
      $err_msg .= "on line" . $e->getMessage();
      echo $err_msg;
  }
?>