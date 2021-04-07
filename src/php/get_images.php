<?php
  $err_msg = "";

  try{
    require_once('connect.php');  
    $getIMG = $pdo->prepare("SELECT * FROM biken_ministore.products");
    $getIMG -> execute();
    $IMG_row = $getIMG -> fetchALL(PDO::FETCH_ASSOC);
    echo json_encode($IMG_row);
  }catch(PDOException $e){
      $err_msg .= "something went wrong" . $e->getMessage() . "<br>";
      $err_msg .= "on line" . $e->getMessage();
      echo $err_msg;
  }
?>